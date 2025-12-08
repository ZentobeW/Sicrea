<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Rules\DisposableEmail;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        $pendingRegistrations = $user->registrations()
            ->whereHas('transaction', function ($query) {
                $query->whereIn('status', [PaymentStatus::Pending, PaymentStatus::AwaitingVerification]);
            })
            ->count();

        $activeRefunds = Refund::query()
            ->whereHas('transaction.registration', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereIn('status', [RefundStatus::Pending])
            ->count();

        $recentRegistrations = $user->registrations()
            ->with(['event', 'transaction.refund'])
            ->latest('registered_at')
            ->paginate(5, ['*'], 'registrations');

        $recentRefunds = Refund::query()
            ->with(['transaction.registration.event'])
            ->whereHas('transaction.registration', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest('requested_at')
            ->paginate(5, ['*'], 'refunds');

        $upcomingRegistration = $user->registrations()
            ->with(['event', 'transaction'])
            ->whereHas('event', function ($query) {
                $query->where('start_at', '>=', now());
            })
            ->get()
            ->sortBy(function ($registration) {
                $startAt = $registration->event?->start_at;

                return $startAt ? $startAt->timestamp : now()->addYears(10)->timestamp;
            })
            ->first();

        return view('profile.show', [
            'user' => $user,
            'pendingRegistrations' => $pendingRegistrations,
            'activeRefunds' => $activeRefunds,
            'recentRegistrations' => $recentRegistrations,
            'recentRefunds' => $recentRefunds,
            'upcomingRegistration' => $upcomingRegistration,
        ]);
    }

    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $data = $request->safe()->except(['avatar']);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->fill($data);
        $user->save();

        return redirect()
            ->route('profile.show')
            ->with('status', 'Profil berhasil diperbarui.');
    }

    public function accountSettings(Request $request)
    {
        return view('profile.account-settings', [
            'user' => $request->user(),
        ]);
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users')->ignore($request->user()->id),
                new DisposableEmail,
            ],

            'password' => [
                'nullable',
                Password::min(8)->mixedCase()->numbers()->symbols(),
                'confirmed',
            ],
        ]);

        $user = $request->user();

        if ($request->email !== $user->email) {
            $user->new_email = $request->email;
            $user->email_verified_at = null;
            $user->save();

            // Kirim OTP ke email baru
            $this->otpService->sendToNewEmail($user, $request->email);

            // Simpan session untuk verifikasi
            $request->session()->put('pending_email_update_user_id', $user->id);

            return redirect()
                ->route('verification.email.update.notice')
                ->with('status', 'Kami mengirim OTP ke email baru untuk verifikasi.');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

}

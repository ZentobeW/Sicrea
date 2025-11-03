<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\RefundRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        $pendingRegistrations = $user->registrations()
            ->whereIn('payment_status', [PaymentStatus::Pending, PaymentStatus::AwaitingVerification])
            ->count();

        $activeRefunds = RefundRequest::query()
            ->whereHas('registration', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereIn('status', [RefundStatus::Pending, RefundStatus::Approved])
            ->count();

        $recentRegistrations = $user->registrations()
            ->with(['event', 'refundRequest'])
            ->latest('registered_at')
            ->take(5)
            ->get();

        $upcomingRegistration = $user->registrations()
            ->with('event')
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
}

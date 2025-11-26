<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\EmailOtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function __construct(
        private readonly EmailOtpService $otpService
    ) {
    }

    public function show(Request $request): RedirectResponse|View
    {
        $userId = $request->session()->get('pending_verification_user_id');
        $user = $userId ? User::find($userId) : null;

        if (! $user) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Silakan login untuk memulai verifikasi.']);
        }

        return view('auth.verify-email', [
            'user' => $user,
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $userId = $request->session()->get('pending_verification_user_id');
        $user = $userId ? User::find($userId) : null;

        if (! $user) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Sesi verifikasi berakhir. Silakan login kembali.']);
        }

        if (! $this->otpService->verify($user, $request->input('otp'))) {
            return back()
                ->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.'])
                ->withInput();
        }

        $user->markEmailAsVerified();
        $request->session()->forget('pending_verification_user_id');

        Auth::login($user);

        return redirect()
            ->route('profile.edit')
            ->with('status', 'Email terverifikasi! Lengkapi profil kamu untuk mengakses fitur.');
    }

    public function resend(Request $request): RedirectResponse
    {
        $userId = $request->session()->get('pending_verification_user_id');
        $user = $userId ? User::find($userId) : null;

        if (! $user) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Sesi verifikasi berakhir. Silakan login kembali.']);
        }

        $this->otpService->send($user);

        return back()->with('status', 'Kode OTP baru telah dikirim ke email kamu.');
    }
}

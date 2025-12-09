<?php

namespace App\Services;

use App\Mail\EmailOtpMail;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmailOtpService
{
    /**
     * Generate a new OTP, invalidate previous ones, and send to user's email.
     */
    public function send(User $user): void
    {
        $code = str_pad((string) random_int(0, 999_999), 6, '0', STR_PAD_LEFT);

        // Invalidate previous active codes
        EmailOtp::where('user_id', $user->id)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        EmailOtp::create([
            'user_id' => $user->id,
            'code' => Hash::make($code),
            'expires_at' => now()->addMinutes(15),
        ]);

        // Kirim langsung (tanpa antrean) karena beban email masih ringan
        Mail::to($user->email)->send(new EmailOtpMail($user, $code));
    }

    /**
     * Validate incoming code for a given user.
     */
    public function verify(User $user, string $code): bool
    {
        $otp = EmailOtp::where('user_id', $user->id)
            ->latest()
            ->first();

        if (! $otp || $otp->used_at || $otp->isExpired()) {
            return false;
        }

        if (! Hash::check($code, $otp->code)) {
            return false;
        }

        $otp->update(['used_at' => now()]);

        return true;
    }
}

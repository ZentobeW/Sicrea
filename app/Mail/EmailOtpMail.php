<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailOtpMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public User $user,
        public string $code
    ) {
    }

    public function build(): self
    {
        return $this->subject('Kode Verifikasi Email Kreasi Hangat')
            ->view('emails.email-otp');
    }
}

<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentProofUploaded extends Mailable
{
    use SerializesModels;

    public function __construct(public Registration $registration)
    {
    }

    public function build(): self
    {
        return $this->subject('Bukti Pembayaran Baru - ' . $this->registration->event->title)
            ->markdown('emails.payment-proof-uploaded', [
                'registration' => $this->registration,
            ]);
    }
}

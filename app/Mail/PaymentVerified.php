<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentVerified extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Registration $registration)
    {
    }

    public function build(): self
    {
        return $this->subject('Pembayaran Terverifikasi - ' . $this->registration->event->title)
            ->markdown('emails.payment-verified', [
                'registration' => $this->registration,
            ]);
    }
}

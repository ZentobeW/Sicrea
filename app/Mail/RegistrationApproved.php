<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Registration $registration)
    {
    }

    public function build(): self
    {
        return $this->subject('Pendaftaran Berhasil - ' . $this->registration->event->title)
            ->markdown('emails.registration-approved', [
                'registration' => $this->registration,
            ]);
    }
}

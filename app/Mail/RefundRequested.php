<?php

namespace App\Mail;

use App\Models\Refund;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundRequested extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Refund $refund)
    {
    }

    public function build(): self
    {
        $eventTitle = $this->refund->transaction->registration->event->title ?? 'Event';

        return $this->subject('Permintaan Refund Baru - ' . $eventTitle)
            ->markdown('emails.refund-requested', [
                'refund' => $this->refund,
            ]);
    }
}

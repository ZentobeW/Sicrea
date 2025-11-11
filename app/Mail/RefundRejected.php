<?php

namespace App\Mail;

use App\Models\Refund;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundRejected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Refund $refund)
    {
    }

    public function build(): self
    {
        $eventTitle = $this->refund->transaction->registration->event->title ?? 'Event';

        return $this->subject('Refund Ditolak - ' . $eventTitle)
            ->markdown('emails.refund-rejected', [
                'refund' => $this->refund,
            ]);
    }
}

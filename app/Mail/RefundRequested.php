<?php

namespace App\Mail;

use App\Models\RefundRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundRequested extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public RefundRequest $refund)
    {
    }

    public function build(): self
    {
        return $this->subject('Permintaan Refund Baru - ' . $this->refund->registration->event->title)
            ->markdown('emails.refund-requested', [
                'refund' => $this->refund,
            ]);
    }
}

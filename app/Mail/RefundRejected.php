<?php

namespace App\Mail;

use App\Models\RefundRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundRejected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public RefundRequest $refund)
    {
    }

    public function build(): self
    {
        return $this->subject('Refund Ditolak - ' . $this->refund->registration->event->title)
            ->markdown('emails.refund-rejected', [
                'refund' => $this->refund,
            ]);
    }
}

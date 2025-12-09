<?php

namespace App\Mail;

use App\Models\Refund;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundApproved extends Mailable
{
    use SerializesModels;

    public function __construct(public Refund $refund)
    {
    }

    public function build(): self
    {
        $eventTitle = $this->refund->transaction->registration->event->title ?? 'Event';

        return $this->subject('Refund Disetujui - ' . $eventTitle)
            ->markdown('emails.refund-approved', [
                'refund' => $this->refund,
            ]);
    }
}

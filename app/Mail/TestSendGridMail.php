<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestSendGridMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    /**
     * Envelope (judul email, from, reply-to, dll)
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SendGrid Test Email - Sicrea Dev',
        );
    }

    /**
     * Content (view yang digunakan)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.sendgrid',   // view asli, bukan view.name
        );
    }

    /**
     * Attachments (jika ada)
     */
    public function attachments(): array
    {
        return [];
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $leadType,
        public array $details,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Stellar Surge ' . $this->leadType,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.lead-received',
        );
    }
}
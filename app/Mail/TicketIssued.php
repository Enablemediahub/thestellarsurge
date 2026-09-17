<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Queue\SerializesModels;

class TicketIssued extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Collection $tickets)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->tickets->every(fn ($ticket) => (int) $ticket->amount === 0)
                ? 'Your Stellar Surge free registration'
                : 'Your Stellar Surge event tickets',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-issued',
            with: ['tickets' => $this->tickets],
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn (): string => Pdf::loadView('events.ticket-pdf', ['tickets' => $this->tickets])->output(),
                'stellar-surge-tickets-' . Str::lower($this->tickets->first()->reference) . '.pdf',
            )->withMime('application/pdf'),
        ];
    }
}

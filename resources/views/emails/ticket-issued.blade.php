<p>Hello {{ $tickets->first()->name }},</p>

<p>Your Stellar Surge ticket purchase is confirmed. Your PDF ticket bundle is attached to this email.</p>

<ul>
    @foreach ($tickets as $ticket)
        <li>{{ $ticket->event->title }} - {{ $ticket->reference }}</li>
    @endforeach
</ul>

<p>Please keep the QR code available at the venue.</p>

<p>Stellar Surge Events</p>

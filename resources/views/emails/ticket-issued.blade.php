<p>Hello {{ $tickets->first()->name }},</p>

@if ($tickets->every(fn ($ticket) => (int) $ticket->amount === 0))
    <p>Your Stellar Surge free registration is confirmed. Your PDF ticket is attached to this email.</p>
@else
    <p>Your Stellar Surge ticket purchase is confirmed. Your PDF ticket bundle is attached to this email.</p>
@endif

<ul>
    @foreach ($tickets as $ticket)
        <li>{{ $ticket->event->title }} - {{ $ticket->reference }}</li>
    @endforeach
</ul>

<p>Please keep the QR code available at the venue.</p>

<p>Stellar Surge Events</p>

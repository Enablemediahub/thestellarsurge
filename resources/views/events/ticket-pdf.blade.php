<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 28px; }
        body { color: #242124; font-family: DejaVu Sans, sans-serif; }
        .ticket { border: 2px solid #32152F; margin-bottom: 22px; padding: 24px; page-break-inside: avoid; }
        .brand { color: #32152F; font-size: 24px; font-weight: bold; }
        .gold { color: #9c7839; }
        .meta { margin-top: 18px; line-height: 1.7; }
        .qr { margin-top: 18px; width: 150px; }
    </style>
</head>
<body>
    @foreach ($tickets as $ticket)
        <section class="ticket">
            <div class="brand">Stellar Surge <span class="gold">| Event Pass</span></div>
            <h1>{{ $ticket->event->title }}</h1>
            <div class="meta">
                <strong>Ticket:</strong> {{ $ticket->reference }}<br>
                <strong>Guest:</strong> {{ $ticket->name }}<br>
                <strong>Date:</strong> {{ $ticket->event->start_at->format('d M Y, h:i A') }}<br>
                <strong>Location:</strong> {{ $ticket->event->location }}
            </div>
            @if ($ticket->qr_code)
                <img class="qr" src="data:image/svg+xml;base64,{{ $ticket->qr_code }}" alt="Ticket QR code">
            @endif
        </section>
    @endforeach
</body>
</html>

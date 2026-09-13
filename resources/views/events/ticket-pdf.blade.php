<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 0; size: 360pt 220pt; }
        body { margin: 0; color: #242124; font-family: DejaVu Sans, sans-serif; }
        .ticket { position: relative; width: 360pt; height: 220pt; box-sizing: border-box; border: 2px solid #32152F; padding: 18pt; page-break-after: always; overflow: hidden; background: #fffaf4; }
        .watermark { position: absolute; top: 88pt; left: 78pt; color: rgba(50, 21, 47, 0.06); font-size: 30pt; font-weight: bold; transform: rotate(-18deg); }
        .coupon-content { position: relative; z-index: 1; }
        .details { display: inline-block; width: 235pt; vertical-align: top; }
        .security { display: inline-block; width: 75pt; border-left: 1px dashed #C8A46A; padding-left: 12pt; text-align: center; vertical-align: top; }
        .brand { color: #32152F; font-size: 16pt; font-weight: bold; }
        .gold { color: #9c7839; }
        h1 { color: #32152F; font-size: 17pt; margin: 18pt 0 8pt; }
        .meta { font-size: 9pt; line-height: 1.6; }
        .serial-label { color: #32152F; font-size: 6pt; letter-spacing: 1.3pt; }
        .serial { color: #32152F; font-size: 8pt; font-weight: bold; margin-top: 5pt; word-break: break-all; }
        .qr { width: 68pt; margin-top: 13pt; }
        .integrity { color: #9c7839; font-size: 5.5pt; letter-spacing: .7pt; margin-top: 5pt; }
        .verify { color: #666; font-size: 6pt; margin-top: 8pt; }
    </style>
</head>
<body>
    @foreach ($tickets as $ticket)
        <section class="ticket">
            @php
                $security = app(\App\Services\TicketSecurityService::class);
                $payload = $security->payloadFor($ticket);
            @endphp
            <div class="watermark">STELLAR SURGE</div>
            <div class="coupon-content">
                <div class="details">
                    <div class="brand">Stellar Surge <span class="gold">| Event Pass</span></div>
                    <h1>{{ $ticket->event->title }}</h1>
                    <div class="meta">
                        <strong>Guest:</strong> {{ $ticket->name }}<br>
                        <strong>Date:</strong> {{ $ticket->event->start_at->format('d M Y, h:i A') }}<br>
                        <strong>Location:</strong> {{ $ticket->event->location }}<br>
                        <strong>Ticket type:</strong> {{ str($ticket->ticket_type)->replace('-', ' ')->title() }}
                    </div>
                </div><div class="security">
                    <div class="serial-label">SECURE SERIAL</div>
                    <div class="serial">{{ $ticket->reference }}</div>
                    @if ($ticket->qr_code)
                        <img class="qr" src="data:image/svg+xml;base64,{{ $ticket->qr_code }}" alt="Ticket QR code">
                    @endif
                    <div class="integrity">INTEGRITY {{ $security->integrityCodeFor($payload) }}</div>
                    <div class="verify">Scan to verify</div>
                </div>
            </div>
        </section>
    @endforeach
</body>
</html>

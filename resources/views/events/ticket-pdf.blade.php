<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 0; size: 640pt 420pt; }
        body { margin: 0; color: #29262a; font-family: DejaVu Sans, sans-serif; }
        .ticket { width: 100%; border: 1pt solid #32152F; box-sizing: border-box; page-break-after: always; page-break-inside: avoid; background: #fffaf4; }
        .ticket:last-child { page-break-after: auto; }
        .top-rule { height: 7pt; background: #32152F; }
        .content { padding: 18pt 22pt 14pt; }
        .layout { width: 100%; border-collapse: collapse; }
        .details { width: 70%; padding-right: 20pt; vertical-align: top; }
        .security { width: 30%; border-left: 1px dashed #C8A46A; padding-left: 16pt; text-align: center; vertical-align: top; }
        .event-logo { width: 52pt; height: 37pt; }
        .brand { color: #32152F; font-size: 19pt; font-weight: bold; }
        .eyebrow { color: #9c7839; font-size: 6pt; font-weight: bold; letter-spacing: 1.2pt; margin-top: 3pt; }
        h1 { color: #32152F; font-size: 22pt; line-height: 1.1; margin: 10pt 0 9pt; }
        .meta { font-size: 9pt; line-height: 1.35; }
        .meta-label { color: #777174; font-size: 5.5pt; font-weight: bold; letter-spacing: .7pt; text-transform: uppercase; }
        .price-box { margin-top: 9pt; padding: 7pt 11pt; border-left: 4pt solid #C8A46A; background: #f2e8d8; }
        .price-label { color: #6d5a3e; font-size: 5.5pt; font-weight: bold; letter-spacing: .9pt; }
        .price { color: #32152F; font-size: 18pt; font-weight: bold; margin-top: 2pt; }
        .serial-label { color: #32152F; font-size: 5.5pt; font-weight: bold; letter-spacing: 1pt; }
        .serial { color: #32152F; font-size: 7pt; font-weight: bold; margin-top: 4pt; word-break: break-all; }
        .qr { width: 90pt; height: 90pt; margin-top: 12pt; }
        .integrity { color: #9c7839; font-size: 5pt; letter-spacing: .5pt; margin-top: 4pt; }
        .verify { color: #666; font-size: 5.5pt; margin-top: 6pt; }
        .footer { color: #777174; font-size: 6pt; letter-spacing: .4pt; margin-top: 10pt; }
    </style>
</head>
<body>
    @foreach ($tickets as $ticket)
        <section class="ticket">
            @php
                $security = app(\App\Services\TicketSecurityService::class);
                $payload = $security->payloadFor($ticket);
                $eventLogo = base64_encode(file_get_contents(public_path('logos/Events.png')));
            @endphp
            <div class="top-rule"></div>
            <div class="content">
                <table class="layout">
                    <tr>
                        <td class="details">
                            <img class="event-logo" width="52" height="37" src="data:image/png;base64,{{ $eventLogo }}" alt="Stellar Surge Events">
                            <div class="brand">Stellar Surge</div>
                            <div class="eyebrow">OFFICIAL EVENT PASS</div>
                            <h1>{{ $ticket->event->title }}</h1>
                            <div class="meta">
                                <span class="meta-label">Guest</span><br>{{ $ticket->name }}<br>
                                <span class="meta-label">Date &amp; time</span><br>{{ $ticket->event->start_at->format('d M Y, h:i A') }}<br>
                                <span class="meta-label">Location</span><br>{{ $ticket->event->location }}
                            </div>
                            <div class="price-box">
                                <div class="price-label">TICKET PRICE</div>
                                <div class="price">{{ $ticket->currency }} {{ number_format((float) $ticket->amount, 2) }}</div>
                            </div>
                        </td>
                        <td class="security">
                            <div class="serial-label">SECURE SERIAL</div>
                            <div class="serial">{{ $ticket->reference }}</div>
                            @if ($ticket->qr_code)
                                <img class="qr" width="100" height="100" src="data:image/svg+xml;base64,{{ $ticket->qr_code }}" alt="Ticket QR code">
                            @endif
                            <div class="integrity">INTEGRITY {{ $security->integrityCodeFor($payload) }}</div>
                            <div class="verify">Scan to verify</div>
                        </td>
                    </tr>
                </table>
                <div class="footer">{{ str($ticket->ticket_type)->replace('-', ' ')->title() }} &nbsp;|&nbsp; KEEP THIS PASS SAFE</div>
            </div>
        </section>
    @endforeach
</body>
</html>

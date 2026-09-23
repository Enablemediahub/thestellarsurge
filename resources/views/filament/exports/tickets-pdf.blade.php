<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; }
        h1 { color: #32152F; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d8cbbd; padding: 5px; text-align: left; }
        th { background: #32152F; color: white; }
    </style>
</head>
<body>
    <h1>Stellar Surge Tickets</h1>
    <table>
        <thead><tr><th>Reference</th><th>Event</th><th>Name</th><th>Email</th><th>Phone</th><th>Type</th><th>Amount</th><th>Status</th></tr></thead>
        <tbody>
        @foreach ($tickets as $ticket)
            <tr>
                <td>{{ $ticket->reference }}</td>
                <td>{{ $ticket->event?->title }}</td>
                <td>{{ $ticket->name }}</td>
                <td>{{ $ticket->email }}</td>
                <td>{{ $ticket->formatted_phone }}</td>
                <td>{{ $ticket->ticket_type }}</td>
                <td>{{ $ticket->currency }} {{ number_format((float) $ticket->amount, 2) }}</td>
                <td>{{ $ticket->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
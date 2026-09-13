<?php

namespace App\Services;

use App\Models\Ticket;
use Twilio\Rest\Client;

class TicketDeliveryService
{
    public function sendWhatsApp(Ticket $ticket): void
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.whatsapp_from');

        if (! $sid || ! $token || ! $from || ! $ticket->phone) {
            return;
        }

        $to = str_starts_with($ticket->phone, 'whatsapp:') ? $ticket->phone : 'whatsapp:' . $ticket->phone;

        (new Client($sid, $token))->messages->create($to, [
            'from' => $from,
            'body' => "Stellar Surge ticket confirmed: {$ticket->event->title}. Ticket reference: {$ticket->reference}. Please keep your PDF ticket and QR code ready at the venue.",
        ]);
    }
}

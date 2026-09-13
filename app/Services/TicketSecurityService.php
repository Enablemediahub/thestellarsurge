<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketSecurityService
{
    public function payloadFor(Ticket $ticket): string
    {
        return $this->encode([
            'v' => 1,
            'ticket_id' => $ticket->id,
            'reference' => $ticket->reference,
            'event_id' => $ticket->event_id,
        ]);
    }

    public function previewPayloadFor(Event $event): string
    {
        return $this->encode([
            'v' => 1,
            'ticket_id' => 'preview',
            'reference' => 'PREVIEW-' . $event->id,
            'event_id' => $event->id,
        ]);
    }

    public function qrSvgFor(string $payload, int $size = 180): string
    {
        return base64_encode(QrCode::format('svg')->size($size)->generate($payload));
    }

    public function verificationUrlFor(string $payload, ?Request $request = null): string
    {
        $request ??= request();
        $routeName = $request->getHost() === 'events.thestellarsurge.com'
            ? 'events.ticket.verify'
            : (str_starts_with($request->getRequestUri(), '/thestellarsurge/public') ? 'events.ticket.verify.path' : 'events.ticket.verify.local');

        return route($routeName) . '?' . http_build_query(['token' => $payload]);
    }

    public function integrityCodeFor(string $payload): string
    {
        return strtoupper(substr(hash_hmac('sha256', $payload, $this->key()), 0, 10));
    }

    public function verify(string $payload): ?array
    {
        [$encodedClaims, $signature] = array_pad(explode('.', $payload, 2), 2, null);

        if (! $encodedClaims || ! $signature) {
            return null;
        }

        $expectedSignature = $this->base64UrlEncode(hash_hmac('sha256', $encodedClaims, $this->key(), true));

        if (! hash_equals($expectedSignature, $signature)) {
            return null;
        }

        $claims = json_decode(base64_decode(strtr($encodedClaims, '-_', '+/')), true);

        return is_array($claims) ? $claims : null;
    }

    private function encode(array $claims): string
    {
        $encodedClaims = $this->base64UrlEncode(json_encode($claims, JSON_THROW_ON_ERROR));
        $signature = $this->base64UrlEncode(hash_hmac('sha256', $encodedClaims, $this->key(), true));

        return $encodedClaims . '.' . $signature;
    }

    private function key(): string
    {
        return (string) config('app.key');
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
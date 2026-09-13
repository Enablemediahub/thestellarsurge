<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\Ticket;
use App\Services\TicketSecurityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketSecurityServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_payload_is_serialized_and_signed(): void
    {
        $event = Event::create([
            'title' => 'Secure Event',
            'slug' => 'secure-event',
            'summary' => 'Secure event.',
            'description' => 'Secure event.',
            'start_at' => '2026-12-01 18:00:00',
            'location' => 'Accra, Ghana',
            'is_published' => true,
            'price' => 100,
            'currency' => 'GHS',
        ]);
        $ticket = Ticket::create([
            'event_id' => $event->id,
            'reference' => 'TCK-SECURE123',
            'email' => 'guest@example.com',
            'name' => 'Guest',
            'phone' => '+233240000000',
            'whatsapp_confirmed' => true,
            'amount' => 100,
            'currency' => 'GHS',
            'status' => 'paid',
        ]);

        $payload = app(TicketSecurityService::class)->payloadFor($ticket);

        $security = app(TicketSecurityService::class);

        $this->assertCount(2, explode('.', $payload));
        $this->assertSame('TCK-SECURE123', $security->verify($payload)['reference']);
        $this->assertNull($security->verify($payload . 'edited'));
        $this->assertStringContainsString('/events/tickets/verify?token=', $security->verificationUrlFor($payload));
    }
}
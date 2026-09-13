<?php

namespace Tests\Feature\Events;

use App\Models\Event;
use App\Models\Testimonial;
use App\Models\Subscriber;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\SiteSetting;
use App\Services\TicketSecurityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EventsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_events_index_displays_featured_events(): void
    {
        Event::create([
            'title' => 'Creative Motion Night',
            'slug' => 'creative-motion-night',
            'summary' => 'A premium night of sound and storytelling.',
            'description' => 'An immersive event for creators and culture lovers.',
            'start_at' => '2026-10-12 18:00:00',
            'end_at' => '2026-10-12 22:00:00',
            'location' => 'Accra, Ghana',
            'is_published' => true,
            'price' => 120000,
            'currency' => 'NGN',
            'banner_image' => 'https://example.com/banner.jpg',
        ]);

        $response = $this->get('/events');

        $response->assertOk();
        $response->assertSee('Creative Motion Night');
    }

    public function test_event_detail_page_renders_for_a_valid_slug(): void
    {
        Event::create([
            'title' => 'Her Next Chapter',
            'slug' => 'her-next-chapter',
            'summary' => 'A bold gathering for women building businesses.',
            'description' => 'For women shaping what comes next.',
            'start_at' => '2026-11-02 18:00:00',
            'end_at' => '2026-11-02 21:30:00',
            'location' => 'Lagos, Nigeria',
            'is_published' => true,
            'price' => 150000,
            'currency' => 'NGN',
            'banner_image' => 'https://example.com/her-next-chapter.jpg',
        ]);

        $response = $this->get('/events/her-next-chapter');

        $response->assertOk();
        $response->assertSee('Her Next Chapter');
    }

    public function test_homepage_shows_uploaded_featured_event_flyers(): void
    {
        Event::create([
            'title' => 'Creative Motion Night',
            'slug' => 'creative-motion-night',
            'summary' => 'A premium night of sound and storytelling.',
            'description' => 'An immersive event for creators and culture lovers.',
            'start_at' => '2026-10-12 18:00:00',
            'end_at' => '2026-10-12 22:00:00',
            'location' => 'Accra, Ghana',
            'is_published' => true,
            'featured' => true,
            'price' => 120000,
            'currency' => 'NGN',
            'banner_image' => 'https://example.com/creative-motion-flyer.jpg',
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('https://example.com/creative-motion-flyer.jpg');
    }

    public function test_homepage_only_shows_approved_testimonials(): void
    {
        Testimonial::create([
            'quote' => 'This should stay private.',
            'author' => 'Pending voice',
            'is_approved' => false,
        ]);

        Testimonial::create([
            'quote' => 'Stellar Surge made the experience unforgettable.',
            'author' => 'A community builder',
            'role' => 'Creative leader',
            'is_approved' => true,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Stellar Surge made the experience unforgettable.');
        $response->assertDontSee('This should stay private.');
    }

    public function test_visitors_can_submit_testimonials_and_subscribe(): void
    {
        $this->post('/testimonials', [
            'quote' => 'The experience was beautifully organized.',
            'author' => 'Ama Mensah',
            'role' => 'Community builder',
        ])->assertRedirect();

        $this->post('/subscribe', [
            'name' => 'Ama Mensah',
            'email' => 'ama@example.com',
        ])->assertRedirect();

        $this->assertDatabaseHas('testimonials', [
            'author' => 'Ama Mensah',
            'is_approved' => false,
        ]);
        $this->assertDatabaseHas('subscribers', [
            'email' => 'ama@example.com',
            'is_subscribed' => true,
        ]);
    }

    public function test_local_public_path_portals_are_available(): void
    {
        $this->get('/thestellarsurge/public/events')->assertOk();
        $this->get('/thestellarsurge/public/entrepreneurship')->assertOk();
        $this->get('/thestellarsurge/public/training')->assertOk();
    }

    public function test_featured_event_is_promoted_to_events_billboard(): void
    {
        Event::create([
            'title' => 'Featured Surge Night',
            'slug' => 'featured-surge-night',
            'summary' => 'The flagship Stellar Surge experience.',
            'description' => 'A featured program.',
            'start_at' => '2026-10-12 18:00:00',
            'location' => 'Accra, Ghana',
            'is_published' => true,
            'featured' => true,
            'price' => 100,
            'currency' => 'GHS',
            'banner_image' => 'https://example.com/featured.jpg',
        ]);

        $response = $this->get('/events');

        $response->assertOk();
        $response->assertSee('Featured program');
        $response->assertSee('Featured Surge Night');
        $response->assertSee('https://example.com/featured.jpg');
    }

    public function test_featured_events_are_first_in_the_public_thumbnail_order(): void
    {
        Event::create([
            'title' => 'Regular Later Event',
            'slug' => 'regular-later-event',
            'summary' => 'A regular event.',
            'description' => 'A regular event.',
            'start_at' => '2026-10-01 18:00:00',
            'location' => 'Accra, Ghana',
            'is_published' => true,
            'price' => 100,
            'currency' => 'GHS',
        ]);
        Event::create([
            'title' => 'Featured First Event',
            'slug' => 'featured-first-event',
            'summary' => 'A featured event.',
            'description' => 'A featured event.',
            'start_at' => '2026-12-01 18:00:00',
            'location' => 'Accra, Ghana',
            'is_published' => true,
            'featured' => true,
            'price' => 100,
            'currency' => 'GHS',
        ]);

        $this->get('/events')
            ->assertOk()
            ->assertSeeInOrder(['Featured First Event', 'Regular Later Event']);
    }

    public function test_event_ticket_options_and_location_link_render(): void
    {
        Event::create([
            'title' => 'Ticket Options Showcase',
            'slug' => 'ticket-options-showcase',
            'summary' => 'Choose your experience.',
            'description' => 'A ticketed showcase.',
            'start_at' => '2026-10-20 18:00:00',
            'location' => 'Accra, Ghana',
            'venue' => 'Stellar Hall',
            'location_url' => 'https://maps.google.com/?q=Accra',
            'ticket_options' => [
                ['name' => 'VIP', 'price' => 500],
                ['name' => 'Regular', 'price' => 250],
            ],
            'is_published' => true,
            'price' => 250,
            'currency' => 'GHS',
        ]);

        $this->get('/events/ticket-options-showcase')
            ->assertOk()
            ->assertSee('Open location in Google Maps');

        $this->get('/events/ticket-options-showcase/checkout')
            ->assertOk()
            ->assertSee('VIP')
            ->assertSee('Regular');
    }

    public function test_checkout_requires_whatsapp_confirmation(): void
    {
        Event::create([
            'title' => 'WhatsApp Confirmation Event',
            'slug' => 'whatsapp-confirmation-event',
            'summary' => 'A ticketed event.',
            'description' => 'A ticketed event.',
            'start_at' => '2026-10-20 18:00:00',
            'location' => 'Accra, Ghana',
            'is_published' => true,
            'price' => 250,
            'currency' => 'GHS',
        ]);

        $this->from('/events/whatsapp-confirmation-event/checkout')
            ->post('/events/whatsapp-confirmation-event/checkout', [
                'name' => 'Ama Mensah',
                'email' => 'ama@example.com',
                'phone' => '+233240000000',
                'quantity' => 1,
                'ticket_type' => 'standard',
            ])
            ->assertRedirect('/events/whatsapp-confirmation-event/checkout')
            ->assertSessionHasErrors('whatsapp_confirmed');

        $this->assertDatabaseCount('tickets', 0);
    }

    public function test_demo_payment_issues_tickets_without_calling_paystack(): void
    {
        config(['services.paystack.mode' => 'demo']);
        Mail::fake();

        $event = Event::create([
            'title' => 'Demo Payment Event',
            'slug' => 'demo-payment-event',
            'summary' => 'A demo ticketed event.',
            'description' => 'A demo ticketed event.',
            'start_at' => '2026-10-20 18:00:00',
            'location' => 'Accra, Ghana',
            'is_published' => true,
            'price' => 250,
            'currency' => 'GHS',
        ]);

        $response = $this->post('/events/demo-payment-event/checkout', [
            'name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone' => '+233240000000',
            'whatsapp_confirmed' => 1,
            'quantity' => 1,
            'ticket_type' => 'standard',
        ]);

        $payment = Payment::query()->where('event_id', $event->id)->firstOrFail();
        $ticket = Ticket::query()->where('event_id', $event->id)->firstOrFail();

        $response->assertRedirect(route('events.success.local', ['slug' => $event->slug, 'reference' => $payment->reference]));
        $this->assertSame('success', $payment->status);
        $this->assertSame('paid', $ticket->status);
        $this->assertNotEmpty($ticket->qr_code);
        Mail::assertSent(\App\Mail\TicketIssued::class);
    }

    public function test_paid_ticket_can_be_verified_from_signed_scan_url(): void
    {
        $event = Event::create([
            'title' => 'Verification Event',
            'slug' => 'verification-event',
            'summary' => 'Verification event.',
            'description' => 'Verification event.',
            'start_at' => '2026-10-20 18:00:00',
            'location' => 'Accra, Ghana',
            'is_published' => true,
            'price' => 250,
            'currency' => 'GHS',
        ]);
        $ticket = Ticket::create([
            'event_id' => $event->id,
            'reference' => 'TCK-VERIFY123',
            'email' => 'guest@example.com',
            'name' => 'Guest',
            'phone' => '+233240000000',
            'whatsapp_confirmed' => true,
            'amount' => 250,
            'currency' => 'GHS',
            'status' => 'paid',
        ]);
        $token = app(TicketSecurityService::class)->payloadFor($ticket);

        $this->get('/events/tickets/verify?token=' . urlencode($token))
            ->assertOk()
            ->assertSee('Authentic paid ticket')
            ->assertSee('Verify ticket for entry');

        $this->post('/events/tickets/verify', ['token' => $token])
            ->assertRedirect();

        $ticket->refresh();
        $this->assertTrue($ticket->verified);
        $this->assertNotNull($ticket->verified_at);

        $this->get('/events/tickets/verify?token=' . urlencode($token))
            ->assertOk()
            ->assertSee('Already verified');
    }

    public function test_unpaid_ticket_cannot_be_verified(): void
    {
        $event = Event::create([
            'title' => 'Unpaid Verification Event',
            'slug' => 'unpaid-verification-event',
            'summary' => 'Unpaid event.',
            'description' => 'Unpaid event.',
            'start_at' => '2026-10-20 18:00:00',
            'location' => 'Accra, Ghana',
            'is_published' => true,
            'price' => 250,
            'currency' => 'GHS',
        ]);
        $ticket = Ticket::create([
            'event_id' => $event->id,
            'reference' => 'TCK-UNPAID123',
            'email' => 'guest@example.com',
            'name' => 'Guest',
            'phone' => '+233240000000',
            'whatsapp_confirmed' => true,
            'amount' => 250,
            'currency' => 'GHS',
            'status' => 'pending',
        ]);
        $token = app(TicketSecurityService::class)->payloadFor($ticket);

        $this->post('/events/tickets/verify', ['token' => $token])
            ->assertSessionHas('verification_error');

        $this->assertFalse($ticket->fresh()->verified);
    }

    public function test_ticket_scanner_portal_can_be_enabled_or_disabled(): void
    {
        SiteSetting::create([
            'site_name' => 'Stellar Surge',
            'ticket_scanner_enabled' => true,
        ]);

        $this->get('/events/tickets/')->assertOk()->assertSee('Ticket scanner');
        $this->get('/ticket-scanner-manifest.json')->assertOk();

        SiteSetting::query()->update(['ticket_scanner_enabled' => false]);

        $this->get('/events/tickets/')->assertNotFound();
    }
}

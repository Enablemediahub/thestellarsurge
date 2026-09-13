<?php

namespace Tests\Feature\Events;

use App\Models\Event;
use App\Models\Testimonial;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}

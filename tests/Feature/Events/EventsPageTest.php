<?php

namespace Tests\Feature\Events;

use App\Models\Event;
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
}

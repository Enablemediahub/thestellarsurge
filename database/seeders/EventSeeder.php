<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'A Night of Creative Motion',
                'slug' => 'a-night-of-creative-motion',
                'summary' => 'A premium experience blending culture, sound, storytelling and community.',
                'description' => "An evening of performances, creative networking and energy-led experiences for culture lovers.",
                'start_at' => '2026-10-12 18:00:00',
                'end_at' => '2026-10-12 22:00:00',
                'location' => 'Accra, Ghana',
                'venue' => 'The Dome, Accra',
                'price' => 120000,
                'currency' => 'NGN',
                'banner_image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
                'featured' => true,
            ],
            [
                'title' => 'Her Next Chapter',
                'slug' => 'her-next-chapter',
                'summary' => 'A powerful gathering for women building ideas, businesses and bold futures.',
                'description' => "A story-led event for women in business, leadership, and creative enterprise.",
                'start_at' => '2026-11-02 18:30:00',
                'end_at' => '2026-11-02 21:30:00',
                'location' => 'Lagos, Nigeria',
                'venue' => 'Lagos Innovation Hub',
                'price' => 150000,
                'currency' => 'NGN',
                'banner_image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
                'featured' => true,
            ],
            [
                'title' => 'Stellar Foundations',
                'slug' => 'stellar-foundations',
                'summary' => 'A transformation-focused event for emerging creators and entrepreneurs.',
                'description' => "A practical, community-driven event centered on business foundations, confidence, and momentum.",
                'start_at' => '2026-12-14 10:00:00',
                'end_at' => '2026-12-14 16:00:00',
                'location' => 'Kumasi, Ghana',
                'venue' => 'Kumasi Creative Spaces',
                'price' => 90000,
                'currency' => 'NGN',
                'banner_image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
                'featured' => true,
            ],
        ];

        foreach ($events as $event) {
            Event::query()->updateOrCreate(['slug' => $event['slug']], $event);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'logo_path',
        'favicon_path',
        'hero_slides',
        'events_logo_path',
        'events_hero_image',
        'growth_logo_path',
        'growth_hero_image',
        'training_logo_path',
        'training_hero_image',
        'events_color',
        'growth_color',
        'training_color',
        'plum_color',
        'gold_color',
        'ivory_color',
        'contact_email',
        'whatsapp_number',
        'social_links',
        'footer_credit',
        'ticket_scanner_enabled',
    ];

    protected $casts = [
        'hero_slides' => 'array',
        'social_links' => 'array',
        'ticket_scanner_enabled' => 'boolean',
    ];

    public function mediaUrl(?string $path, ?string $fallback = null): ?string
    {
        if (! $path) {
            return $fallback;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'logos/')) {
            return asset($path);
        }

        return url('storage/' . ltrim($path, '/'));
    }

    public function heroSlidesForDisplay(): array
    {
        $slides = $this->hero_slides ?: [
                'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1600&q=80',
                'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1600&q=80',
                'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1600&q=80',
            ];

        return collect($slides)
            ->map(fn (string $path) => $this->mediaUrl($path))
            ->filter()
            ->values()
            ->all();
    }

    public static function current(): self
    {
        return static::query()->first() ?: new static([
            'site_name' => 'Stellar Surge',
            'logo_path' => 'logos/Main logo.png',
            'favicon_path' => 'logos/Main logo.png',
            'events_logo_path' => 'logos/Events.png',
            'growth_logo_path' => 'logos/Entrepreneirship.png',
            'training_logo_path' => 'logos/Training.png',
            'events_color' => '#E17B7C',
            'growth_color' => '#F9AD2D',
            'training_color' => '#159D99',
            'plum_color' => '#32152F',
            'gold_color' => '#C8A46A',
            'ivory_color' => '#F7F2E9',
            'social_links' => [],
            'ticket_scanner_enabled' => true,
        ]);
    }
}

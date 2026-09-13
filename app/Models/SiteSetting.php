<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'logo_path',
        'favicon_path',
        'hero_slides',
        'events_logo_path',
        'growth_logo_path',
        'training_logo_path',
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
    ];

    protected $casts = [
        'hero_slides' => 'array',
        'social_links' => 'array',
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

    protected function heroSlides(): Attribute
    {
        return Attribute::make(
            get: fn (?array $value) => collect($value ?: [
                'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1600&q=80',
                'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1600&q=80',
                'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1600&q=80',
            ])->map(fn (string $path) => $this->mediaUrl($path))->values()->all(),
        );
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
        ]);
    }
}

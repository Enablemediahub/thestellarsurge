<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'start_at',
        'end_at',
        'location',
        'venue',
        'location_url',
        'price',
        'ticket_options',
        'currency',
        'banner_image',
        'is_published',
        'featured',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_published' => 'boolean',
        'featured' => 'boolean',
        'price' => 'integer',
        'ticket_options' => 'array',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function bannerImageUrl(): ?string
    {
        if (! $this->banner_image) {
            return null;
        }

        if (str_starts_with($this->banner_image, 'http://') || str_starts_with($this->banner_image, 'https://')) {
            return $this->banner_image;
        }

        return url('storage/' . ltrim($this->banner_image, '/'));
    }

    public function ticketOptions(): array
    {
        $options = collect($this->ticket_options ?: [])
            ->filter(fn (array $option): bool => filled($option['name'] ?? null) && is_numeric($option['price'] ?? null))
            ->map(fn (array $option): array => [
                'name' => $option['name'],
                'slug' => $option['slug'] ?? Str::slug($option['name']),
                'price' => (int) $option['price'],
            ])
            ->values()
            ->all();

        return $options ?: [[
            'name' => 'Standard',
            'slug' => 'standard',
            'price' => (int) $this->price,
        ]];
    }
}

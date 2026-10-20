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
        'discount_price',
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
        'discount_price' => 'integer',
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

    public function freeRegistrationLinks(): HasMany
    {
        return $this->hasMany(FreeRegistrationLink::class);
    }

    public function activeFreeRegistrationLink(): ?FreeRegistrationLink
    {
        return $this->freeRegistrationLinks()
            ->where('expires_at', '>', now())
            ->whereColumn('registrations_used', '<', 'registration_limit')
            ->latest()
            ->first();
    }

    public function galleryItems(): HasMany
    {
        return $this->hasMany(EventGalleryItem::class)->orderBy('category')->orderBy('sort_order');
    }

    public function bannerImageUrl(): ?string
    {
        if (! $this->banner_image) {
            return null;
        }

        if (str_starts_with($this->banner_image, 'http://') || str_starts_with($this->banner_image, 'https://')) {
            return $this->banner_image;
        }

        $host = request()->getHost();
        $storageBaseUrl = in_array($host, [
            'events.thestellarsurge.com',
            'entrepreneurship.thestellarsurge.com',
            'training.thestellarsurge.com',
        ])
            ? 'https://thestellarsurge.com'
            : rtrim(url('/'), '/');

        return $storageBaseUrl . '/storage/' . ltrim($this->banner_image, '/');
    }

    public function ticketOptions(): array
    {
        $options = collect($this->ticket_options ?: [])
            ->filter(fn (array $option): bool => filled($option['name'] ?? null) && is_numeric($option['price'] ?? null))
            ->map(fn (array $option): array => $this->formatTicketOption(
                $option['name'],
                $option['slug'] ?? Str::slug($option['name']),
                (int) $option['price'],
                $option['discount_price'] ?? null,
            ))
            ->values()
            ->all();

        return $options ?: [
            $this->formatTicketOption('Standard', 'standard', (int) $this->price, $this->discount_price),
        ];
    }

    private function formatTicketOption(string $name, string $slug, int $price, mixed $discountPrice): array
    {
        $discountPrice = is_numeric($discountPrice) ? (int) $discountPrice : null;
        $isDiscounted = $discountPrice !== null && $discountPrice >= 0 && $discountPrice < $price;

        return [
            'name' => $name,
            'slug' => $slug,
            'original_price' => $price,
            'price' => $isDiscounted ? $discountPrice : $price,
            'is_discounted' => $isDiscounted,
        ];
    }

    public function isFree(): bool
    {
        return collect($this->ticketOptions())->every(fn (array $option): bool => (int) $option['price'] === 0);
    }
}

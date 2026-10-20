<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventDiscountLink extends Model
{
    protected $fillable = [
        'event_id',
        'created_by',
        'label',
        'token_hash',
        'encrypted_token',
        'usage_limit',
        'usage_count',
        'expires_at',
    ];

    protected $casts = [
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'expires_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function remainingUses(): ?int
    {
        return $this->usage_limit === null
            ? null
            : max(0, $this->usage_limit - $this->usage_count);
    }

    public function isAvailable(): bool
    {
        return ($this->expires_at === null || $this->expires_at->isFuture())
            && ($this->usage_limit === null || $this->usage_count < $this->usage_limit);
    }
}

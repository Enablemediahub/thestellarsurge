<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FreeRegistrationLink extends Model
{
    protected $fillable = [
        'event_id',
        'created_by',
        'token_hash',
        'encrypted_token',
        'registration_limit',
        'registrations_used',
        'expires_at',
    ];

    protected $casts = [
        'registration_limit' => 'integer',
        'registrations_used' => 'integer',
        'expires_at' => 'datetime',
        'encrypted_token' => 'encrypted',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function remainingRegistrations(): int
    {
        return max(0, $this->registration_limit - $this->registrations_used);
    }

    public function isAvailable(): bool
    {
        return $this->expires_at->isFuture() && $this->remainingRegistrations() > 0;
    }
}

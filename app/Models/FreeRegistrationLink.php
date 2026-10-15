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
        'group_name',
        'root_link_id',
        'generation',
        'token_hash',
        'encrypted_token',
        'registration_limit',
        'registrations_used',
        'expires_at',
    ];

    protected $casts = [
        'registration_limit' => 'integer',
        'registrations_used' => 'integer',
        'generation' => 'integer',
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

    public function rootLink(): BelongsTo
    {
        return $this->belongsTo(self::class, 'root_link_id');
    }

    public function generations(): HasMany
    {
        return $this->hasMany(self::class, 'root_link_id');
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

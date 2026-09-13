<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'reference',
        'email',
        'name',
        'phone',
        'whatsapp_confirmed',
        'ticket_type',
        'amount',
        'currency',
        'status',
        'verified',
        'verified_at',
        'qr_code',
    ];

    protected $casts = [
        'amount' => 'integer',
        'whatsapp_confirmed' => 'boolean',
        'verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Ticket $ticket): void {
            if ($ticket->isDirty('verified')) {
                $ticket->verified_at = $ticket->verified ? now() : null;
            }
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

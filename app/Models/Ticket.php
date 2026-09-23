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
            if ($ticket->isDirty('phone')) {
                $ticket->phone = static::normalizePhone($ticket->phone);
            }

            if ($ticket->isDirty('verified')) {
                $ticket->verified_at = $ticket->verified ? now() : null;
            }
        });
    }

    public static function normalizePhone(?string $phone): ?string
    {
        if (blank($phone)) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        if (str_starts_with($digits, '0') && strlen($digits) === 10) {
            return '+233' . substr($digits, 1);
        }

        if (str_starts_with($digits, '233') && strlen($digits) === 12) {
            return '+' . $digits;
        }

        return str_starts_with($phone, '+') ? '+' . $digits : $digits;
    }

    public function getFormattedPhoneAttribute(): ?string
    {
        return static::normalizePhone($this->phone);
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

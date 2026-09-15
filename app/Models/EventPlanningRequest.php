<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPlanningRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'event_type', 'consultation_preference',
        'event_date', 'guest_count', 'budget', 'message', 'status', 'admin_notes',
    ];

    protected $casts = [
        'event_date' => 'date',
        'guest_count' => 'integer',
    ];
}

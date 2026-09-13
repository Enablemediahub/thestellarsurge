<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'price',
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
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}

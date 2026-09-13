<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote',
        'author',
        'role',
        'is_approved',
        'sort_order',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'sort_order' => 'integer',
    ];
}

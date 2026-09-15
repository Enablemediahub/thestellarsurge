<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'is_published',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function coverImageUrl(): ?string
    {
        if (blank($this->cover_image)) {
            return null;
        }

        return filter_var($this->cover_image, FILTER_VALIDATE_URL)
            ? $this->cover_image
            : asset('storage/' . ltrim($this->cover_image, '/'));
    }
}

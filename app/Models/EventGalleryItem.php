<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventGalleryItem extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'category', 'image_path', 'youtube_url', 'caption', 'likes_count', 'sort_order', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];

    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
    public function comments(): HasMany { return $this->hasMany(EventGalleryComment::class); }
    public function imageUrl(): ?string { return $this->image_path ? (str_starts_with($this->image_path, 'http') ? $this->image_path : url('storage/' . ltrim($this->image_path, '/'))) : null; }
    public function youtubeVideoId(): ?string
    {
        if (! $this->youtube_url) return null;
        preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|shorts\/|embed\/))([^?&\/]+)/', $this->youtube_url, $matches);
        return $matches[1] ?? null;
    }
    public function thumbnailUrl(): ?string { return $this->youtubeVideoId() ? 'https://img.youtube.com/vi/' . $this->youtubeVideoId() . '/hqdefault.jpg' : $this->imageUrl(); }
}
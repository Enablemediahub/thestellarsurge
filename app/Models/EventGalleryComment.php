<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventGalleryComment extends Model
{
    use HasFactory;

    protected $fillable = ['event_gallery_item_id', 'name', 'email', 'body', 'is_approved'];
    protected $casts = ['is_approved' => 'boolean'];
    public function galleryItem(): BelongsTo { return $this->belongsTo(EventGalleryItem::class, 'event_gallery_item_id'); }
}
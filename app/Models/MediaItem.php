<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    protected $fillable = [
        'title',
        'type',
        'file_path',
        'external_url',
        'category',
        'description',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'image' => 'صورة',
            'video' => 'فيديو',
            'youtube_short' => 'YouTube Shorts',
            'infographic' => 'إنفوجرافيك توعوي',
            default => 'وسائط',
        };
    }
}

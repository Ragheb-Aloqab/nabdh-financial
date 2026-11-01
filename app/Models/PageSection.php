<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageSection extends Model
{
    protected $fillable = [
        'section_key',
        'title',
        'subtitle',
        'badge',
        'content',
        'button_text',
        'button_url',
        'secondary_button_text',
        'secondary_button_url',
        'image_path',
        'image_alt',
        'background_style',
        'is_visible',
        'sort_order',
        'extra_data',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'sort_order' => 'integer',
            'extra_data' => 'array',
        ];
    }

    public static function getByKey(string $key): ?self
    {
        return self::where('section_key', $key)->first();
    }

    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget('page_sections_all');
        });

        static::deleted(function () {
            Cache::forget('page_sections_all');
        });
    }
}

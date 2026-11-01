<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'detailed_description',
        'cover_image',
        'pillars',
        'target_audience',
        'trainer_name',
        'start_date',
        'end_date',
        'status',
        'delivery_mode',
        'registration_url',
        'registration_button_text',
        'sort_order',
        'is_published',
        'is_featured',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $program) {
            if (empty($program->slug)) {
                $program->slug = Str::slug($program->title);
                if (empty($program->slug)) {
                    $program->slug = 'program-' . Str::random(8);
                }
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'open' => 'متاح للتسجيل',
            'upcoming' => 'قريباً',
            'ongoing' => 'جارٍ الآن',
            'completed' => 'مكتمل',
            'archived' => 'مؤرشف',
            default => 'قادم',
        };
    }

    public function getDeliveryModeLabelAttribute(): string
    {
        return match ($this->delivery_mode) {
            'online' => 'عن بُعد',
            'in_person' => 'حضوري',
            'hybrid' => 'مدمج (حضوري وعن بُعد)',
            default => 'عن بُعد',
        };
    }
}

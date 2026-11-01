<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'title',
        'metric_value',
        'metric_suffix',
        'description',
        'icon',
        'last_updated_date',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'last_updated_date' => 'date',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderBy('id');
    }
}

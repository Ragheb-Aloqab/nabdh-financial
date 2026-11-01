<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RoadmapStep extends Model
{
    protected $fillable = [
        'step_number',
        'title',
        'description',
        'icon',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'step_number' => 'integer',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('step_number')->orderBy('sort_order');
    }
}

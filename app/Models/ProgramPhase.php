<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProgramPhase extends Model
{
    protected $fillable = [
        'phase_number',
        'title',
        'duration',
        'objectives',
        'tasks',
        'deliverables',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'phase_number' => 'integer',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('phase_number')->orderBy('sort_order');
    }
}

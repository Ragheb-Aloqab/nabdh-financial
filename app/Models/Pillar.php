<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pillar extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'icon',
        'color',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}

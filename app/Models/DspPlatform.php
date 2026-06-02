<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DspPlatform extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'brand_color', 'is_active', 'sort_order'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LicenseTier extends Model
{
    protected $fillable = [
        'name', 'slug', 'default_price', 'description', 'features',
        'default_duration_months', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'default_price' => 'decimal:2',
        'features' => 'array',
        'default_duration_months' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }
}

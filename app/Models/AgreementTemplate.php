<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementTemplate extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'type', 'body',
        'is_system', 'user_id', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeSystem(Builder $q): Builder
    {
        return $q->where('is_system', true);
    }

    public function scopeOwnedBy(Builder $q, int $userId): Builder
    {
        return $q->where('user_id', $userId);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class MarketplaceLicense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'marketplace_asset_id',
        'transaction_id',
        'license_key',
        'license_type',
        'licensed_from',
        'licensed_until',
        'payment_status',
        'license_price',
        'payment_method',
        'usage_count',
        'max_usage',
        'is_active',
    ];

    protected $casts = [
        'licensed_from' => 'datetime',
        'licensed_until' => 'datetime',
        'license_price' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(MarketplaceAsset::class, 'marketplace_asset_id');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(MarketplaceTransaction::class);
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where('payment_status', 'completed')
            ->where('licensed_until', '>=', now());
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('licensed_until', '<', now());
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    // Helper Methods
    public function isPaid(): bool
    {
        return $this->payment_status === 'completed';
    }

    public function isActive(): bool
    {
        return $this->is_active && $this->isPaid() && $this->isNotExpired();
    }

    public function isExpired(): bool
    {
        return $this->licensed_until->isPast();
    }

    public function isNotExpired(): bool
    {
        return $this->licensed_until->isFuture();
    }

    public function getDaysRemaining(): int
    {
        if ($this->isExpired()) {
            return 0;
        }
        return $this->licensed_until->diffInDays(now());
    }

    public function canBeUsed(): bool
    {
        return $this->isActive() && (!$this->max_usage || $this->usage_count < $this->max_usage);
    }

    public function recordUsage(): void
    {
        $this->update(['usage_count' => $this->usage_count + 1]);
    }

    public function recordRenewal(int $months): void
    {
        $this->update([
            'licensed_until' => $this->licensed_until->addMonths($months),
            'is_active' => true,
            'payment_status' => 'completed',
        ]);
    }

    public function generateLicenseKey(): string
    {
        $key = 'LIC-' . strtoupper(bin2hex(random_bytes(12)));
        $this->update(['license_key' => $key]);
        return $key;
    }

    public function getProgressPercentage(): float
    {
        if (!$this->max_usage || $this->max_usage === 0) {
            return 0;
        }
        return ($this->usage_count / $this->max_usage) * 100;
    }
}
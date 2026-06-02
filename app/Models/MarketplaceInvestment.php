<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class MarketplaceInvestment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'marketplace_asset_id',
        'transaction_id',
        'blocks_purchased',
        'investment_amount',
        'price_per_block',
        'ownership_percentage',
        'payment_status',
        'payment_method',
        'certificate_of_ownership',
        'expected_roi',
        'total_earned',
        'is_active',
        'wallet_address',
        'tx_hash',
    ];

    protected $casts = [
        'blocks_purchased' => 'integer',
        'investment_amount' => 'decimal:2',
        'price_per_block' => 'decimal:2',
        'ownership_percentage' => 'decimal:2',
        'expected_roi' => 'decimal:2',
        'total_earned' => 'decimal:2',
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

    public function distributions()
    {
        return $this->hasMany(InvestmentDistribution::class, 'marketplace_investment_id');
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->where('payment_status', 'completed');
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAsset(Builder $query, int $assetId): Builder
    {
        return $query->where('marketplace_asset_id', $assetId);
    }

    // Helper Methods
    public function isPaid(): bool
    {
        return $this->payment_status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    public function isFailed(): bool
    {
        return $this->payment_status === 'failed';
    }

    public function getCurrentROI(): float
    {
        if ($this->investment_amount == 0) {
            return 0;
        }
        return ($this->total_earned / (float)$this->investment_amount) * 100;
    }

    public function getPendingEarnings(): string
    {
        $lastDistribution = $this->distributions()
            ->latest('distribution_date')
            ->first();

        if (!$lastDistribution) {
            return '0.00';
        }

        $dailyEarnings = (float)$this->expected_roi / 365;
        $daysSinceLastDistribution = now()->diffInDays($lastDistribution->distribution_date);

        return number_format($dailyEarnings * $daysSinceLastDistribution, 2);
    }

    /**
     * Record earnings (called after each purchase)
     */
    public function recordEarnings(float $amount, string $reason = 'dividend'): void
    {
        InvestmentDistribution::create([
            'marketplace_investment_id' => $this->id,
            'distribution_amount' => $amount,
            'distribution_type' => $reason,
            'status' => 'completed',
            'notes' => $reason,
            'distribution_date' => now(),
        ]);

        $this->increment('total_earned', $amount);
    }

    public function generateCertificate(): string
    {
        $certificateId = 'CERT-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(8)));
        $this->update(['certificate_of_ownership' => $certificateId]);
        return $certificateId;
    }

    public function getInvestmentStatus(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        if (!$this->isPaid()) {
            return 'pending_payment';
        }

        return 'active';
    }
}
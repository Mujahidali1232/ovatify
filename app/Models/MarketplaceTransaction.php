<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class MarketplaceTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seller_id',
        'marketplace_asset_id',
        'transaction_type',
        'transaction_reference',
        'amount',
        'seller_amount',
        'platform_fee',
        'status',
        'payment_method',
        'payment_gateway_response',
        'metadata',
        'completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'seller_amount' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'payment_gateway_response' => 'json',
        'metadata' => 'json',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(MarketplaceAsset::class, 'marketplace_asset_id');
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(MarketplacePurchase::class, 'transaction_id');
    }

    public function license(): BelongsTo
    {
        return $this->belongsTo(MarketplaceLicense::class, 'transaction_id');
    }

    public function investment(): BelongsTo
    {
        return $this->belongsTo(MarketplaceInvestment::class, 'transaction_id');
    }


    // Scopes
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', 'failed');
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('transaction_type', $type);
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeBySeller(Builder $query, int $sellerId): Builder
    {
        return $query->where('seller_id', $sellerId);
    }

    public function scopeRecent(Builder $query, int $days = 30): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Helper Methods
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function markAsFailed(array $reason = []): void
    {
        $this->update([
            'status' => 'failed',
            'payment_gateway_response' => $reason,
        ]);
    }

    public function calculateFee(float $amount, float $platformFeePercentage = 5): float
    {
        return ($amount * $platformFeePercentage) / 100;
    }

    public function calculateSellerAmount(float $amount, float $platformFeePercentage = 5): float
    {
        $fee = $this->calculateFee($amount, $platformFeePercentage);
        return $amount - $fee;
    }

    public function getTransactionDetails(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->transaction_type,
            'status' => $this->status,
            'amount' => $this->amount,
            'seller_amount' => $this->seller_amount,
            'fee' => $this->platform_fee,
            'completed_at' => $this->completed_at,
        ];
    }

    public static function generateReference(): string
    {
        return 'TXN-' . date('YmdHis') . '-' . strtoupper(bin2hex(random_bytes(4)));
    }
}
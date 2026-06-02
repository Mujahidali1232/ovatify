<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class MarketplacePurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'marketplace_asset_id',
        'transaction_id',
        'purchase_price',
        'payment_method',
        'payment_status',
        'access_token',
        'download_count',
        'last_downloaded_at',
        'expires_at',
        'notes',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'download_count' => 'integer',
        'last_downloaded_at' => 'datetime',
        'expires_at' => 'datetime',
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
        return $query->where('payment_status', 'completed');
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent(Builder $query, int $days = 30): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
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

    public function canDownload(): bool
    {
        return $this->isPaid() && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function recordDownload(): void
    {
        $this->update([
            'download_count' => $this->download_count + 1,
            'last_downloaded_at' => now(),
        ]);
    }

    public function generateAccessToken(): string
    {
        $token = bin2hex(random_bytes(32));
        $this->update(['access_token' => $token]);
        return $token;
    }

    public function verifyAccessToken(string $token): bool
    {
        return hash_equals($this->access_token ?? '', $token);
    }
}
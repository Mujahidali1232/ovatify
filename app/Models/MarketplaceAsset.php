<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class MarketplaceAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'song_generation_id',
        'asset_type',
        'title',
        'thumbnail',
        'tags',
        'description',
        'sale_type',
        'price',
        'is_active',
        'preview_duration',
        'license_type',
        'price_per_license',
        'license_duration',
        'total_valuation',
        'ownership_block',
        'price_per_block',
        'max_available_blocks',
        'remaining_blocks',
        'total_investment',
        'max_earning',
        'investment_roi',
        'width_px',
        'height_px',
        'orientation',
        'file_format',
        'file_size_bytes',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'price_per_license' => 'decimal:2',
        'price_per_block' => 'decimal:2',
        'total_investment' => 'decimal:2',
        'max_earning' => 'decimal:2',
        'investment_roi' => 'decimal:2',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function songGeneration(): BelongsTo
    {
        return $this->belongsTo(SongGeneration::class, 'song_generation_id');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(MarketplacePurchase::class);
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(MarketplaceLicense::class);
    }

    public function investments(): HasMany
    {
        return $this->hasMany(MarketplaceInvestment::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(MarketplaceTransaction::class);
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeByAssetType(Builder $query, string $type): Builder
    {
        return $query->where('asset_type', $type);
    }

    public function scopeBySaleType(Builder $query, string $type): Builder
    {
        return $query->where('sale_type', $type);
    }

    public function scopeAvailableForPurchase(Builder $query): Builder
    {
        return $query->active()->where('sale_type', 'sale');
    }

    public function scopeAvailableForLicense(Builder $query): Builder
    {
        return $query->active()->where('sale_type', 'license');
    }

    public function scopeAvailableForInvestment(Builder $query): Builder
    {
        return $query->active()->where('sale_type', 'investment')->whereColumn('remaining_blocks', '>', 0);
    }

    // Helper Methods
    public function canBePurchased(): bool
    {
        return $this->is_active && $this->sale_type === 'sale' && $this->price !== null;
    }

    public function canBeLicensed(): bool
    {
        return $this->is_active && $this->sale_type === 'license' && $this->price_per_license !== null;
    }

    public function canBeInvested(): bool
    {
        return $this->is_active && $this->sale_type === 'investment' && $this->remaining_blocks > 0;
    }

    public function getTotalPurchases(): int
    {
        return $this->purchases()->count();
    }

    public function getTotalInvestmentRaised(): string
    {
        return $this->investments()->sum('investment_amount') ?? '0.00';
    }

    public function getAvailableBlocks(): int
    {
        return max(0, $this->remaining_blocks ?? 0);
    }

    public function getRemainingBlocks(): int
    {
        return max(0, $this->remaining_blocks ?? 0);
    }

    // THROUGH RELATIONSHIPS
    public function transactionsWithUsers()
    {
        return $this->hasManyThrough(
            User::class,
            MarketplaceTransaction::class,
            'marketplace_asset_id',
            'id',
            'id',
            'user_id'
        );
    }
}
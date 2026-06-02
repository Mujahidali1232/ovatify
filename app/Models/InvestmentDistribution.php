<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class InvestmentDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketplace_investment_id',
        'distribution_amount',
        'distribution_date',
        'distribution_type',
        'status',
        'notes',
    ];

    protected $casts = [
        'distribution_amount' => 'float',
        'distribution_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function investment(): BelongsTo
    {
        return $this->belongsTo(MarketplaceInvestment::class, 'marketplace_investment_id');
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('distribution_type', $type);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmount(): string
    {
        return '$' . number_format($this->distribution_amount, 2);
    }

    /**
     * Check if distribution is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if distribution is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted(): void
    {
        $this->update(['status' => 'completed']);
    }

    /**
     * Mark as pending
     */
    public function markAsPending(): void
    {
        $this->update(['status' => 'pending']);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed(): void
    {
        $this->update(['status' => 'failed']);
    }
}
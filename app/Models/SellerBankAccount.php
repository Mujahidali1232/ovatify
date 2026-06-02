<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerBankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stripe_account_id',
        'status',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setAsDefault(): void
    {
        SellerBankAccount::where('user_id', $this->user_id)
            ->update(['is_default' => false]);
        
        $this->update(['is_default' => true]);
    }

    public function isDefault(): bool
    {
        return $this->is_default;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $fillable = ['user_id','code','type','expires_at','used','meta'];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    public function user() { return $this->belongsTo(User::class); }

    public function isExpired(): bool { return $this->expires_at->isPast(); }

}

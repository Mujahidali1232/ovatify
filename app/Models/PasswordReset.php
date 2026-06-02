<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_reset_tokens';

    // Tell Laravel there is no primary key
    public $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['email', 'token', 'expires_at', 'used'];

    protected $casts = ['expires_at' => 'datetime', 'used' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}

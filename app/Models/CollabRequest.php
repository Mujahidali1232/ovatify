<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollabRequest extends Model
{
    protected $fillable = [
        'from_user_id', 'to_user_id', 'song_generation_id',
        'title', 'role', 'message', 'status', 'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function song(): BelongsTo
    {
        return $this->belongsTo(SongGeneration::class, 'song_generation_id');
    }
}

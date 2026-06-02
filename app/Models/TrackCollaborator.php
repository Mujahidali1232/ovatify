<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackCollaborator extends Model
{
    protected $fillable = [
        'song_generation_id', 'user_id', 'name', 'avatar', 'role', 'percentage',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
    ];

    public function song(): BelongsTo
    {
        return $this->belongsTo(SongGeneration::class, 'song_generation_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

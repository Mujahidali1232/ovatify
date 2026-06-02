<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributionRequest extends Model
{
    protected $fillable = [
        'user_id',
        'song_generation_id',
        'release_title',
        'artist_name',
        'release_date',
        'isrc_code',
        'cover_art',
        'platforms',
        'status',
        'distributed_at',
        'error_message',
    ];

    protected $casts = [
        'platforms' => 'array',
        'release_date' => 'date',
        'distributed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function songGeneration(): BelongsTo
    {
        return $this->belongsTo(SongGeneration::class);
    }
}

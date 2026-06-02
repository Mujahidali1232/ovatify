<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreatorSession extends Model
{
    protected $fillable = [
        'user_id', 'title', 'overview', 'cover_image', 'file_type',
        'instrumental_type', 'genre', 'tempo',
        'generated_audio', 'final_audio',
        'mix_settings', 'arrangement', 'metadata_review',
        'status',
        'published_song_generation_id', 'published_at',
    ];

    protected $casts = [
        'mix_settings' => 'array',
        'arrangement' => 'array',
        'metadata_review' => 'array',
        'tempo' => 'integer',
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ideas(): HasMany
    {
        return $this->hasMany(CreatorSessionIdea::class);
    }

    public function publishedSong(): BelongsTo
    {
        return $this->belongsTo(SongGeneration::class, 'published_song_generation_id');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_song_generation_id !== null;
    }
}

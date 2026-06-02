<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreatorSessionIdea extends Model
{
    protected $fillable = [
        'creator_session_id', 'type', 'content',
        'file_path', 'original_filename', 'file_size', 'mime_type',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(CreatorSession::class, 'creator_session_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiTask extends Model
{
    protected $fillable = [
        'user_id', 'tool', 'status', 'input', 'result',
        'source_audio', 'output_file', 'error_message',
        'creator_session_id', 'completed_at',
    ];

    protected $casts = [
        'input' => 'array',
        'result' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(CreatorSession::class, 'creator_session_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChatMessage extends Model
{
    protected $fillable = [
        'session_id',
        'from',
        'content',
    ];

    public function chatUserData(): HasOne
    {
        return $this->hasOne(ChatUserData::class, 'session_id', 'session_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatUserData extends Model
{
    protected $fillable = [
        'session_id',
        'name',
        'email',
        'phone_number',
        'city',
        'area_of_law',
        'sent_to_nuvun',
    ];

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'session_id', 'session_id');
    }
}

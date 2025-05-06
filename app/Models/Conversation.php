<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['user_id',
            'chatbot_id',
            'message',
            'response',
            'intent_tag',
            'confidence',
            'is_fallback',
];

public function chatbot()
{
    return $this->belongsTo(Chatbot::class, 'chatbot_id', 'id');
}


}

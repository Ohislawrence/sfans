<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chatbot extends Model
{
    protected $fillable = ['name', 'username', 'trained_data', 'intents_data','last_trained_at'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'username','username');
    }
}

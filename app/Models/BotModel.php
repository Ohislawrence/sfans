<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotModel extends Model
{
    protected $fillable = ['user_id','name', 'description', 'model_data', 'training_data'];

    protected $casts = [
        'training_data' => 'array',
    ];
}

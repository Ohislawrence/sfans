<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
         'user_id',
        'country',
        'city',
        'browser',
        'device',
        'os',
        'preferences',
        'age_verified',
        'is_adult',
        ];
}

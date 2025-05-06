<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliatelink extends Model
{
    protected $fillable = [
        'link',
        'offer_by',
        'cost',
        'offer_name',
        'coutries',
        'is_smartlink',
        'tags',
        'is_tangible',
    ];
    
}

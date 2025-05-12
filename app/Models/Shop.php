<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'name',
        'url',
        'slug',
        'images',
        'price',
        'discount',
        'promote_code',
        'description',
        'is_tangible',
        'offer_by',
        'countries',
        'tags'
    ];
}

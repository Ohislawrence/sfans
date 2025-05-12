<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{

    protected $fillable = [
        'user_id',
        'session_id',
        'click_time',
        'ip_address',
        'user_agent',
        'referrer',
        'source_type',
        'source_id',
        'is_converted',
        'conversion_time',
        'conversion_value',
        'device_type',
        'country_code'
    ];

    protected $casts = [
        'click_time' => 'datetime',
        'conversion_time' => 'datetime',
        'is_converted' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function source()
    {
        return match($this->source_type) {
            'affiliate_link' => $this->belongsTo(AffiliateLink::class, 'source_id'),
            'video' => $this->belongsTo(Video::class, 'source_id'),
            'shop' => $this->belongsTo(Shop::class, 'source_id'),
            default => null,
        };
    }
}

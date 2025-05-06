<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'link',
        'title',
        'slug',
        'duration',
        'thumbnail',
        'iframe',
        'tags',
        'pornstars',
        'numbers',
        'category',
        'quality',
        'channel',
        'empty',
        'date',
        'media_type',
        'likes',
        'comments',
        ];



    // Convert comma-separated tags to array
    public function getTagsAttribute()
    {
        return explode(',', $this->attributes['tags']);
    }

    // Convert comma-separated pornstars to array
    public function getPornstarsAttribute()
    {
        return explode(',', $this->attributes['pornstars']);
    }

    // Fake many-to-many relationship for tags
    public function tagItems()
    {
        return $this->tags; // Returns array from accessor above
    }

    // Fake many-to-many relationship for pornstars
    public function pornstarItems()
    {
        return $this->pornstars; // Returns array from accessor above
    }
}

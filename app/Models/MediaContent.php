<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaContent extends Model
{
    protected $fillable = [
        'media_post_id',

        'type',

        'content_ar',
        'content_en',

        'media_url',

        'sort_order',
    ];

    public function mediaPost()
    {
        return $this->belongsTo(MediaPost::class);
    }

    public function getContentAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->content_ar
            : $this->content_en;
    }
}

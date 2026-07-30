<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaPost extends Model
{
    protected $fillable = [
        'media_category_id',

        'title_ar',
        'title_en',

        'short_description_ar',
        'short_description_en',

        'content_ar',
        'content_en',

        'cover_image',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(MediaCategory::class);
    }

    public function contents()
    {
        return $this->hasMany(MediaContent::class)
            ->orderBy('sort_order');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->title_ar
            : $this->title_en;
    }

    public function getShortDescriptionAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->short_description_ar
            : $this->short_description_en;
    }

    public function getContentAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->content_ar
            : $this->content_en;
    }
}

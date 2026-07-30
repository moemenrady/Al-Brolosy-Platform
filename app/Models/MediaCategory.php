<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaCategory extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    public function posts()
    {
        return $this->hasMany(MediaPost::class);
    }

    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->name_ar
            : $this->name_en;
    }
}
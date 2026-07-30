<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamImage extends Model
{
    protected $fillable = [
        'image_path',
        'title_ar',
        'title_en',
        'type',
        'is_active',
        'sort_order',
    ];

    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->title_ar
            : $this->title_en;
    }
}

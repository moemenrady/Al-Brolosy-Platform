<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
    ];

    public function contents()
    {
        return $this->hasMany(PostContent::class)
            ->orderBy('sort_order');
    }
}
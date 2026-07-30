<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostContent extends Model
{
    protected $fillable = [
        'post_id',
        'type',
        'content',
        'sort_order',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
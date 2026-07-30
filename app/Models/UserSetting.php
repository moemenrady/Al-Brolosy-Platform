<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'identity_id',
        'theme',
        'lang'
    ];

    public function identity()
    {
        return $this->belongsTo(Identity::class);
    }
}

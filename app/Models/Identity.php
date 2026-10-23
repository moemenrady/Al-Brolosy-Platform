<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    protected $fillable = [
        'user_id',
        'guest_id',
        'ip',
        'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function setting()
    {
        return $this->hasOne(UserSetting::class);
    }

    public function behaviors()
    {
        return $this->hasMany(UserBehavior::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['name','hex','lab_l','lab_a','lab_b','model_3d'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}


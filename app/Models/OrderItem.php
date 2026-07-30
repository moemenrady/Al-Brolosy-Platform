<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id','product_id','name','price','quantity','options'
    ];

    protected $casts = [
        'options' => 'array'
    ];
}

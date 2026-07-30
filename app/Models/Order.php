<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $casts = [
        'is_deposited' => 'boolean',
    ];
    protected $fillable = [
        'user_id',
        'email',
        'first_name',
        'last_name',
        'phone',
        'address',
        'apartment',
        'city',
        'governorate',
        'postal_code',
        'total',
        'status',
        'is_deposited'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

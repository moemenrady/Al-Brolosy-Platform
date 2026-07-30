<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientHistory extends Model
{
    protected $fillable = [
        'client_id',
        'smart_card_id',
        'employee_id',
        'type',
        'status',
        'title',
        'description',
        'priority',
        'follow_up_at',
        'visible_to_client',
        'meta',
        'created_by',
        'origin',
        'device',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'meta' => 'array',
        'follow_up_at' => 'datetime',
        'visible_to_client' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function smartCard()
    {
        return $this->belongsTo(SmartCard::class);
    }
}

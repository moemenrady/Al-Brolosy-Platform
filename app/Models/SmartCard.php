<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SmartCard extends Model
{
    protected $fillable = [
        'card_number',
        'status',
        'status_note',
        'approved_at',
        'activated_at',
        'blocked_at',
        'rejected_at',
        'requested_at',
        'approved_by',
        'activated_by',
        'blocked_by',
        'rejected_by',
        'expires_at',
        'last_status_changed_at',
        'client_id',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'activated_at' => 'datetime',
        'blocked_at' => 'datetime',
        'rejected_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_status_changed_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public static function generateCardNumber()
    {
        do {
            $number = (string) random_int(100000000000000, 999999999999999);
        } while (self::where('card_number', $number)->exists());

        return $number;
    }

    public function histories()
    {
        return $this->hasMany(ClientHistory::class);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeReview(Builder $query): Builder
    {
        return $query->where('status', 'under_review');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeBlocked(Builder $query): Builder
    {
        return $query->where('status', 'blocked');
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('status', 'expired');
    }

    public function scopeCancelled(Builder $query): Builder
    {
        return $query->where('status', 'cancelled');
    }
}

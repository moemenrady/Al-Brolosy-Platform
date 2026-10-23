<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [

        /*
        |--------------------------------------------------------------------------
        | Relations
        |--------------------------------------------------------------------------
        */

        'identity_id',
        'assigned_employee_id',

        /*
        |--------------------------------------------------------------------------
        | Basic Information
        |--------------------------------------------------------------------------
        */

        'full_name',
        'phone',
        'email',
        'photo',
        'governorate',
        'city',

        /*
        |--------------------------------------------------------------------------
        | Personal Information
        |--------------------------------------------------------------------------
        */

        'marital_status',
        'family_size',

        /*
        |--------------------------------------------------------------------------
        | Real Estate Interest
        |--------------------------------------------------------------------------
        */

        'purpose',
        'unit_type',
        'project_or_city',
        'required_area',
        'bedrooms',

        /*
        |--------------------------------------------------------------------------
        | Financial
        |--------------------------------------------------------------------------
        */

        'budget',
        'payment_method',
        'expected_down_payment',

        /*
        |--------------------------------------------------------------------------
        | Purchase
        |--------------------------------------------------------------------------
        */

        'purchase_time',

        /*
        |--------------------------------------------------------------------------
        | Communication
        |--------------------------------------------------------------------------
        */

        'preferred_contact',
        'contact_time',

        /*
        |--------------------------------------------------------------------------
        | CRM
        |--------------------------------------------------------------------------
        */

        'source',
        'lead_source',
        'lead_status',
        'last_contact_at',
        'next_follow_up_at',
        'agree_marketing',
        'notes',
    ];

    protected $casts = [
        'agree_marketing' => 'boolean',
        'expected_down_payment' => 'decimal:2',
        'required_area' => 'integer',
        'bedrooms' => 'integer',
        'last_contact_at' => 'datetime',
        'next_follow_up_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function identity()
    {
        return $this->belongsTo(Identity::class);
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(User::class, 'assigned_employee_id');
    }

    public function smartCards()
    {
        return $this->hasMany(SmartCard::class);
    }

    public function activeSmartCard()
    {
        return $this->hasOne(SmartCard::class)
            ->where('status', 'active');
    }

    public function histories()
    {
        return $this->hasMany(ClientHistory::class)->latest();
    }

    public function behaviors()
    {
        return $this->hasMany(UserBehavior::class)->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeAssigned(Builder $query, ?int $employeeId = null): Builder
    {
        return $query->when(
            $employeeId,
            fn($q) => $q->where('assigned_employee_id', $employeeId)
        );
    }

    public function scopeGovernorate(Builder $query, ?string $governorate): Builder
    {
        return $query->when(
            $governorate,
            fn($q) => $q->where('governorate', $governorate)
        );
    }

    public function scopePurpose(Builder $query, ?string $purpose): Builder
    {
        return $query->when(
            $purpose,
            fn($q) => $q->where('purpose', $purpose)
        );
    }

    public function scopeUnitType(Builder $query, ?string $unitType): Builder
    {
        return $query->when(
            $unitType,
            fn($q) => $q->where('unit_type', $unitType)
        );
    }

    public function scopeBudget(Builder $query, ?string $budget): Builder
    {
        return $query->when(
            $budget,
            fn($q) => $q->where('budget', $budget)
        );
    }

    public function scopeLeadSource(Builder $query, ?string $source): Builder
    {
        return $query->when(
            $source,
            fn($q) => $q->where('lead_source', $source)
        );
    }

    public function scopeNew(Builder $query): Builder
    {
        return $query->where('lead_status', 'new');
    }

    public function scopeQualified(Builder $query): Builder
    {
        return $query->where('lead_status', 'qualified');
    }

    public function scopeWon(Builder $query): Builder
    {
        return $query->where('lead_status', 'won');
    }

    public function scopeLost(Builder $query): Builder
    {
        return $query->where('lead_status', 'lost');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUnit extends Model
{
    protected $fillable = [
        'project_id',
        'project_unit_type_id',
        'unit_number',
        'area',
        'price_per_meter',
        'unit_price',
        'status',
    ];

    protected $casts = [
        'area' => 'decimal:2',
        'price_per_meter' => 'decimal:2',
        'unit_price' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function unitType()
    {
        return $this->belongsTo(
            ProjectUnitType::class,
            'project_unit_type_id'
        );
    }

    public function getFloorAttribute()
    {
        return $this->unitType?->floor;
    }

    public function getStartAreaAttribute()
    {
        return $this->unitType?->area ?? $this->area;
    }

    public function getPricePerMeterAttribute()
    {
        return $this->unitType?->price_per_meter
            ?? $this->attributes['price_per_meter']
            ?? null;
    }

    public function getUnitPriceAttribute()
    {
        return $this->unitType?->unit_price
            ?? $this->attributes['unit_price']
            ?? null;
    }

    public function getFinishingTypeAttribute()
    {
        return $this->unitType?->finishing_type;
    }
}

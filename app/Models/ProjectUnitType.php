<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUnitType extends Model
{
    protected $fillable = [
        'project_id',
        'name_ar',
        'name_en',
        'unit_type',
        'floor',
        'area',
        'price_per_meter',
        'unit_price',
        'finishing_type',
        'total_units',
    ];

    protected $casts = [
        'area' => 'decimal:2',
        'price_per_meter' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_units' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function units()
    {
        return $this->hasMany(ProjectUnit::class);
    }

    public function getStartAreaAttribute()
    {
        return $this->area;
    }

    public function getAreaFromAttribute()
    {
        return $this->area;
    }

    public function getAreaToAttribute()
    {
        return $this->area;
    }
}

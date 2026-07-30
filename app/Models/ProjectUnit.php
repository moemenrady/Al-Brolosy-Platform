<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
class ProjectUnit extends Model
{
    protected $fillable = [
        'project_id',
        'unit_type',
        'floor',
        'start_area',
        'price_per_meter',
        'unit_price',
        'finishing_type',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
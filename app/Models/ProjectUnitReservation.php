<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectUnitReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'project_unit_id',
        'customer_name',
        'phone',
        'notes',
        'status',
        'reserved_until',
    ];

    protected $casts = [
        'reserved_until' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

  
    public function projectUnit(): BelongsTo
    {
        return $this->belongsTo(ProjectUnit::class);
    }
}

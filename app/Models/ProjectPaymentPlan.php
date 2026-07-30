<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPaymentPlan extends Model
{
    protected $fillable = [
        'project_id',
        'down_payment',
        'installment_years',
        'maintenance',
        'notes',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

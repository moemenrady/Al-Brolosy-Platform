<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFeature extends Model
{
    protected $fillable = [
        'project_id',
        'title_ar',
        'title_en',
        'value',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

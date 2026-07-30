<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'location_ar',
        'location_en',
        'type',
        'main_tasks_ar',
        'main_tasks_en',
        'required_skills_ar',
        'required_skills_en',
        'is_active',
        'featured',
        'sort_order',
    ];

    /*
    |--------------------------------
    | ACCESSORS (MULTI LANGUAGE)
    |--------------------------------
    */

    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->title_ar
            : $this->title_en;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->description_ar
            : $this->description_en;
    }

    public function getLocationAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->location_ar
            : $this->location_en;
    }

    public function getMainTasksAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->main_tasks_ar
            : $this->main_tasks_en;
    }

    public function getRequiredSkillsAttribute()
    {
        return app()->getLocale() == 'ar'
            ? $this->required_skills_ar
            : $this->required_skills_en;
    }

    /*
    |--------------------------------
    | RELATION
    |--------------------------------
    */

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
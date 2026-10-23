<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConciergeStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'step_number',
        'title_ar',
        'title_en',
        'subtitle_ar',
        'subtitle_en',
        'step_type',
        'target_field',
        'options',
        'is_required',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'step_number' => 'integer',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}

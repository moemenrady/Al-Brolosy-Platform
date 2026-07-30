<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function show($id)
    {
        // جلب المشروع مع كافة العلاقات وتحسين الأداء من خلال الـ Eager Loading
        $project = Project::with([
            'sector',
            'images',
            'units',
            'paymentPlans',
            'features',
            'tags',
            'posts.contents' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            }
        ])->where('is_active', true)->findOrFail($id);

        return view('projects.show', compact('project'));
    }
}

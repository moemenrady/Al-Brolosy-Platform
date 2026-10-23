<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
  public function show($id)
    {
        // 1. Eager Load all necessary relations based on NEW ARCHITECTURE
        $project = Project::with([
            'sector',
            'unitTypes.units', // Eager loading the actual units through unit types
            'images',
            'paymentPlans',
            'features',
            'posts.contents'
        ])
        ->where('is_active', true)
        ->findOrFail($id);

        // 2. Aggregate Queries for Availability Overview (No Blade Queries)
        // Getting all actual units using flatMap for the nested relationship
        $actualUnits = $project->unitTypes->flatMap->units;
        
        $stats = [
            'total' => $actualUnits->count(),
            'available' => $actualUnits->where('status', 'available')->count(),
            'reserved' => $actualUnits->where('status', 'reserved')->count(),
            'sold' => $actualUnits->where('status', 'sold')->count(),
        ];

        // 3. Calculate Availability Percentage safely
        $stats['availability_percentage'] = $stats['total'] > 0 
            ? round(($stats['available'] / $stats['total']) * 100) 
            : 0;

        return view('projects.show', compact('project', 'stats', 'actualUnits'));
    }
}

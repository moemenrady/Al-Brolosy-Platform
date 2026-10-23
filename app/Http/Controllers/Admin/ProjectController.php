<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Sector;
use Illuminate\Http\Request;
use App\Models\ProjectImage;
use App\Models\ProjectUnit;
use App\Models\ProjectUnitType;
use App\Models\ProjectFeature;
use App\Models\ProjectPaymentPlan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $sectors = Sector::all();
        $projects = Project::with([
            'sector',
            'unitTypes',
            'paymentPlans',
            'features',
            'images'
        ])
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.projects.index', compact('projects', 'sectors'));
    }

    public function create()
    {
        $sectors = Sector::where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        return view('admin.projects.create', compact('sectors'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'sector_id' => 'required|exists:sectors,id',

            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',

            'image' => 'required|image',

            'hover_image' => 'nullable|image',
            'logo' => 'nullable|image',
        ]);

        DB::transaction(function () use ($request) {

            // =========================
            // Upload Main Files
            // =========================

            $image = $request->file('image')
                ? $request->file('image')->store('projects', 'public')
                : null;

            $hoverImage = $request->file('hover_image')
                ? $request->file('hover_image')->store('projects', 'public')
                : null;

            $logo = $request->file('logo')
                ? $request->file('logo')->store('projects', 'public')
                : null;

            // =========================
            // Create Project
            // =========================

            $project = Project::create([

                'sector_id' => $request->sector_id,

                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,

                'logo' => $logo,

                'copyright_sentence_ar' => $request->copyright_sentence_ar,
                'copyright_sentence_en' => $request->copyright_sentence_en,

                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,

                'location_ar' => $request->location_ar,
                'location_en' => $request->location_en,

                'latitude' => $request->latitude,
                'longitude' => $request->longitude,

                'image' => $image,
                'hover_image' => $hoverImage,

                'price_budget' => $request->price_budget,

                'status' => $request->status,

                'delivery_time' => $request->delivery_time,

                'sort_order' => $request->sort_order ?? 0,

                'featured' => $request->has('featured'),

                'is_active' => $request->has('is_active'),

            ]);

            // =========================
            // Gallery Images
            // =========================

            if ($request->hasFile('gallery')) {

                foreach ($request->file('gallery') as $galleryImage) {

                    $path = $galleryImage->store('images/projects', 'public');

                    ProjectImage::create([
                        'project_id' => $project->id,
                        'image' => $path,
                    ]);
                }
            }

            // =========================
            // Unit Types
            // =========================

            if ($request->units) {

                foreach ($request->units as $unit) {

                    if (empty($unit['unit_type'])) {
                        continue;
                    }

                    ProjectUnitType::create([

                        'project_id' => $project->id,

                        'unit_type' => $unit['unit_type'],

                        'floor' => $unit['floor'] ?? null,

                        'area' => $unit['start_area'] ?? null,

                        'price_per_meter' => $unit['price_per_meter'] ?? null,

                        'unit_price' => $unit['unit_price'] ?? null,

                        'finishing_type' => $unit['finishing_type'] ?? null,

                    ]);
                }
            }

            // =========================
            // Payment Plans
            // =========================

            if ($request->plans) {

                foreach ($request->plans as $plan) {

                    ProjectPaymentPlan::create([

                        'project_id' => $project->id,

                        'down_payment' => $plan['down_payment'] ?? null,

                        'installment_years' => $plan['installment_years'] ?? null,

                        'maintenance' => $plan['maintenance'] ?? null,

                        'notes' => $plan['notes'] ?? null,

                    ]);
                }
            }

            // =========================
            // Features
            // =========================

            if ($request->features) {

                foreach ($request->features as $feature) {

                    if (empty($feature['title_ar']) && empty($feature['title_en'])) {
                        continue;
                    }

                    ProjectFeature::create([

                        'project_id' => $project->id,

                        'title_ar' => $feature['title_ar'] ?? '',

                        'title_en' => $feature['title_en'] ?? '',

                        'value' => $feature['value'] ?? null,

                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::with(['sector', 'unitTypes', 'paymentPlans', 'features', 'images'])->findOrFail($id);
        $sectors = Sector::where('is_active', 1)->orderBy('sort_order')->get();
        return view('admin.projects.edit', compact('project', 'sectors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'sector_id' => 'required|exists:sectors,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $project) {

            // =========================
            // Update Main Files (Images)
            // =========================

            if ($request->file('image')) {
                // Delete old image if exists
                if ($project->image) {
                    Storage::disk('public')->delete($project->image);
                }
                $image = $request->file('image')->store('projects', 'public');
                $project->image = $image;
            }

            if ($request->file('hover_image')) {
                if ($project->hover_image) {
                    Storage::disk('public')->delete($project->hover_image);
                }
                $hoverImage = $request->file('hover_image')->store('projects', 'public');
                $project->hover_image = $hoverImage;
            }

            if ($request->file('logo')) {
                if ($project->logo) {
                    Storage::disk('public')->delete($project->logo);
                }
                $logo = $request->file('logo')->store('projects', 'public');
                $project->logo = $logo;
            }

            // =========================
            // Update Project Details
            // =========================

            $project->update([
                'sector_id' => $request->sector_id,
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'copyright_sentence_ar' => $request->copyright_sentence_ar,
                'copyright_sentence_en' => $request->copyright_sentence_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'location_ar' => $request->location_ar,
                'location_en' => $request->location_en,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'price_budget' => $request->price_budget,
                'status' => $request->status,
                'delivery_time' => $request->delivery_time,
                'sort_order' => $request->sort_order ?? 0,
                'featured' => $request->has('featured'),
                'is_active' => $request->has('is_active'),
            ]);

            // =========================
            // Update Unit Types
            // =========================

            if ($request->units) {
                // Delete existing unit types
                $project->unitTypes()->delete();

                // Create new unit types
                foreach ($request->units as $unit) {
                    if (empty($unit['unit_type'])) {
                        continue;
                    }

                    ProjectUnitType::create([
                        'project_id' => $project->id,
                        'unit_type' => $unit['unit_type'],
                        'floor' => $unit['floor'] ?? null,
                        'area' => $unit['start_area'] ?? null,
                        'price_per_meter' => $unit['price_per_meter'] ?? null,
                        'unit_price' => $unit['unit_price'] ?? null,
                        'finishing_type' => $unit['finishing_type'] ?? null,
                    ]);
                }
            }

            // =========================
            // Update Gallery Images
            // =========================

            if ($request->hasFile('gallery')) {
                // Optionally delete old gallery images or just add new ones
                foreach ($request->file('gallery') as $galleryImage) {
                    $path = $galleryImage->store('images/projects', 'public');
                    ProjectImage::create([
                        'project_id' => $project->id,
                        'image' => $path,
                    ]);
                }
            }

            // =========================
            // Update Payment Plans
            // =========================

            if ($request->plans) {
                $project->paymentPlans()->delete();

                foreach ($request->plans as $plan) {
                    ProjectPaymentPlan::create([
                        'project_id' => $project->id,
                        'down_payment' => $plan['down_payment'] ?? null,
                        'installment_years' => $plan['installment_years'] ?? null,
                        'maintenance' => $plan['maintenance'] ?? null,
                        'notes' => $plan['notes'] ?? null,
                    ]);
                }
            }

            // =========================
            // Update Features
            // =========================

            if ($request->features) {
                $project->features()->delete();

                foreach ($request->features as $feature) {
                    if (empty($feature['title_ar']) && empty($feature['title_en'])) {
                        continue;
                    }

                    ProjectFeature::create([
                        'project_id' => $project->id,
                        'title_ar' => $feature['title_ar'] ?? '',
                        'title_en' => $feature['title_en'] ?? '',
                        'value' => $feature['value'] ?? null,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function toggleActive(Project $project)
    {
        $project->update([
            'is_active' => !$project->is_active
        ]);

        return back();
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with('success', 'Deleted');
    }
    public function toggleFeatured(Project $project)
    {
        $project->update([
            'featured' => !$project->featured
        ]);

        return back();
    }
    public function reorder(Request $request)
    {
        foreach ($request->projects as $item) {
            Project::where('id', $item['id'])
                ->update([
                    'sort_order' => $item['sort_order']
                ]);
        }

        return response()->json([
            'success' => true
        ]);
    }
}

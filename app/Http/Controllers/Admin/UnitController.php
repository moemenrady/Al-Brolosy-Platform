<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectUnit;
use App\Models\ProjectUnitType;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $query = ProjectUnit::with(['project', 'unitType']);

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('unit_number', 'like', "%{$search}%");
        }

        $units = $query->latest()->paginate(20)->appends($request->query());

        $projects = Project::where('is_active', true)->orderBy('name_ar')->get();
        $unitTypes = ProjectUnitType::orderBy('name_ar')->get();

        $stats = [
            'total' => ProjectUnit::count(),
            'available' => ProjectUnit::where('status', 'available')->count(),
            'reserved' => ProjectUnit::where('status', 'reserved')->count(),
            'sold' => ProjectUnit::where('status', 'sold')->count(),
        ];

        return view('admin.projects.units', compact('units', 'projects', 'unitTypes', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'project_unit_type_id' => 'nullable|exists:project_unit_types,id',
            'unit_number' => 'required|string|max:50',
            'area' => 'required|numeric|min:1',
            'price_per_meter' => 'required|numeric|min:0',
            'unit_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,reserved,sold',
        ]);

        if (empty($validated['unit_price'])) {
            $validated['unit_price'] = $validated['area'] * $validated['price_per_meter'];
        }

        ProjectUnit::create($validated);

        return redirect()->route('admin.units.index')->with('success', 'تم إضافة الوحدة العقارية بنجاح.');
    }

    public function update(Request $request, ProjectUnit $unit)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'project_unit_type_id' => 'nullable|exists:project_unit_types,id',
            'unit_number' => 'required|string|max:50',
            'area' => 'required|numeric|min:1',
            'price_per_meter' => 'required|numeric|min:0',
            'unit_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,reserved,sold',
        ]);

        if (empty($validated['unit_price'])) {
            $validated['unit_price'] = $validated['area'] * $validated['price_per_meter'];
        }

        $unit->update($validated);

        return redirect()->route('admin.units.index')->with('success', 'تم تحديث بيانات الوحدة بنجاح.');
    }

    public function destroy(ProjectUnit $unit)
    {
        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', 'تم حذف الوحدة العقارية.');
    }

    public function toggleStatus(Request $request, ProjectUnit $unit)
    {
        $request->validate([
            'status' => 'required|in:available,reserved,sold',
        ]);

        $unit->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة الوحدة إلى ' . $request->status);
    }
}

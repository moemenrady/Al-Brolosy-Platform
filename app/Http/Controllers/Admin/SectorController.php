<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectorController extends Controller
{
    public function index()
    {
        $sectors = Sector::withCount('projects')->orderBy('sort_order')->paginate(15);
        return view('admin.projects.sectors', compact('sectors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sectors,slug',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name_en']);
        }

        if (empty($validated['image'])) {
            $validated['image'] = 'sectors/default.jpg';
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Sector::create($validated);

        return redirect()->route('admin.sectors.index')->with('success', 'تم إضافة القطاع بنجاح.');
    }

    public function update(Request $request, Sector $sector)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sectors,slug,' . $sector->id,
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name_en']);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $sector->update($validated);

        return redirect()->route('admin.sectors.index')->with('success', 'تم تحديث بيانات القطاع بنجاح.');
    }

    public function destroy(Sector $sector)
    {
        if ($sector->projects()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف هذا القطاع لاحتوائه على مشاريع مرتبطة.');
        }

        $sector->delete();
        return redirect()->route('admin.sectors.index')->with('success', 'تم حذف القطاع بنجاح.');
    }

    public function toggleActive(Sector $sector)
    {
        $sector->update(['is_active' => !$sector->is_active]);
        return back()->with('success', 'تم تغيير حالة تنشيط القطاع.');
    }
}

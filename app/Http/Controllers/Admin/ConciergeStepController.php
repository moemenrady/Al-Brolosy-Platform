<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConciergeStep;
use Illuminate\Http\Request;

class ConciergeStepController extends Controller
{
    /**
     * عرض قائمة خطوات وأسئلة المستشار العقاري الذكي
     */
    public function index()
    {
        $steps = ConciergeStep::orderBy('sort_order')->orderBy('id')->get();

        $stats = [
            'total' => $steps->count(),
            'active' => $steps->where('is_active', true)->count(),
            'inactive' => $steps->where('is_active', false)->count(),
        ];

        return view('admin.concierge.index', compact('steps', 'stats'));
    }

    /**
     * حفظ خطوة / تاب جديد في المستشار الذكي
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_ar' => 'nullable|string',
            'subtitle_en' => 'nullable|string',
            'step_type' => 'required|in:options_grid,lead_form,text_input',
            'target_field' => 'required|string|max:100',
            'options_json' => 'nullable|string',
            'is_required' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $options = null;
        if (!empty($validated['options_json'])) {
            $decoded = json_decode($validated['options_json'], true);
            if (is_array($decoded)) {
                $options = array_values($decoded);
            }
        }

        $nextSort = (ConciergeStep::max('sort_order') ?? 0) + 1;

        ConciergeStep::create([
            'title_ar' => $validated['title_ar'],
            'title_en' => $validated['title_en'] ?? null,
            'subtitle_ar' => $validated['subtitle_ar'] ?? null,
            'subtitle_en' => $validated['subtitle_en'] ?? null,
            'step_type' => $validated['step_type'],
            'target_field' => $validated['target_field'],
            'options' => $options,
            'is_required' => $request->has('is_required'),
            'is_active' => $request->has('is_active'),
            'sort_order' => $nextSort,
            'step_number' => $nextSort,
        ]);

        return redirect()->route('admin.concierge-steps.index')->with('success', 'تم إضافة الخطوة/التاب بنجاح إلى المستشار الذكي.');
    }

    /**
     * تحديث خطوة / تاب
     */
    public function update(Request $request, ConciergeStep $conciergeStep)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_ar' => 'nullable|string',
            'subtitle_en' => 'nullable|string',
            'step_type' => 'required|in:options_grid,lead_form,text_input',
            'target_field' => 'required|string|max:100',
            'options_json' => 'nullable|string',
            'is_required' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $options = $conciergeStep->options;
        if ($request->has('options_json')) {
            $decoded = json_decode($validated['options_json'], true);
            $options = is_array($decoded) ? array_values($decoded) : null;
        }

        $conciergeStep->update([
            'title_ar' => $validated['title_ar'],
            'title_en' => $validated['title_en'] ?? null,
            'subtitle_ar' => $validated['subtitle_ar'] ?? null,
            'subtitle_en' => $validated['subtitle_en'] ?? null,
            'step_type' => $validated['step_type'],
            'target_field' => $validated['target_field'],
            'options' => $options,
            'is_required' => $request->has('is_required'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.concierge-steps.index')->with('success', 'تم تحديث الخطوة وبياناتها بنجاح.');
    }

    /**
     * حذف خطوة
     */
    public function destroy(ConciergeStep $conciergeStep)
    {
        $conciergeStep->delete();

        // إعادة ترتيب الخطوات المتبقية
        $remaining = ConciergeStep::orderBy('sort_order')->get();
        foreach ($remaining as $index => $step) {
            $step->update([
                'sort_order' => $index + 1,
                'step_number' => $index + 1,
            ]);
        }

        return redirect()->route('admin.concierge-steps.index')->with('success', 'تم حذف الخطوة وإعادة ترقيم الخطوات.');
    }

    /**
     * تبديل حالة الخطوة (مفعل / معطل)
     */
    public function toggleActive(ConciergeStep $conciergeStep)
    {
        $conciergeStep->update([
            'is_active' => !$conciergeStep->is_active,
        ]);

        return back()->with('success', 'تم تحديث حالة تفعيل الخطوة.');
    }

    /**
     * إعادة ترتيب الخطوات (تقديم / تأخير)
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'step_ids' => 'required|array',
            'step_ids.*' => 'exists:concierge_steps,id',
        ]);

        foreach ($request->step_ids as $orderIndex => $id) {
            ConciergeStep::where('id', $id)->update([
                'sort_order' => $orderIndex + 1,
                'step_number' => $orderIndex + 1,
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'تم حفظ الترتيب الجديد للخطوات والتابات بنجاح.');
    }
}

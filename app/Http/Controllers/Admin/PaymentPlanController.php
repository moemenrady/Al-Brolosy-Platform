<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectPaymentPlan;
use Illuminate\Http\Request;

class PaymentPlanController extends Controller
{
    public function index(Request $request)
    {
        $query = ProjectPaymentPlan::with('project');

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $plans = $query->latest()->paginate(15)->appends($request->query());
        $projects = Project::where('is_active', true)->orderBy('name_ar')->get();

        return view('admin.projects.payment-plans', compact('plans', 'projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'down_payment' => 'required|string|max:50',
            'installment_years' => 'required|string|max:50',
            'maintenance' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        ProjectPaymentPlan::create($validated);

        return redirect()->route('admin.payment-plans.index')->with('success', 'تم إضافة خطة السداد بنجاح.');
    }

    public function update(Request $request, ProjectPaymentPlan $paymentPlan)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'down_payment' => 'required|string|max:50',
            'installment_years' => 'required|string|max:50',
            'maintenance' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $paymentPlan->update($validated);

        return redirect()->route('admin.payment-plans.index')->with('success', 'تم تحديث خطة السداد بنجاح.');
    }

    public function destroy(ProjectPaymentPlan $paymentPlan)
    {
        $paymentPlan->delete();
        return redirect()->route('admin.payment-plans.index')->with('success', 'تم حذف خطة السداد.');
    }
}

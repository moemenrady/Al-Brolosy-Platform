<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientHistory;
use App\Models\Consultation;
use App\Models\Identity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CrmController extends Controller
{
    /**
     * صفحة العملاء المحتملين (Leads)
     */
    public function leads(Request $request)
    {
        $query = Client::with(['assignedEmployee', 'activeSmartCard', 'histories.employee']);

        if ($request->filled('status')) {
            $query->where('lead_status', $request->status);
        } else {
            // افتراضياً عرض العملاء قيد المتابعة والتأهيل
            $query->whereIn('lead_status', ['new', 'contacted', 'qualified', 'negotiation']);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('project_or_city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        if ($request->filled('lead_source')) {
            $query->where('lead_source', $request->lead_source);
        }

        if ($request->filled('assigned_employee_id')) {
            $query->where('assigned_employee_id', $request->assigned_employee_id);
        }

        $leads = $query->latest()->paginate(15)->appends($request->query());
        $employees = User::whereIn('role', ['admin', 'sales'])->get();

        $stats = [
            'total_leads' => Client::whereIn('lead_status', ['new', 'contacted', 'qualified', 'negotiation'])->count(),
            'new' => Client::where('lead_status', 'new')->count(),
            'contacted' => Client::where('lead_status', 'contacted')->count(),
            'qualified' => Client::where('lead_status', 'qualified')->count(),
            'negotiation' => Client::where('lead_status', 'negotiation')->count(),
        ];

        return view('admin.crm.leads', compact('leads', 'employees', 'stats'));
    }

    /**
     * صفحة العملاء الفعليين والمتعاقدين (Customers)
     */
    public function customers(Request $request)
    {
        $query = Client::with(['assignedEmployee', 'activeSmartCard', 'histories.employee'])
            ->where('lead_status', 'won');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('project_or_city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        $customers = $query->latest()->paginate(15)->appends($request->query());
        $employees = User::whereIn('role', ['admin', 'sales'])->get();

        $stats = [
            'total_customers' => Client::where('lead_status', 'won')->count(),
            'active_smart_cards' => Client::whereHas('activeSmartCard')->count(),
            'cash_buyers' => Client::where('lead_status', 'won')->where('payment_method', 'cash')->count(),
            'installment_buyers' => Client::where('lead_status', 'won')->where('payment_method', 'installments')->count(),
        ];

        return view('admin.crm.customers', compact('customers', 'employees', 'stats'));
    }

    /**
     * صفحة طلبات التواصل والاستشارات الواردة (Contact Requests & Consultations)
     */
    public function contactRequests(Request $request)
    {
        $query = Consultation::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $consultations = $query->latest()->paginate(15)->appends($request->query());

        $stats = [
            'total' => Consultation::count(),
            'new' => Consultation::where('status', 'new')->count(),
            'contacted' => Consultation::where('status', 'contacted')->count(),
        ];

        return view('admin.crm.contact_requests', compact('consultations', 'stats'));
    }

    /**
     * تحديث حالة العميل السريعة (CRM Status Update)
     */
    public function updateStatus(Request $request, Client $client)
    {
        $validated = $request->validate([
            'lead_status' => 'required|in:new,contacted,qualified,proposal_sent,negotiation,reserved,won,lost,inactive',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $client->lead_status;
        $client->update([
            'lead_status' => $validated['lead_status'],
            'last_contact_at' => now(),
        ]);

        // تدوين الحدث في جدول السجل التاريخي
        ClientHistory::create([
            'client_id' => $client->id,
            'employee_id' => Auth::id(),
            'type' => 'status_changed',
            'status' => 'completed',
            'title' => 'تعديل حالة العميل إلى ' . $validated['lead_status'],
            'description' => $validated['notes'] ?? ('تم تغيير الحالة من ' . $oldStatus . ' إلى ' . $validated['lead_status']),
            'priority' => 'medium',
            'created_by' => Auth::user()?->name ?? 'Admin',
            'origin' => 'CRM Dashboard',
        ]);

        return back()->with('success', 'تم تحديث حالة العميل وتدوينها بالسجل بنجاح.');
    }

    /**
     * إسناد العميل لموظف مبيعات
     */
    public function assignEmployee(Request $request, Client $client)
    {
        $validated = $request->validate([
            'assigned_employee_id' => 'required|exists:users,id',
        ]);

        $employee = User::findOrFail($validated['assigned_employee_id']);
        $client->update(['assigned_employee_id' => $employee->id]);

        ClientHistory::create([
            'client_id' => $client->id,
            'employee_id' => Auth::id(),
            'type' => 'note',
            'status' => 'completed',
            'title' => 'إسناد العميل لمسؤول المبيعات',
            'description' => 'تم إسناد متابعة العميل إلى: ' . $employee->name,
            'priority' => 'low',
            'created_by' => Auth::user()?->name ?? 'Admin',
            'origin' => 'CRM Dashboard',
        ]);

        return back()->with('success', 'تم إسناد العميل بنجاح.');
    }

    /**
     * إضافة ملاحظة أو إجراء جديد في سجل متابعة العميل
     */
    public function addHistory(Request $request, Client $client)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'follow_up_at' => 'nullable|date',
        ]);

        $validated['client_id'] = $client->id;
        $validated['employee_id'] = Auth::id();
        $validated['created_by'] = Auth::user()?->name ?? 'Admin';
        $validated['origin'] = 'CRM Manual Action';
        $validated['status'] = 'completed';

        ClientHistory::create($validated);

        if (!empty($validated['follow_up_at'])) {
            $client->update(['next_follow_up_at' => $validated['follow_up_at']]);
        }

        $client->update(['last_contact_at' => now()]);

        return back()->with('success', 'تم تدوين المتابعة بنجاح في سجل العميل.');
    }

    /**
     * إضافة عميل جديد يدوياً من لوحة التحكم
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'governorate' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'purpose' => 'nullable|in:residential,investment,summer,clinic,office,commercial_shop',
            'unit_type' => 'nullable|in:apartment,villa,townhouse,twinhouse,duplex,penthouse,studio,chalet,clinic,office,shop',
            'project_or_city' => 'nullable|string|max:255',
            'budget' => 'nullable|in:lt_2m,2_4m,4_6m,6_10m,10_20m,gt_20m',
            'payment_method' => 'nullable|in:cash,installments,either',
            'lead_source' => 'nullable|in:facebook,instagram,google,tiktok,website,whatsapp,referral,broker,walk_in,other',
            'lead_status' => 'nullable|in:new,contacted,qualified,proposal_sent,negotiation,reserved,won,lost,inactive',
            'assigned_employee_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        // إنشاء Identity وهمية إذا أضيف العميل يدوياً
        $identity = Identity::create([
            'guest_id' => (string) Str::uuid(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $validated['identity_id'] = $identity->id;
        $validated['lead_status'] = $validated['lead_status'] ?? 'new';
        $validated['lead_source'] = $validated['lead_source'] ?? 'walk_in';
        $validated['last_contact_at'] = now();

        $client = Client::create($validated);

        ClientHistory::create([
            'client_id' => $client->id,
            'employee_id' => Auth::id(),
            'type' => 'interest_registered',
            'status' => 'completed',
            'title' => 'إضافة العميل يدوياً بواسطة الإدارة',
            'description' => 'تم إنشاء ملف العميل عبر لوحة التحكم.',
            'priority' => 'medium',
            'created_by' => Auth::user()?->name ?? 'Admin',
            'origin' => 'Admin Direct Entry',
        ]);

        return back()->with('success', 'تم إضافة العميل بنجاح.');
    }

    /**
     * تحديث بيانات عميل
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'governorate' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'purpose' => 'nullable|in:residential,investment,summer,clinic,office,commercial_shop',
            'unit_type' => 'nullable|in:apartment,villa,townhouse,twinhouse,duplex,penthouse,studio,chalet,clinic,office,shop',
            'project_or_city' => 'nullable|string|max:255',
            'budget' => 'nullable|in:lt_2m,2_4m,4_6m,6_10m,10_20m,gt_20m',
            'payment_method' => 'nullable|in:cash,installments,either',
            'lead_source' => 'nullable|in:facebook,instagram,google,tiktok,website,whatsapp,referral,broker,walk_in,other',
            'lead_status' => 'nullable|in:new,contacted,qualified,proposal_sent,negotiation,reserved,won,lost,inactive',
            'assigned_employee_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $client->update($validated);

        return back()->with('success', 'تم تعديل بيانات العميل بنجاح.');
    }

    /**
     * حذف عميل
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return back()->with('success', 'تم حذف ملف العميل.');
    }

    /**
     * تبديل حالة الاستشارة (تم التواصل / جديد)
     */
    public function toggleConsultation(Consultation $consultation)
    {
        $newStatus = $consultation->status === 'new' ? 'contacted' : 'new';
        $consultation->update([
            'status' => $newStatus,
            'contacted_at' => $newStatus === 'contacted' ? now() : null,
        ]);

        return back()->with('success', 'تم تحديث حالة الاستشارة بنجاح.');
    }

    /**
     * حذف طلب استشارة
     */
    public function destroyConsultation(Consultation $consultation)
    {
        $consultation->delete();
        return back()->with('success', 'تم حذف طلب الاستشارة.');
    }
}

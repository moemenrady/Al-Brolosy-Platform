@extends('layouts.admin')

@section('content')
<style>
    .plans-page {
        direction: rtl;
        font-family: 'Cairo', sans-serif;
    }
    .page-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1.2rem;
        border-bottom: 1px solid var(--glass-border);
    }
    .page-title {
        font-size: clamp(1.3rem, 2vw, 1.8rem);
        font-weight: 800;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .table-responsive {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        overflow-x: auto;
    }
    .lux-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
        text-align: right;
    }
    .lux-table th {
        background: rgba(228, 220, 199, 0.03);
        color: var(--text-muted);
        padding: 1rem;
        font-weight: 600;
        border-bottom: 1px solid var(--glass-border);
    }
    .lux-table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(228, 220, 199, 0.05);
        color: var(--text-main);
        vertical-align: middle;
    }
    .btn-lux {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.65rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        white-space: nowrap;
    }
    .btn-lux-primary { background: var(--primary-red); color: #fff; }
    .btn-lux-primary:hover { background: #d80000; }
    .btn-lux-gold { background: rgba(215, 182, 74, 0.2); color: var(--gold); border: 1px solid rgba(215, 182, 74, 0.4); }
    .btn-lux-gold:hover { background: var(--gold); color: #000; }
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px); z-index: 9999; display: none;
        align-items: center; justify-content: center; padding: 1rem;
    }
    .modal-card {
        background: var(--bg-card); border: 1px solid var(--glass-border);
        border-radius: 16px; width: 100%; max-width: 550px; padding: 2rem;
    }
    .form-control-lux {
        width: 100%; background: rgba(228, 220, 199, 0.05); border: 1px solid var(--glass-border);
        color: var(--text-main); padding: 0.65rem 0.9rem; border-radius: 8px; font-family: inherit;
        font-size: 0.9rem; outline: none; margin-top: 0.3rem;
    }
    .form-control-lux:focus { border-color: var(--gold); }
</style>

<div class="plans-page">
    <div class="page-head">
        <div class="page-title">
            <i class="fa-solid fa-credit-card" style="color:var(--gold);"></i>
            <span>إدارة خطط السداد وتسهيلات الدفع</span>
        </div>
        <div>
            <button onclick="openPlanModal()" class="btn-lux btn-lux-primary">
                <i class="fa-solid fa-plus"></i> إضافة خطة سداد
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #34d399; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    {{-- جدول عرض خطط السداد --}}
    <div class="table-responsive">
        <table class="lux-table">
            <thead>
                <tr>
                    <th>المشروع</th>
                    <th>نسبة / قيمة المقدم</th>
                    <th>فترة السداد والتقسيط</th>
                    <th>وديعة الصيانة</th>
                    <th>ملاحظات وتفاصيل الدفع</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                    <tr>
                        <td style="font-weight:700; color:var(--gold);">{{ $plan->project?->name_ar ?? 'عام' }}</td>
                        <td><span style="color:#10B981; font-weight:700;">{{ $plan->down_payment }}</span></td>
                        <td>{{ $plan->installment_years }}</td>
                        <td>{{ $plan->maintenance ?? 'غير محدد' }}</td>
                        <td style="color:var(--text-muted); font-size:0.85rem;">{{ $plan->notes ?? '-' }}</td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <button onclick="editPlanModal({{ $plan->toJson() }})" class="btn-lux btn-lux-gold" style="padding:0.4rem 0.7rem; font-size:0.8rem;" title="تعديل">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.payment-plans.destroy', $plan) }}" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الخطة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-lux btn-lux-primary" style="padding:0.4rem 0.7rem; font-size:0.8rem;" title="حذف">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:3rem; color:var(--text-muted);">
                            لا توجد خطط سداد مسجلة حتى الآن.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.5rem;">
        {{ $plans->links() }}
    </div>
</div>

{{-- مودال إضافة وتعديل خطة سداد --}}
<div class="modal-overlay" id="planModal">
    <div class="modal-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; padding-bottom:0.8rem; border-bottom:1px solid var(--glass-border);">
            <h3 id="planModalTitle" style="color:var(--text-main); font-weight:700;">إضافة خطة سداد جديدة</h3>
            <button onclick="closePlanModal()" style="background:none; border:none; color:var(--text-muted); font-size:1.5rem; cursor:pointer;">✕</button>
        </div>

        <form id="planForm" method="POST" action="{{ route('admin.payment-plans.store') }}">
            @csrf
            <div id="planMethodField"></div>

            <div style="margin-bottom:1rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">المشروع العقاري *</label>
                <select name="project_id" id="plan_project_id" required class="form-control-lux">
                    <option value="" disabled selected>اختر المشروع</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}">{{ $p->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">المقدم (Down Payment) *</label>
                    <input type="text" name="down_payment" id="plan_down_payment" required placeholder="مثال: 10% أو 500,000 ج.م" class="form-control-lux">
                </div>
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">سنوات التقسيط *</label>
                    <input type="text" name="installment_years" id="plan_installment_years" required placeholder="مثال: 7 سنوات أقساط متساوية" class="form-control-lux">
                </div>
            </div>

            <div style="margin-bottom:1rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">وديعة الصيانة (اختياري)</label>
                <input type="text" name="maintenance" id="plan_maintenance" placeholder="مثال: 8% عند الاستلام" class="form-control-lux">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">ملاحظات وشروط الخطة</label>
                <textarea name="notes" id="plan_notes" rows="3" placeholder="خصومات الكاش أو تفاصيل دفعات الربع سنوية..." class="form-control-lux"></textarea>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="closePlanModal()" class="btn-lux" style="background:var(--dash-border); color:var(--text-main);">إلغاء</button>
                <button type="submit" class="btn-lux btn-lux-primary">حفظ خطة السداد</button>
            </div>
        </form>
    </div>
</div>

<script>
    const planModal = document.getElementById('planModal');
    const planForm = document.getElementById('planForm');
    const planModalTitle = document.getElementById('planModalTitle');
    const planMethodField = document.getElementById('planMethodField');

    function openPlanModal() {
        planForm.reset();
        planForm.action = "{{ route('admin.payment-plans.store') }}";
        planMethodField.innerHTML = '';
        planModalTitle.innerText = "إضافة خطة سداد جديدة";
        planModal.style.display = 'flex';
    }

    function editPlanModal(plan) {
        planForm.action = `/admin/payment-plans/${plan.id}`;
        planMethodField.innerHTML = `@method('PUT')`;
        planModalTitle.innerText = `تعديل خطة السداد`;

        document.getElementById('plan_project_id').value = plan.project_id;
        document.getElementById('plan_down_payment').value = plan.down_payment;
        document.getElementById('plan_installment_years').value = plan.installment_years;
        document.getElementById('plan_maintenance').value = plan.maintenance || '';
        document.getElementById('plan_notes').value = plan.notes || '';

        planModal.style.display = 'flex';
    }

    function closePlanModal() {
        planModal.style.display = 'none';
    }

    window.onclick = function(e) {
        if (e.target === planModal) closePlanModal();
    }
</script>
@endsection

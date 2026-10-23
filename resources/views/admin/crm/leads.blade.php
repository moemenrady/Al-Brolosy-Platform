@extends('layouts.admin')

@section('content')
<style>
    .crm-page {
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
    .kpi-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .kpi-mini-card {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        padding: 1rem 1.2rem;
        border-radius: 10px;
        text-align: right;
    }
    .filter-card {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1.5rem;
    }
    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)) auto;
        gap: 1rem;
        align-items: flex-end;
    }
    .form-control-lux {
        width: 100%;
        background: rgba(228, 220, 199, 0.05);
        border: 1px solid var(--glass-border);
        color: var(--text-main);
        padding: 0.65rem 0.9rem;
        border-radius: 8px;
        font-family: inherit;
        font-size: 0.9rem;
        outline: none;
    }
    .form-control-lux:focus { border-color: var(--gold); }
    .table-responsive {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        overflow-x: auto;
    }
    .lux-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
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
        gap: 6px;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
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

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.65rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .status-new { background: rgba(14, 165, 233, 0.15); color: #38bdf8; }
    .status-contacted { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
    .status-qualified { background: rgba(139, 92, 246, 0.15); color: #a78bfa; }
    .status-negotiation { background: rgba(234, 88, 12, 0.15); color: #fb923c; }

    /* المودال */
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px); z-index: 9999; display: none;
        align-items: center; justify-content: center; padding: 1rem;
    }
    .modal-card {
        background: var(--bg-card); border: 1px solid var(--glass-border);
        border-radius: 16px; width: 100%; max-width: 600px; padding: 2rem;
        max-height: 90vh; overflow-y: auto;
    }
</style>

<div class="crm-page">
    <div class="page-head">
        <div class="page-title">
            <i class="fa-solid fa-funnel-dollar" style="color:var(--gold);"></i>
            <span>إدارة وتأهيل العملاء المحتملين (Leads Pipeline)</span>
        </div>
        <div>
            <button onclick="openNewLeadModal()" class="btn-lux btn-lux-primary">
                <i class="fa-solid fa-user-plus"></i> إضافة Lead جديد
            </button>
        </div>
    </div>

    {{-- رسائل التنبيه --}}
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #34d399; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    {{-- بطاقات خط سير الـ Leads --}}
    <div class="kpi-row">
        <div class="kpi-mini-card">
            <div style="color:var(--text-muted); font-size:0.8rem;">إجمالي الـ Leads الجارية</div>
            <div style="font-size:1.6rem; font-weight:800; color:var(--text-main);">{{ $stats['total_leads'] }}</div>
        </div>
        <div class="kpi-mini-card">
            <div style="color:#0ea5e9; font-size:0.8rem;">جديد وغير متصل به</div>
            <div style="font-size:1.6rem; font-weight:800; color:#0ea5e9;">{{ $stats['new'] }}</div>
        </div>
        <div class="kpi-mini-card">
            <div style="color:#f59e0b; font-size:0.8rem;">تم التواصل الأولي</div>
            <div style="font-size:1.6rem; font-weight:800; color:#f59e0b;">{{ $stats['contacted'] }}</div>
        </div>
        <div class="kpi-mini-card">
            <div style="color:#8b5cf6; font-size:0.8rem;">مؤهل جاد (Qualified)</div>
            <div style="font-size:1.6rem; font-weight:800; color:#8b5cf6;">{{ $stats['qualified'] }}</div>
        </div>
        <div class="kpi-mini-card">
            <div style="color:#ea580c; font-size:0.8rem;">مرحلة التفاوض والعروض</div>
            <div style="font-size:1.6rem; font-weight:800; color:#ea580c;">{{ $stats['negotiation'] }}</div>
        </div>
    </div>

    {{-- الفلاتر --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.leads.index') }}" class="filter-form">
            <div>
                <label style="font-size:0.8rem; color:var(--text-muted); display:block; margin-bottom:4px;">حالة الـ Lead</label>
                <select name="status" class="form-control-lux">
                    <option value="">كافة الحالات النشطة</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>جديد (New)</option>
                    <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>تم التواصل (Contacted)</option>
                    <option value="qualified" {{ request('status') == 'qualified' ? 'selected' : '' }}>مؤهل جاد (Qualified)</option>
                    <option value="negotiation" {{ request('status') == 'negotiation' ? 'selected' : '' }}>تفاوض (Negotiation)</option>
                </select>
            </div>

            <div>
                <label style="font-size:0.8rem; color:var(--text-muted); display:block; margin-bottom:4px;">المصدر</label>
                <select name="lead_source" class="form-control-lux">
                    <option value="">كافة المصادر</option>
                    <option value="website" {{ request('lead_source') == 'website' ? 'selected' : '' }}>الموقع الإلكتروني</option>
                    <option value="whatsapp" {{ request('lead_source') == 'whatsapp' ? 'selected' : '' }}>واتساب</option>
                    <option value="facebook" {{ request('lead_source') == 'facebook' ? 'selected' : '' }}>فيسبوك</option>
                    <option value="google" {{ request('lead_source') == 'google' ? 'selected' : '' }}>جوجل</option>
                    <option value="referral" {{ request('lead_source') == 'referral' ? 'selected' : '' }}>ترشيح عميل</option>
                </select>
            </div>

            <div>
                <label style="font-size:0.8rem; color:var(--text-muted); display:block; margin-bottom:4px;">مسؤول المبيعات</label>
                <select name="assigned_employee_id" class="form-control-lux">
                    <option value="">كافة الموظفين</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('assigned_employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="font-size:0.8rem; color:var(--text-muted); display:block; margin-bottom:4px;">بحث</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="الاسم، الهاتف، المشروع..." class="form-control-lux">
            </div>

            <div>
                <button type="submit" class="btn-lux btn-lux-gold">
                    <i class="fa-solid fa-filter"></i> تصفية
                </button>
            </div>
        </form>
    </div>

    {{-- جدول الـ Leads --}}
    <div class="table-responsive">
        <table class="lux-table">
            <thead>
                <tr>
                    <th>اسم العميل</th>
                    <th>الهاتف والتواصل</th>
                    <th>الاهتمام والمشروع</th>
                    <th>الميزانية المقدرة</th>
                    <th>المصدر</th>
                    <th>المسؤول</th>
                    <th>المرحلة (Status)</th>
                    <th>إجراءات CRM</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                    <tr>
                        <td>
                            <div style="font-weight:700;">{{ $lead->full_name }}</div>
                            <div style="font-size:0.78rem; color:var(--text-muted);">{{ $lead->governorate ?? 'مصر' }} {{ $lead->city ? '- ' . $lead->city : '' }}</div>
                        </td>
                        <td>
                            <div>{{ $lead->phone }}</div>
                            <div style="display:flex; gap:6px; margin-top:4px;">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" 
                                   style="color:#25D366; background:rgba(37,211,102,0.1); padding:4px 8px; border-radius:6px; text-decoration:none;" title="واتساب">
                                    <i class="fa-brands fa-whatsapp"></i> واتساب
                                </a>
                                <a href="tel:{{ $lead->phone }}" 
                                   style="color:#0ea5e9; background:rgba(14,165,233,0.1); padding:4px 8px; border-radius:6px; text-decoration:none;" title="اتصال">
                                    <i class="fa-solid fa-phone"></i>
                                </a>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight:600; color:var(--gold);">{{ $lead->purpose ?? 'عام' }}</span>
                            <div style="font-size:0.78rem; color:var(--text-muted);">{{ $lead->project_or_city ?? 'كافة المشاريع' }}</div>
                        </td>
                        <td>
                            <span style="font-weight:700;">{{ $lead->budget ?? 'مرن' }}</span>
                            @if($lead->expected_down_payment)
                                <div style="font-size:0.75rem; color:#10B981;">مقدم: {{ number_format($lead->expected_down_payment) }} ج.م</div>
                            @endif
                        </td>
                        <td>
                            <span style="font-size:0.8rem; background:rgba(228,220,199,0.06); padding:3px 8px; border-radius:4px;">
                                {{ $lead->lead_source ?? 'website' }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.clients.assign', $lead) }}">
                                @csrf
                                @method('PATCH')
                                <select name="assigned_employee_id" onchange="this.form.submit()" class="form-control-lux" style="padding:0.2rem 0.5rem; font-size:0.78rem; width:120px;">
                                    <option value="" disabled {{ !$lead->assigned_employee_id ? 'selected' : '' }}>اختر موظف</option>
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}" {{ $lead->assigned_employee_id == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.clients.status', $lead) }}">
                                @csrf
                                @method('PATCH')
                                <select name="lead_status" onchange="this.form.submit()" class="form-control-lux" style="padding:0.25rem 0.5rem; font-size:0.8rem; width:130px; font-weight:700;">
                                    <option value="new" {{ $lead->lead_status == 'new' ? 'selected' : '' }}>جديد</option>
                                    <option value="contacted" {{ $lead->lead_status == 'contacted' ? 'selected' : '' }}>تم التواصل</option>
                                    <option value="qualified" {{ $lead->lead_status == 'qualified' ? 'selected' : '' }}>مؤهل جاد</option>
                                    <option value="negotiation" {{ $lead->lead_status == 'negotiation' ? 'selected' : '' }}>تفاوض</option>
                                    <option value="won" {{ $lead->lead_status == 'won' ? 'selected' : '' }}>تعاقد وبيع ✓</option>
                                    <option value="lost" {{ $lead->lead_status == 'lost' ? 'selected' : '' }}>ملغي ✗</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <button onclick="openNoteModal({{ $lead->id }}, '{{ addslashes($lead->full_name) }}')" class="btn-lux btn-lux-gold" style="padding:0.35rem 0.65rem; font-size:0.75rem;" title="تدوين ملاحظة ومتابعة">
                                    <i class="fa-solid fa-notes-medical"></i> متابعة
                                </button>
                                <form method="POST" action="{{ route('admin.clients.destroy', $lead) }}" style="display:inline;" onsubmit="return confirm('حذف هذا الـ Lead نهائياً؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-lux btn-lux-primary" style="padding:0.35rem 0.6rem; font-size:0.75rem;" title="حذف">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:3rem; color:var(--text-muted);">
                            لا توجد بيانات عملاء في هذه المرحلة.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.5rem;">
        {{ $leads->links() }}
    </div>
</div>

{{-- مودال إضافة متابعة وتاريخ للعميل --}}
<div class="modal-overlay" id="noteModal">
    <div class="modal-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; padding-bottom:0.8rem; border-bottom:1px solid var(--glass-border);">
            <h3 style="color:var(--text-main); font-weight:700;">تدوين متابعة للعميل: <span id="noteClientName" style="color:var(--gold);"></span></h3>
            <button onclick="closeNoteModal()" style="background:none; border:none; color:var(--text-muted); font-size:1.5rem; cursor:pointer;">✕</button>
        </div>

        <form id="noteForm" method="POST" action="">
            @csrf
            <div style="margin-bottom:1rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">نوع الإجراء أو التواصل *</label>
                <select name="type" required class="form-control-lux">
                    <option value="phone_call">مكالمة هاتفية</option>
                    <option value="whatsapp">محادثة واتساب</option>
                    <option value="meeting">اجتماع شخصي بمقر الشركة</option>
                    <option value="visit">معاينة ميدانية للمشروع</option>
                    <option value="offer_sent">إرسال عرض أسعار وخطة سداد</option>
                    <option value="note">ملاحظة عامة</option>
                </select>
            </div>

            <div style="margin-bottom:1rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">عنوان المتابعة *</label>
                <input type="text" name="title" required placeholder="مثال: تم الاتصال وتحديد موعد معاينة" class="form-control-lux">
            </div>

            <div style="margin-bottom:1rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">تفاصيل ما دار خلال التواصل</label>
                <textarea name="description" rows="3" placeholder="أبدى اهتماماً بالدور الأول، وطلب مهلة يومين لمراجعة الشيكات..." class="form-control-lux"></textarea>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.5rem;">
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">درجة الأهمية *</label>
                    <select name="priority" required class="form-control-lux">
                        <option value="low">منخفضة</option>
                        <option value="medium" selected>متوسطة</option>
                        <option value="high">مرتفعة</option>
                        <option value="urgent">طارئة (حسم الصفقة)</option>
                    </select>
                </div>
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">موعد المتابعة القادمة</label>
                    <input type="datetime-local" name="follow_up_at" class="form-control-lux">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="closeNoteModal()" class="btn-lux" style="background:var(--dash-border); color:var(--text-main);">إلغاء</button>
                <button type="submit" class="btn-lux btn-lux-primary">حفظ في سجل العميل</button>
            </div>
        </form>
    </div>
</div>

{{-- مودال إضافة Lead جديد يدوياً --}}
<div class="modal-overlay" id="newLeadModal">
    <div class="modal-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; padding-bottom:0.8rem; border-bottom:1px solid var(--glass-border);">
            <h3 style="color:var(--text-main); font-weight:700;">إضافة Lead جديد إلى خط السير</h3>
            <button onclick="closeNewLeadModal()" style="background:none; border:none; color:var(--text-muted); font-size:1.5rem; cursor:pointer;">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.clients.store') }}">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">اسم العميل بالكامل *</label>
                    <input type="text" name="full_name" required placeholder="اسم العميل" class="form-control-lux">
                </div>
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">رقم الهاتف *</label>
                    <input type="text" name="phone" required placeholder="01xxxxxxxxx" class="form-control-lux">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">البريد الإلكتروني</label>
                    <input type="email" name="email" placeholder="example@mail.com" class="form-control-lux">
                </div>
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">المحافظة / النطاق</label>
                    <input type="text" name="governorate" placeholder="القاهرة، الجيزة..." class="form-control-lux">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">الغرض العقاري</label>
                    <select name="purpose" class="form-control-lux">
                        <option value="residential">سكني للإقامة</option>
                        <option value="investment">استثماري تجاري</option>
                        <option value="summer">مصيفي وساحلي</option>
                        <option value="commercial_shop">محل تجاري</option>
                        <option value="clinic">عيادة طبية</option>
                        <option value="office">مكتب إداري</option>
                    </select>
                </div>
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">الميزانية التقديرية</label>
                    <select name="budget" class="form-control-lux">
                        <option value="lt_2m">أقل من 2 مليون</option>
                        <option value="2_4m">2 إلى 4 مليون</option>
                        <option value="4_6m">4 إلى 6 مليون</option>
                        <option value="6_10m">6 إلى 10 مليون</option>
                        <option value="10_20m">10 إلى 20 مليون</option>
                        <option value="gt_20m">أكثر من 20 مليون</option>
                    </select>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">المصدر (Lead Source)</label>
                    <select name="lead_source" class="form-control-lux">
                        <option value="walk_in">زيارة مقر الشركة</option>
                        <option value="phone">مكالمة واردة</option>
                        <option value="whatsapp">واتساب مباشر</option>
                        <option value="facebook">فيسبوك</option>
                        <option value="referral">ترشيح عميل سابق</option>
                        <option value="broker">بروكر / وسيط خارجي</option>
                    </select>
                </div>
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">إسناد لموظف مبيعات</label>
                    <select name="assigned_employee_id" class="form-control-lux">
                        <option value="">بدون إسناد</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">ملاحظات أولية</label>
                <textarea name="notes" rows="2" placeholder="أي تفاصيل إضافية عن رغبة العميل..." class="form-control-lux"></textarea>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="closeNewLeadModal()" class="btn-lux" style="background:var(--dash-border); color:var(--text-main);">إلغاء</button>
                <button type="submit" class="btn-lux btn-lux-primary">حفظ الـ Lead</button>
            </div>
        </form>
    </div>
</div>

<script>
    const noteModal = document.getElementById('noteModal');
    const noteForm = document.getElementById('noteForm');
    const noteClientName = document.getElementById('noteClientName');

    function openNoteModal(clientId, clientName) {
        noteClientName.innerText = clientName;
        noteForm.action = `/admin/clients/${clientId}/history`;
        noteModal.style.display = 'flex';
    }

    function closeNoteModal() {
        noteModal.style.display = 'none';
    }

    const newLeadModal = document.getElementById('newLeadModal');
    function openNewLeadModal() {
        newLeadModal.style.display = 'flex';
    }
    function closeNewLeadModal() {
        newLeadModal.style.display = 'none';
    }

    window.onclick = function(e) {
        if (e.target === noteModal) closeNoteModal();
        if (e.target === newLeadModal) closeNewLeadModal();
    }
</script>
@endsection

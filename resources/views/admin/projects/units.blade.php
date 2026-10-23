@extends('layouts.admin')

@section('content')
<style>
    .units-page {
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

    /* شريط الفلاتر والبحث */
    .filter-card {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1.5rem;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) auto;
        gap: 1rem;
        align-items: flex-end;
    }

    .form-group label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 0.4rem;
    }

    .form-control-lux {
        width: 100%;
        background: #16161a !important;
        border: 1px solid rgba(215, 182, 74, 0.25) !important;
        color: #ffffff !important;
        padding: 0.65rem 0.9rem;
        border-radius: 8px;
        font-family: inherit;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.3s;
    }

    select.form-control-lux,
    select.form-control-lux option,
    select.form-control-lux optgroup {
        background-color: #1a1a20 !important;
        color: #ffffff !important;
    }

    .form-control-lux:focus {
        border-color: var(--gold) !important;
        box-shadow: 0 0 8px rgba(215, 182, 74, 0.2) !important;
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

    .btn-lux-primary {
        background: var(--primary-red);
        color: #fff;
    }
    .btn-lux-primary:hover {
        background: #d80000;
    }

    .btn-lux-gold {
        background: rgba(215, 182, 74, 0.2);
        color: var(--gold);
        border: 1px solid rgba(215, 182, 74, 0.4);
    }
    .btn-lux-gold:hover {
        background: var(--gold);
        color: #000;
    }

    /* جدول الوحدات */
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

    .lux-table tr:hover td {
        background: rgba(228, 220, 199, 0.02);
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.7rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .status-available { background: rgba(16, 185, 129, 0.15); color: #34d399; }
    .status-reserved { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
    .status-sold { background: rgba(239, 68, 68, 0.15); color: #f87171; }

    /* النوافذ المنبثقة (Modals) */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .modal-card {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        width: 100%;
        max-width: 600px;
        padding: 2rem;
        position: relative;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid var(--glass-border);
    }

    .modal-close {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 1.5rem;
        cursor: pointer;
    }
    .modal-close:hover { color: var(--primary-red); }

    .modal-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
</style>

<div class="units-page">

    <div class="page-head">
        <div class="page-title">
            <i class="fa-solid fa-door-open" style="color:var(--gold);"></i>
            <span>إدارة الوحدات العقارية</span>
        </div>
        <div>
            <button onclick="openUnitModal()" class="btn-lux btn-lux-primary">
                <i class="fa-solid fa-plus"></i> إضافة وحدة جديدة
            </button>
        </div>
    </div>

    {{-- بطاقات إحصائيات الوحدات --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1rem; margin-bottom:1.5rem;">
        <div style="background:var(--bg-card); border:1px solid var(--glass-border); padding:1rem 1.2rem; border-radius:10px;">
            <div style="color:var(--text-muted); font-size:0.8rem;">إجمالي الوحدات</div>
            <div style="font-size:1.6rem; font-weight:800; color:var(--text-main);">{{ number_format($stats['total']) }}</div>
        </div>
        <div style="background:var(--bg-card); border:1px solid var(--glass-border); padding:1rem 1.2rem; border-radius:10px;">
            <div style="color:#10B981; font-size:0.8rem;">الوحدات المتاحة</div>
            <div style="font-size:1.6rem; font-weight:800; color:#10B981;">{{ number_format($stats['available']) }}</div>
        </div>
        <div style="background:var(--bg-card); border:1px solid var(--glass-border); padding:1rem 1.2rem; border-radius:10px;">
            <div style="color:#f59e0b; font-size:0.8rem;">الوحدات المحجوزة</div>
            <div style="font-size:1.6rem; font-weight:800; color:#f59e0b;">{{ number_format($stats['reserved']) }}</div>
        </div>
        <div style="background:var(--bg-card); border:1px solid var(--glass-border); padding:1rem 1.2rem; border-radius:10px;">
            <div style="color:#ef4444; font-size:0.8rem;">الوحدات المباعة</div>
            <div style="font-size:1.6rem; font-weight:800; color:#ef4444;">{{ number_format($stats['sold']) }}</div>
        </div>
    </div>

    {{-- رسائل الفلاش --}}
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #34d399; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    {{-- الفلاتر --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.units.index') }}" class="filter-form">
            <div class="form-group">
                <label>المشروع</label>
                <select name="project_id" class="form-control-lux">
                    <option value="">كافة المشاريع</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}" {{ request('project_id') == $p->id ? 'selected' : '' }}>{{ $p->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>الحالة</label>
                <select name="status" class="form-control-lux">
                    <option value="">كافة الحالات</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>متاحة</option>
                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>محجوزة</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>مباعة</option>
                </select>
            </div>

            <div class="form-group">
                <label>بحث برقم الوحدة</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="مثال: RES-101" class="form-control-lux">
            </div>

            <div>
                <button type="submit" class="btn-lux btn-lux-gold">
                    <i class="fa-solid fa-magnifying-glass"></i> تصفية
                </button>
            </div>
        </form>
    </div>

    {{-- جدول عرض الوحدات --}}
    <div class="table-responsive">
        <table class="lux-table">
            <thead>
                <tr>
                    <th>رقم الوحدة</th>
                    <th>المشروع</th>
                    <th>نوع الوحدة</th>
                    <th>المساحة</th>
                    <th>سعر المتر</th>
                    <th>السعر الإجمالي</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($units as $unit)
                    <tr>
                        <td style="font-weight:700; color:var(--gold);">{{ $unit->unit_number }}</td>
                        <td>{{ $unit->project?->name_ar ?? '-' }}</td>
                        <td>{{ $unit->unitType?->name_ar ?? ($unit->unitType?->unit_type ?? 'عام') }}</td>
                        <td>{{ number_format($unit->area) }} م²</td>
                        <td>{{ number_format($unit->price_per_meter) }} ج.م</td>
                        <td style="font-weight:700;">{{ number_format($unit->unit_price) }} ج.م</td>
                        <td>
                            <form method="POST" action="{{ route('admin.units.toggle-status', $unit) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="form-control-lux" style="padding:0.25rem 0.5rem; font-size:0.8rem; width:auto;">
                                    <option value="available" {{ $unit->status == 'available' ? 'selected' : '' }}>متاحة</option>
                                    <option value="reserved" {{ $unit->status == 'reserved' ? 'selected' : '' }}>محجوزة</option>
                                    <option value="sold" {{ $unit->status == 'sold' ? 'selected' : '' }}>مباعة</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <button onclick="editUnitModal({{ $unit->toJson() }})" class="btn-lux btn-lux-gold" style="padding:0.4rem 0.7rem; font-size:0.8rem;" title="تعديل">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.units.destroy', $unit) }}" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الوحدة؟');">
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
                        <td colspan="8" style="text-align:center; padding:3rem; color:var(--text-muted);">
                            لا توجد وحدات مطابقة لشروط البحث.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.5rem;">
        {{ $units->links() }}
    </div>

</div>

{{-- مودال إضافة وتعديل وحدة --}}
<div class="modal-overlay" id="unitModal">
    <div class="modal-card">
        <div class="modal-head">
            <h3 id="modalTitle" style="color:var(--text-main); font-weight:700;">إضافة وحدة عقارية جديدة</h3>
            <button class="modal-close" onclick="closeUnitModal()">✕</button>
        </div>

        <form id="unitForm" method="POST" action="{{ route('admin.units.store') }}">
            @csrf
            <div id="methodField"></div>

            <div class="form-group" style="margin-bottom:1rem;">
                <label>المشروع العقاري *</label>
                <select name="project_id" id="form_project_id" required class="form-control-lux">
                    <option value="" disabled selected>اختر المشروع</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}">{{ $p->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-grid" style="margin-bottom:1rem;">
                <div class="form-group">
                    <label>نوع الوحدة (اختياري)</label>
                    <select name="project_unit_type_id" id="form_unit_type_id" class="form-control-lux">
                        <option value="">بدون نوع محدد</option>
                        @foreach($unitTypes as $ut)
                            <option value="{{ $ut->id }}">{{ $ut->name_ar }} ({{ $ut->unit_type }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>رقم أو كود الوحدة *</label>
                    <input type="text" name="unit_number" id="form_unit_number" required placeholder="مثال: APT-302" class="form-control-lux">
                </div>
            </div>

            <div class="modal-grid" style="margin-bottom:1rem;">
                <div class="form-group">
                    <label>المساحة (م²) *</label>
                    <input type="number" step="0.1" name="area" id="form_area" required placeholder="145" class="form-control-lux" oninput="calcTotal()">
                </div>

                <div class="form-group">
                    <label>سعر المتر (ج.م) *</label>
                    <input type="number" step="0.01" name="price_per_meter" id="form_price_per_meter" required placeholder="50000" class="form-control-lux" oninput="calcTotal()">
                </div>
            </div>

            <div class="modal-grid" style="margin-bottom:1.5rem;">
                <div class="form-group">
                    <label>السعر الإجمالي (ج.م)</label>
                    <input type="number" step="0.01" name="unit_price" id="form_unit_price" placeholder="يحسب تلقائياً" class="form-control-lux">
                </div>

                <div class="form-group">
                    <label>حالة الوحدة *</label>
                    <select name="status" id="form_status" required class="form-control-lux">
                        <option value="available">متاحة للبيع والتعاقد</option>
                        <option value="reserved">محجوزة مبدئياً</option>
                        <option value="sold">تم البيع والتعاقد</option>
                    </select>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="closeUnitModal()" class="btn-lux" style="background:var(--dash-border); color:var(--text-main);">إلغاء</button>
                <button type="submit" class="btn-lux btn-lux-primary" id="modalSubmitBtn">حفظ الوحدة</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('unitModal');
    const form = document.getElementById('unitForm');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');

    function openUnitModal() {
        form.reset();
        form.action = "{{ route('admin.units.store') }}";
        methodField.innerHTML = '';
        modalTitle.innerText = "إضافة وحدة عقارية جديدة";
        modal.style.display = 'flex';
    }

    function editUnitModal(unit) {
        form.action = `/admin/units/${unit.id}`;
        methodField.innerHTML = `@method('PUT')`;
        modalTitle.innerText = `تعديل الوحدة: ${unit.unit_number}`;
        
        document.getElementById('form_project_id').value = unit.project_id;
        document.getElementById('form_unit_type_id').value = unit.project_unit_type_id || '';
        document.getElementById('form_unit_number').value = unit.unit_number;
        document.getElementById('form_area').value = unit.area;
        document.getElementById('form_price_per_meter').value = unit.price_per_meter;
        document.getElementById('form_unit_price').value = unit.unit_price;
        document.getElementById('form_status').value = unit.status;

        modal.style.display = 'flex';
    }

    function closeUnitModal() {
        modal.style.display = 'none';
    }

    function calcTotal() {
        const area = parseFloat(document.getElementById('form_area').value) || 0;
        const meter = parseFloat(document.getElementById('form_price_per_meter').value) || 0;
        if (area > 0 && meter > 0) {
            document.getElementById('form_unit_price').value = (area * meter).toFixed(2);
        }
    }

    window.onclick = function(e) {
        if (e.target === modal) closeUnitModal();
    }
</script>
@endsection

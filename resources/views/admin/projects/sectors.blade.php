@extends('layouts.admin')

@section('content')
<style>
    .sectors-page {
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
        width: 100%; background: #16161a !important; border: 1px solid rgba(215, 182, 74, 0.25) !important;
        color: #ffffff !important; padding: 0.65rem 0.9rem; border-radius: 8px; font-family: inherit;
        font-size: 0.9rem; outline: none; margin-top: 0.3rem;
    }
    .form-control-lux:focus { border-color: var(--gold) !important; box-shadow: 0 0 8px rgba(215, 182, 74, 0.2) !important; }
    select.form-control-lux, select.form-control-lux option {
        background-color: #1a1a20 !important; color: #ffffff !important;
    }
</style>

<div class="sectors-page">
    <div class="page-head">
        <div class="page-title">
            <i class="fa-solid fa-shapes" style="color:var(--gold);"></i>
            <span>إدارة القطاعات العقارية</span>
        </div>
        <div>
            <button onclick="openSectorModal()" class="btn-lux btn-lux-primary">
                <i class="fa-solid fa-plus"></i> إضافة قطاع جديد
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #34d399; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #f87171; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    {{-- جدول القطاعات --}}
    <div class="table-responsive">
        <table class="lux-table">
            <thead>
                <tr>
                    <th>اسم القطاع (عربي)</th>
                    <th>الاسم بالإنجليزية</th>
                    <th>الرابط (Slug)</th>
                    <th>عدد المشاريع التابعة</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sectors as $sector)
                    <tr>
                        <td style="font-weight:700; color:var(--gold);">{{ $sector->name_ar }}</td>
                        <td>{{ $sector->name_en }}</td>
                        <td style="font-family:monospace; color:var(--text-muted);">{{ $sector->slug }}</td>
                        <td>
                            <span style="background:rgba(215, 182, 74, 0.1); color:var(--gold); padding:4px 10px; border-radius:20px; font-weight:700;">
                                {{ $sector->projects_count }} مشاريع
                            </span>
                        </td>
                        <td>{{ $sector->sort_order }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.sectors.toggle-active', $sector) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background:none; border:none; cursor:pointer;" title="تبديل الحالة">
                                    @if($sector->is_active)
                                        <span style="color:#10B981; font-weight:700;"><i class="fa-solid fa-circle-check"></i> نشط</span>
                                    @else
                                        <span style="color:#ef4444; font-weight:700;"><i class="fa-solid fa-circle-xmark"></i> معطل</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <button onclick="editSectorModal({{ $sector->toJson() }})" class="btn-lux btn-lux-gold" style="padding:0.4rem 0.7rem; font-size:0.8rem;" title="تعديل">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.sectors.destroy', $sector) }}" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا القطاع؟');">
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
                        <td colspan="7" style="text-align:center; padding:3rem; color:var(--text-muted);">
                            لا توجد قطاعات مسجلة.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.5rem;">
        {{ $sectors->links() }}
    </div>
</div>

{{-- مودال إضافة وتعديل قطاع --}}
<div class="modal-overlay" id="sectorModal">
    <div class="modal-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; padding-bottom:0.8rem; border-bottom:1px solid var(--glass-border);">
            <h3 id="sectorModalTitle" style="color:var(--text-main); font-weight:700;">إضافة قطاع جديد</h3>
            <button onclick="closeSectorModal()" style="background:none; border:none; color:var(--text-muted); font-size:1.5rem; cursor:pointer;">✕</button>
        </div>

        <form id="sectorForm" method="POST" action="{{ route('admin.sectors.store') }}">
            @csrf
            <div id="sectorMethodField"></div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">الاسم بالعربية *</label>
                    <input type="text" name="name_ar" id="sector_name_ar" required placeholder="مثال: قطاع الأبراج السكنية" class="form-control-lux">
                </div>
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">الاسم بالإنجليزية *</label>
                    <input type="text" name="name_en" id="sector_name_en" required placeholder="مثال: Residential Towers" class="form-control-lux">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">الرابط التعريفي (Slug)</label>
                    <input type="text" name="slug" id="sector_slug" placeholder="residential-towers" class="form-control-lux">
                </div>
                <div>
                    <label style="color:var(--text-muted); font-size:0.85rem;">ترتيب الظهور</label>
                    <input type="number" name="sort_order" id="sector_sort_order" value="0" class="form-control-lux">
                </div>
            </div>

            <div style="margin-bottom:1rem;">
                <label style="color:var(--text-muted); font-size:0.85rem;">الوصف بالعربية</label>
                <textarea name="description_ar" id="sector_desc_ar" rows="3" placeholder="نبذة مختصرة عن نوعية المشاريع في هذا القطاع..." class="form-control-lux"></textarea>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer; color:var(--text-main);">
                    <input type="checkbox" name="is_active" id="sector_is_active" value="1" checked>
                    <span>تنشيط القطاع للظهور في واجهة المنصة</span>
                </label>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="closeSectorModal()" class="btn-lux" style="background:var(--dash-border); color:var(--text-main);">إلغاء</button>
                <button type="submit" class="btn-lux btn-lux-primary">حفظ القطاع</button>
            </div>
        </form>
    </div>
</div>

<script>
    const sectorModal = document.getElementById('sectorModal');
    const sectorForm = document.getElementById('sectorForm');
    const sectorModalTitle = document.getElementById('sectorModalTitle');
    const sectorMethodField = document.getElementById('sectorMethodField');

    function openSectorModal() {
        sectorForm.reset();
        sectorForm.action = "{{ route('admin.sectors.store') }}";
        sectorMethodField.innerHTML = '';
        sectorModalTitle.innerText = "إضافة قطاع جديد";
        document.getElementById('sector_is_active').checked = true;
        sectorModal.style.display = 'flex';
    }

    function editSectorModal(sector) {
        sectorForm.action = `/admin/sectors/${sector.id}`;
        sectorMethodField.innerHTML = `@method('PUT')`;
        sectorModalTitle.innerText = `تعديل قطاع: ${sector.name_ar}`;

        document.getElementById('sector_name_ar').value = sector.name_ar;
        document.getElementById('sector_name_en').value = sector.name_en;
        document.getElementById('sector_slug').value = sector.slug;
        document.getElementById('sector_sort_order').value = sector.sort_order;
        document.getElementById('sector_desc_ar').value = sector.description_ar || '';
        document.getElementById('sector_is_active').checked = !!sector.is_active;

        sectorModal.style.display = 'flex';
    }

    function closeSectorModal() {
        sectorModal.style.display = 'none';
    }

    window.onclick = function(e) {
        if (e.target === sectorModal) closeSectorModal();
    }
</script>
@endsection

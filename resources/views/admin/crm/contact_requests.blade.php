@extends('layouts.admin')

@section('content')
<style>
    .consultations-page {
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
        gap: 6px;
        padding: 0.45rem 0.9rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
    }
    .btn-lux-primary { background: var(--primary-red); color: #fff; }
    .btn-lux-primary:hover { background: #d80000; }
    .btn-lux-gold { background: rgba(215, 182, 74, 0.2); color: var(--gold); border: 1px solid rgba(215, 182, 74, 0.4); }
    .btn-lux-gold:hover { background: var(--gold); color: #000; }
</style>

<div class="consultations-page">
    <div class="page-head">
        <div class="page-title">
            <i class="fa-solid fa-headset" style="color:var(--gold);"></i>
            <span>طلبات الاستشارات والتواصل الواردة (Inquiries & Consultations)</span>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #34d399; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    {{-- بطاقات إحصائيات سريعة --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1rem; margin-bottom:1.5rem;">
        <div style="background:var(--bg-card); border:1px solid var(--glass-border); padding:1rem 1.2rem; border-radius:10px;">
            <div style="color:var(--text-muted); font-size:0.8rem;">إجمالي الاستشارات</div>
            <div style="font-size:1.6rem; font-weight:800; color:var(--text-main);">{{ $stats['total'] }}</div>
        </div>
        <div style="background:var(--bg-card); border:1px solid var(--glass-border); padding:1rem 1.2rem; border-radius:10px;">
            <div style="color:#0ea5e9; font-size:0.8rem;">طلبات جديدة بحاجة لاتصال</div>
            <div style="font-size:1.6rem; font-weight:800; color:#0ea5e9;">{{ $stats['new'] }}</div>
        </div>
        <div style="background:var(--bg-card); border:1px solid var(--glass-border); padding:1rem 1.2rem; border-radius:10px;">
            <div style="color:#10B981; font-size:0.8rem;">تم التواصل والرد عليها</div>
            <div style="font-size:1.6rem; font-weight:800; color:#10B981;">{{ $stats['contacted'] }}</div>
        </div>
    </div>

    {{-- جدول الاستشارات --}}
    <div class="table-responsive">
        <table class="lux-table">
            <thead>
                <tr>
                    <th>اسم العميل</th>
                    <th>رقم الهاتف</th>
                    <th>قناة التواصل المفضلة</th>
                    <th>نص الرسالة والاستفسار</th>
                    <th>الحالة</th>
                    <th>تاريخ الإرسال</th>
                    <th>الإجراءات السريعة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultations as $item)
                    <tr>
                        <td style="font-weight:700;">{{ $item->name }}</td>
                        <td>
                            <div>{{ $item->phone }}</div>
                        </td>
                        <td>
                            @if($item->preferred_contact == 'whatsapp')
                                <span style="color:#25D366; font-weight:600;"><i class="fa-brands fa-whatsapp"></i> واتساب</span>
                            @elseif($item->preferred_contact == 'phone')
                                <span style="color:#0ea5e9; font-weight:600;"><i class="fa-solid fa-phone"></i> مكالمة</span>
                            @else
                                <span style="color:var(--text-muted); font-weight:600;"><i class="fa-solid fa-envelope"></i> بريد إلكتروني</span>
                            @endif
                        </td>
                        <td style="max-width:300px; color:var(--text-main); font-size:0.85rem; line-height:1.5;">
                            {{ $item->message }}
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.consultations.toggle', $item) }}" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background:none; border:none; cursor:pointer;" title="تبديل الحالة">
                                    @if($item->status == 'new')
                                        <span style="background:rgba(14,165,233,0.15); color:#38bdf8; padding:3px 10px; border-radius:20px; font-weight:700; font-size:0.75rem;">
                                            جديدة (اضغط للرد)
                                        </span>
                                    @else
                                        <span style="background:rgba(16,185,129,0.15); color:#34d399; padding:3px 10px; border-radius:20px; font-weight:700; font-size:0.75rem;">
                                            ✓ تم التواصل
                                        </span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td style="color:var(--text-muted); font-size:0.8rem;">
                            {{ $item->created_at->diffForHumans() }}
                        </td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->phone) }}" target="_blank" 
                                   style="color:#25D366; background:rgba(37,211,102,0.1); padding:5px 9px; border-radius:6px; text-decoration:none;" title="واتساب">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <a href="tel:{{ $item->phone }}" 
                                   style="color:#0ea5e9; background:rgba(14,165,233,0.1); padding:5px 9px; border-radius:6px; text-decoration:none;" title="اتصال">
                                    <i class="fa-solid fa-phone"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.consultations.destroy', $item) }}" style="display:inline;" onsubmit="return confirm('حذف هذا الطلب؟');">
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
                        <td colspan="7" style="text-align:center; padding:3rem; color:var(--text-muted);">
                            لا توجد طلبات استشارة واردة حالياً.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.5rem;">
        {{ $consultations->links() }}
    </div>
</div>
@endsection

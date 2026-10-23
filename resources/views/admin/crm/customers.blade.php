@extends('layouts.admin')

@section('content')
<style>
    .customers-page {
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
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .kpi-mini-card {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        padding: 1.2rem;
        border-radius: 10px;
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
    .btn-lux-gold { background: rgba(215, 182, 74, 0.2); color: var(--gold); border: 1px solid rgba(215, 182, 74, 0.4); }
    .btn-lux-gold:hover { background: var(--gold); color: #000; }
    .vip-card-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(215, 182, 74, 0.15);
        border: 1px solid rgba(215, 182, 74, 0.4);
        color: var(--gold);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
    }
</style>

<div class="customers-page">
    <div class="page-head">
        <div class="page-title">
            <i class="fa-solid fa-award" style="color:var(--gold);"></i>
            <span>العملاء الفعليين والمتعاقدين (Won Deals & Customers)</span>
        </div>
        <div>
            <a href="{{ route('admin.analytics.export') }}?lead_status=won" class="btn-lux btn-lux-gold">
                <i class="fa-solid fa-file-excel"></i> تصدير قائمة المتعاقدين
            </a>
        </div>
    </div>

    {{-- بطاقات إحصائيات العملاء الفعليين --}}
    <div class="kpi-row">
        <div class="kpi-mini-card">
            <div style="color:var(--text-muted); font-size:0.8rem;">إجمالي العملاء المتعاقدين</div>
            <div style="font-size:1.8rem; font-weight:800; color:#10B981;">{{ number_format($stats['total_customers']) }}</div>
        </div>
        <div class="kpi-mini-card">
            <div style="color:var(--gold); font-size:0.8rem;">يحملون بطاقة VIP الذكية</div>
            <div style="font-size:1.8rem; font-weight:800; color:var(--gold);">{{ number_format($stats['active_smart_cards']) }}</div>
        </div>
        <div class="kpi-mini-card">
            <div style="color:#0ea5e9; font-size:0.8rem;">سداد كاش بالكامل</div>
            <div style="font-size:1.8rem; font-weight:800; color:#0ea5e9;">{{ number_format($stats['cash_buyers']) }}</div>
        </div>
        <div class="kpi-mini-card">
            <div style="color:#8b5cf6; font-size:0.8rem;">سداد بأقساط وتسهيلات</div>
            <div style="font-size:1.8rem; font-weight:800; color:#8b5cf6;">{{ number_format($stats['installment_buyers']) }}</div>
        </div>
    </div>

    {{-- جدول العملاء المتعاقدين --}}
    <div class="table-responsive">
        <table class="lux-table">
            <thead>
                <tr>
                    <th>اسم العميل</th>
                    <th>الهاتف والبريد</th>
                    <th>المشروع ونوع الوحدة</th>
                    <th>طريقة السداد</th>
                    <th>المقدم المدفوع</th>
                    <th>بطاقة VIP الذكية</th>
                    <th>مسؤول المبيعات</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $client)
                    <tr>
                        <td>
                            <div style="font-weight:700; color:var(--text-main);">{{ $client->full_name }}</div>
                            <div style="font-size:0.78rem; color:var(--text-muted);">{{ $client->governorate ?? 'مصر' }} {{ $client->city ? '- ' . $client->city : '' }}</div>
                        </td>
                        <td>
                            <div>{{ $client->phone }}</div>
                            <div style="font-size:0.78rem; color:var(--text-muted);">{{ $client->email ?? 'بدون بريد' }}</div>
                        </td>
                        <td>
                            <span style="font-weight:600; color:var(--gold);">{{ $client->project_or_city ?? 'مشروع متميز' }}</span>
                            <div style="font-size:0.78rem; color:var(--text-muted);">{{ $client->unit_type ?? 'وحدة سكنية' }}</div>
                        </td>
                        <td>
                            <span style="font-weight:700; color:{{ $client->payment_method == 'cash' ? '#10B981' : '#0ea5e9' }};">
                                {{ $client->payment_method == 'cash' ? 'كاش بالكامل' : 'أقساط وتسهيلات' }}
                            </span>
                        </td>
                        <td>
                            <span style="font-weight:700; color:#10B981;">
                                {{ $client->expected_down_payment ? number_format($client->expected_down_payment) . ' ج.م' : '-' }}
                            </span>
                        </td>
                        <td>
                            @if($client->activeSmartCard)
                                <div class="vip-card-badge">
                                    <i class="fa-solid fa-gem"></i>
                                    <span>{{ $client->activeSmartCard->card_number }}</span>
                                </div>
                            @else
                                <span style="color:var(--text-muted); font-size:0.8rem;">غير مصدرة بعد</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-size:0.85rem;">{{ $client->assignedEmployee?->name ?? 'مبيعات البرلسي' }}</span>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $client->phone) }}" target="_blank" 
                                   style="color:#25D366; background:rgba(37,211,102,0.1); padding:5px 9px; border-radius:6px; text-decoration:none;" title="واتساب">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <a href="tel:{{ $client->phone }}" 
                                   style="color:#0ea5e9; background:rgba(14,165,233,0.1); padding:5px 9px; border-radius:6px; text-decoration:none;" title="اتصال">
                                    <i class="fa-solid fa-phone"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:3rem; color:var(--text-muted);">
                            لا يوجد عملاء متعاقدون في هذه الفئة حالياً.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.5rem;">
        {{ $customers->links() }}
    </div>
</div>
@endsection

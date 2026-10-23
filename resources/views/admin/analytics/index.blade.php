@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .analytics-page {
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
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.2rem;
        margin-bottom: 2rem;
    }
    .kpi-card {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 14px;
        padding: 1.4rem;
        position: relative;
        overflow: hidden;
    }
    .kpi-card::after {
        content: '';
        position: absolute;
        bottom: 0; right: 0; left: 0; height: 3px;
        background: var(--accent, var(--gold));
    }
    .kpi-card.green::after { --accent: #10B981; }
    .kpi-card.red::after { --accent: var(--primary-red); }
    .kpi-card.blue::after { --accent: #0EA5E9; }

    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 992px) {
        .charts-grid { grid-template-columns: 1fr; }
    }
    .dash-card {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 14px;
        padding: 1.5rem;
    }
    .card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.2rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid var(--glass-border);
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
        padding: 0.9rem;
        font-weight: 600;
        border-bottom: 1px solid var(--glass-border);
    }
    .lux-table td {
        padding: 0.9rem;
        border-bottom: 1px solid rgba(228, 220, 199, 0.05);
        color: var(--text-main);
        vertical-align: middle;
    }
    .behavior-feed {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        max-height: 450px;
        overflow-y: auto;
    }
    .behavior-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 0.8rem;
        background: rgba(228, 220, 199, 0.03);
        border: 1px solid rgba(228, 220, 199, 0.05);
        border-radius: 10px;
    }
    .behavior-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: rgba(215, 182, 74, 0.15); color: var(--gold);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 0.9rem;
    }
    .form-control-lux {
        width: 100%; background: rgba(228, 220, 199, 0.05); border: 1px solid var(--glass-border);
        color: var(--text-main); padding: 0.65rem 0.9rem; border-radius: 8px; font-family: inherit;
        font-size: 0.9rem; outline: none; margin-top: 0.3rem;
    }
</style>

<div class="analytics-page">

    <div class="page-head">
        <div class="page-title">
            <i class="fa-solid fa-chart-line" style="color:var(--gold);"></i>
            <span>لوحة تحليلات سلوك العملاء والزوار وإصدار التقارير</span>
        </div>
        <div>
            <a href="#report-section" class="btn-lux btn-lux-gold">
                <i class="fa-solid fa-file-export"></i> إنشاء وتصدير تقرير
            </a>
        </div>
    </div>

    {{-- مؤشرات التفاعل والسلوك --}}
    <div class="kpi-grid">
        <div class="kpi-card gold">
            <div style="font-size:0.85rem; color:var(--text-muted); font-weight:600;">إجمالي زوار المنصة</div>
            <div style="font-size:2rem; font-weight:800; color:var(--text-main); margin:0.3rem 0;">{{ number_format($totalVisitors) }}</div>
            <div style="font-size:0.75rem; color:var(--gold);">هويات رقمية مسجلة بالنظام</div>
        </div>

        <div class="kpi-card green">
            <div style="font-size:0.85rem; color:var(--text-muted); font-weight:600;">نسبة التحويل للـ Leads</div>
            <div style="font-size:2rem; font-weight:800; color:#10B981; margin:0.3rem 0;">{{ $conversionRate }}%</div>
            <div style="font-size:0.75rem; color:var(--text-muted);">من زائر مهتم إلى عميل مسجل</div>
        </div>

        <div class="kpi-card blue">
            <div style="font-size:0.85rem; color:var(--text-muted); font-weight:600;">تحويلات الواتساب المباشرة</div>
            <div style="font-size:2rem; font-weight:800; color:#0ea5e9; margin:0.3rem 0;">{{ number_format($whatsappClicks) }}</div>
            <div style="font-size:0.75rem; color:#25D366;"><i class="fa-brands fa-whatsapp"></i> نقرة اتصال فوري</div>
        </div>

        <div class="kpi-card red">
            <div style="font-size:0.85rem; color:var(--text-muted); font-weight:600;">تحميل كتالوجات المشاريع</div>
            <div style="font-size:2rem; font-weight:800; color:#ef4444; margin:0.3rem 0;">{{ number_format($brochureDownloads) }}</div>
            <div style="font-size:0.75rem; color:var(--text-muted);">تنزيل ملفات PDF للوحدات</div>
        </div>

        <div class="kpi-card gold">
            <div style="font-size:0.85rem; color:var(--text-muted); font-weight:600;">استشارات المستشار العقاري الذكي</div>
            <div style="font-size:2rem; font-weight:800; color:var(--gold); margin:0.3rem 0;">{{ number_format($quizCompletions) }}</div>
            <div style="font-size:0.75rem; color:var(--text-muted);">إكمال استبيان المطابقة الذكي</div>
        </div>
    </div>

    {{-- رسوم بيانية --}}
    <div class="charts-grid">
        <div class="dash-card">
            <div class="card-head">
                <div style="font-weight:700; color:var(--text-main); font-size:1.05rem;">
                    <i class="fa-solid fa-chart-area" style="color:var(--gold);"></i> نشاط وتفاعلات الزوار (آخر 7 أيام)
                </div>
            </div>
            <div style="height:280px;">
                <canvas id="weeklyActivityChart"></canvas>
            </div>
        </div>

        <div class="dash-card">
            <div class="card-head">
                <div style="font-weight:700; color:var(--text-main); font-size:1.05rem;">
                    <i class="fa-solid fa-mobile-screen-button" style="color:#0ea5e9;"></i> توزيع أجهزة الزوار
                </div>
            </div>
            <div style="height:280px;">
                <canvas id="deviceChart"></canvas>
            </div>
        </div>
    </div>

    {{-- المشاريع الأكثر مشاهدة وسجل التفاعلات الحية --}}
    <div style="display:grid; grid-template-columns: 1.3fr 1fr; gap:1.5rem; margin-bottom:2rem;">
        {{-- العملاء الأكثر اهتماماً وتفاعلاً (High-Intent Leads) --}}
        <div class="dash-card">
            <div class="card-head">
                <div style="font-weight:700; color:var(--text-main); font-size:1.05rem;">
                    <i class="fa-solid fa-fire" style="color:var(--primary-red);"></i> عملاء ذوو اهتمام مرتفع (High Intent)
                </div>
            </div>
            <div class="table-responsive">
                <table class="lux-table">
                    <thead>
                        <tr>
                            <th>العميل</th>
                            <th>الهاتف</th>
                            <th>الغرض العقاري</th>
                            <th>عدد التفاعلات</th>
                            <th>الموظف المتابع</th>
                            <th>تواصل سريع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($highIntentLeads as $lead)
                            <tr>
                                <td style="font-weight:700;">{{ $lead->full_name }}</td>
                                <td>{{ $lead->phone }}</td>
                                <td><span style="color:var(--gold);">{{ $lead->purpose ?? 'عام' }}</span></td>
                                <td>
                                    <span style="background:rgba(215, 182, 74, 0.15); color:var(--gold); padding:3px 10px; border-radius:20px; font-weight:700;">
                                        {{ $lead->behaviors_count }} نشاط
                                    </span>
                                </td>
                                <td>{{ $lead->assignedEmployee?->name ?? 'غير مسند' }}</td>
                                <td>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" 
                                       style="color:#25D366; background:rgba(37,211,102,0.1); padding:4px 8px; border-radius:6px; text-decoration:none;">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center; padding:2rem; color:var(--text-muted);">
                                    لا توجد سجلات تفاعل مرتفعة حالياً.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- سجل تفاعلات الزوار المباشر --}}
        <div class="dash-card">
            <div class="card-head">
                <div style="font-weight:700; color:var(--text-main); font-size:1.05rem;">
                    <i class="fa-solid fa-bolt" style="color:var(--gold);"></i> سجل التفاعلات اللحظي (Live Stream)
                </div>
            </div>
            <div class="behavior-feed">
                @forelse($liveActivities as $act)
                    <div class="behavior-item">
                        <div class="behavior-icon">
                            @if($act->event_type == 'whatsapp_click')
                                <i class="fa-brands fa-whatsapp" style="color:#25D366;"></i>
                            @elseif($act->event_type == 'brochure_download')
                                <i class="fa-solid fa-file-pdf" style="color:#ef4444;"></i>
                            @elseif($act->event_type == 'quiz_complete')
                                <i class="fa-solid fa-wand-magic-sparkles" style="color:var(--gold);"></i>
                            @else
                                <i class="fa-solid fa-eye"></i>
                            @endif
                        </div>
                        <div style="flex:1; font-size:0.85rem;">
                            <div style="color:var(--text-main);">
                                @if($act->event_type == 'whatsapp_click')
                                    نقر على زر واتساب: <strong>{{ $act->project?->name_ar ?? 'عام' }}</strong>
                                @elseif($act->event_type == 'brochure_download')
                                    حمّل كتالوج مشروع: <strong>{{ $act->project?->name_ar ?? 'مشروع' }}</strong>
                                @elseif($act->event_type == 'quiz_complete')
                                    أكمل استبيان المستشار العقاري
                                @else
                                    مشاهدة صفحة: {{ $act->page_title ?? 'الموقع' }}
                                @endif
                                @if($act->client)
                                    <span style="color:var(--gold); font-weight:600;">({{ $act->client->full_name }})</span>
                                @endif
                            </div>
                            <div style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">
                                ⏱ {{ $act->created_at->diffForHumans() }} • {{ $act->device ?? 'desktop' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding:2rem; color:var(--text-muted);">
                        لا توجد تفاعلات مسجلة.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- قسم منشئ التقارير والتصدير (Report Generator) --}}
    <div class="dash-card" id="report-section" style="border-color:var(--gold);">
        <div class="card-head">
            <div style="font-weight:800; color:var(--gold); font-size:1.15rem; display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-file-invoice"></i>
                <span>منشئ ومصدر تقارير المنصة العقارية (Export Reports)</span>
            </div>
            <span style="font-size:0.85rem; color:var(--text-muted);">بصيغة Microsoft Excel / CSV تدعم العربية بنسبة 100%</span>
        </div>

        <form method="GET" action="{{ route('admin.analytics.export') }}" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)) auto; gap:1rem; align-items:flex-end;">
            <div>
                <label style="font-size:0.82rem; color:var(--text-muted);">من تاريخ</label>
                <input type="date" name="from_date" class="form-control-lux">
            </div>

            <div>
                <label style="font-size:0.82rem; color:var(--text-muted);">إلى تاريخ</label>
                <input type="date" name="to_date" class="form-control-lux">
            </div>

            <div>
                <label style="font-size:0.82rem; color:var(--text-muted);">حالة العميل (CRM)</label>
                <select name="lead_status" class="form-control-lux">
                    <option value="">كافة الحالات</option>
                    <option value="new">جديد (New)</option>
                    <option value="contacted">تم التواصل (Contacted)</option>
                    <option value="qualified">مؤهل جاد (Qualified)</option>
                    <option value="negotiation">مرحلة التفاوض (Negotiation)</option>
                    <option value="won">تم البيع والتعاقد (Won)</option>
                    <option value="lost">مستبعد (Lost)</option>
                </select>
            </div>

            <div>
                <label style="font-size:0.82rem; color:var(--text-muted);">الغرض العقاري</label>
                <select name="purpose" class="form-control-lux">
                    <option value="">كافة الأغراض</option>
                    <option value="residential">سكني</option>
                    <option value="investment">استثماري</option>
                    <option value="summer">مصيفي</option>
                    <option value="commercial_shop">تجاري</option>
                    <option value="clinic">عيادة</option>
                    <option value="office">إداري</option>
                </select>
            </div>

            <div>
                <button type="submit" class="btn-lux btn-lux-primary" style="height:42px;">
                    <i class="fa-solid fa-download"></i> تصدير التقرير الآن
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        Chart.defaults.font.family = "'Cairo', sans-serif";
        Chart.defaults.color = '#8E8E93';

        // رسم نشاط الأسبوع
        const actCtx = document.getElementById('weeklyActivityChart');
        if (actCtx) {
            new Chart(actCtx, {
                type: 'bar',
                data: {
                    labels: @json($daysLabels),
                    datasets: [{
                        label: 'عدد التفاعلات',
                        data: @json($dailyEvents),
                        backgroundColor: 'rgba(215, 182, 74, 0.7)',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(228, 220, 199, 0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // رسم أجهزة الزوار
        const devCtx = document.getElementById('deviceChart');
        if (devCtx) {
            new Chart(devCtx, {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($deviceDistribution)),
                    datasets: [{
                        data: @json(array_values($deviceDistribution)),
                        backgroundColor: ['#0ea5e9', '#d7b64a', '#8b5cf6'],
                        borderWidth: 2,
                        borderColor: '#121214'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }
    });
</script>
@endsection

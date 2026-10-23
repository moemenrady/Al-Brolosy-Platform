@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* =========================================================
       أنماط لوحة القيادة الفاخرة - شركة البرلسي العقارية
       ========================================================= */
    :root {
        --dash-bg: var(--bg-main, #050505);
        --dash-card: var(--bg-card, #121214);
        --dash-border: var(--glass-border, rgba(228, 220, 199, 0.1));
        --dash-gold: #d7b64a;
        --dash-red: #B40000;
        --dash-text: var(--text-main, #F0F0F0);
        --dash-muted: var(--text-muted, #8E8E93);
    }

    .dashboard-container {
        direction: rtl;
        font-family: 'Cairo', sans-serif;
    }

    /* هيدر الترحيب والإجراءات السريعة */
    .dash-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--dash-border);
    }

    .dash-title-group h1 {
        font-size: clamp(1.4rem, 2.5vw, 1.9rem);
        font-weight: 800;
        color: var(--dash-text);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .dash-title-group p {
        color: var(--dash-muted);
        font-size: 0.95rem;
        margin-top: 0.3rem;
    }

    .dash-quick-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
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
        transition: all 0.3s ease;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .btn-lux-primary {
        background: var(--dash-red);
        color: #fff;
    }
    .btn-lux-primary:hover {
        background: #d80000;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(180, 0, 0, 0.4);
    }

    .btn-lux-gold {
        background: rgba(215, 182, 74, 0.15);
        color: var(--dash-gold);
        border-color: rgba(215, 182, 74, 0.3);
    }
    .btn-lux-gold:hover {
        background: var(--dash-gold);
        color: #000;
        transform: translateY(-2px);
    }

    .btn-lux-outline {
        background: transparent;
        color: var(--dash-text);
        border-color: var(--dash-border);
    }
    .btn-lux-outline:hover {
        border-color: var(--dash-gold);
        color: var(--dash-gold);
    }

    /* شبكة بطاقات المؤشرات الرئيسية (KPIs) */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.2rem;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 14px;
        padding: 1.4rem;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }

    .kpi-card:hover {
        transform: translateY(-4px);
        border-color: var(--dash-gold);
    }

    .kpi-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        left: 0;
        height: 3px;
        background: var(--accent-color, var(--dash-gold));
    }

    .kpi-card.red::after { --accent-color: var(--dash-red); }
    .kpi-card.green::after { --accent-color: #10B981; }
    .kpi-card.blue::after { --accent-color: #0EA5E9; }
    .kpi-card.purple::after { --accent-color: #8B5CF6; }

    .kpi-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
    }

    .kpi-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dash-muted);
    }

    .kpi-icon-badge {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        background: rgba(228, 220, 199, 0.05);
        color: var(--accent-color, var(--dash-gold));
    }

    .kpi-val {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--dash-text);
        margin-bottom: 0.4rem;
    }

    .kpi-subtext {
        font-size: 0.78rem;
        color: var(--dash-muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* شبكة الرسوم البيانية والأقسام التحليلية */
    .dash-analytics-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 1024px) {
        .dash-analytics-grid {
            grid-template-columns: 1fr;
        }
    }

    .dash-card {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 14px;
        padding: 1.5rem;
        overflow: hidden;
    }

    .card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid var(--dash-border);
    }

    .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--dash-text);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chart-container-wrapper {
        position: relative;
        width: 100%;
        min-height: 280px;
    }

    /* قمع المبيعات (Sales Funnel) */
    .funnel-list {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
    }

    .funnel-item {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .funnel-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .funnel-bar-bg {
        width: 100%;
        height: 10px;
        background: rgba(228, 220, 199, 0.08);
        border-radius: 10px;
        overflow: hidden;
    }

    .funnel-bar-fill {
        height: 100%;
        border-radius: 10px;
        background: var(--funnel-color, var(--dash-gold));
        transition: width 0.8s ease;
    }

    /* جداول العرض المدمجة */
    .dash-bottom-grid {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 1.5rem;
    }

    @media (max-width: 992px) {
        .dash-bottom-grid {
            grid-template-columns: 1fr;
        }
    }

    .dash-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    .dash-table th {
        text-align: right;
        padding: 0.8rem;
        color: var(--dash-muted);
        font-weight: 600;
        border-bottom: 1px solid var(--dash-border);
    }

    .dash-table td {
        padding: 0.9rem 0.8rem;
        border-bottom: 1px solid rgba(228, 220, 199, 0.05);
        color: var(--dash-text);
        vertical-align: middle;
    }

    .dash-table tr:hover td {
        background: rgba(228, 220, 199, 0.02);
    }

    /* شارات الحالات */
    .status-pill {
        display: inline-block;
        padding: 0.25rem 0.65rem;
        border-radius: 30px;
        font-size: 0.72rem;
        font-weight: 700;
    }
    .status-new { background: rgba(14, 165, 233, 0.15); color: #38bdf8; }
    .status-contacted { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
    .status-qualified { background: rgba(139, 92, 246, 0.15); color: #a78bfa; }
    .status-won { background: rgba(16, 185, 129, 0.15); color: #34d399; }
    .status-negotiation { background: rgba(234, 88, 12, 0.15); color: #fb923c; }

    /* ملقم التفاعل السلوكي الحي */
    .behavior-feed {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
        max-height: 400px;
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
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(215, 182, 74, 0.15);
        color: var(--dash-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.9rem;
    }

    .behavior-info {
        flex: 1;
        font-size: 0.85rem;
    }

    .behavior-text {
        color: var(--dash-text);
        font-weight: 500;
    }

    .behavior-time {
        font-size: 0.75rem;
        color: var(--dash-muted);
        margin-top: 2px;
    }
</style>

<div class="dashboard-container">

    {{-- 1. هيدر الترحيب والإجراءات السريعة --}}
    <div class="dash-header">
        <div class="dash-title-group">
            <h1>
                <i class="fa-solid fa-chart-pie" style="color:var(--dash-gold);"></i>
                <span>لوحة قيادة إدارة منصة البرلسي العقارية</span>
            </h1>
            <p>مرحباً بك، تتبع هنا مؤشرات الأداء العقاري، سلوك العملاء والـ Leads، وإدارة الوحدات في الوقت الفعلي.</p>
        </div>
        <div class="dash-quick-actions">
            <a href="{{ route('admin.projects.create') }}" class="btn-lux btn-lux-primary">
                <i class="fa-solid fa-plus"></i> إضافة مشروع جديد
            </a>
            <a href="{{ route('admin.units.index') }}" class="btn-lux btn-lux-gold">
                <i class="fa-solid fa-door-open"></i> إدارة الوحدات
            </a>
            <a href="{{ route('admin.leads.index') }}" class="btn-lux btn-lux-outline">
                <i class="fa-solid fa-filter"></i> خط سير الـ Leads
            </a>
            <a href="{{ route('admin.analytics.export') }}" class="btn-lux btn-lux-outline">
                <i class="fa-solid fa-file-excel"></i> تصدير تقرير شامل
            </a>
        </div>
    </div>

    {{-- رسائل التنبيهات والنجاح --}}
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #34d399; padding: 1rem 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- 2. بطاقات الـ KPIs الرئيسية --}}
    <div class="kpi-grid">
        <div class="kpi-card gold">
            <div class="kpi-head">
                <span class="kpi-label">إجمالي العملاء والـ Leads</span>
                <div class="kpi-icon-badge"><i class="fa-solid fa-users"></i></div>
            </div>
            <div class="kpi-val">{{ number_format($totalLeads) }}</div>
            <div class="kpi-subtext">
                <span style="color:#0ea5e9;">{{ $newLeads }} جديد</span> • 
                <span style="color:#a78bfa;">{{ $qualifiedLeads }} مؤهل جاد</span>
            </div>
        </div>

        <div class="kpi-card green">
            <div class="kpi-head">
                <span class="kpi-label">الصفقات المحسومة (Won Deals)</span>
                <div class="kpi-icon-badge"><i class="fa-solid fa-handshake"></i></div>
            </div>
            <div class="kpi-val">{{ number_format($wonDeals) }}</div>
            <div class="kpi-subtext">
                <span style="color:#10B981;">✓ تم التعاقد والبيع</span> • 
                <span>{{ $negotiationLeads }} في مرحلة التفاوض</span>
            </div>
        </div>

        <div class="kpi-card blue">
            <div class="kpi-head">
                <span class="kpi-label">مخزون الوحدات العقارية</span>
                <div class="kpi-icon-badge"><i class="fa-solid fa-building"></i></div>
            </div>
            <div class="kpi-val">{{ number_format($totalUnits) }}</div>
            <div class="kpi-subtext">
                <span style="color:#10B981;">{{ $availableUnits }} متاحة</span> • 
                <span style="color:#f59e0b;">{{ $reservedUnits }} محجوزة</span> • 
                <span style="color:#ef4444;">{{ $soldUnits }} مباعة</span>
            </div>
        </div>

        <div class="kpi-card red">
            <div class="kpi-head">
                <span class="kpi-label">المشاريع العقارية</span>
                <div class="kpi-icon-badge"><i class="fa-solid fa-city"></i></div>
            </div>
            <div class="kpi-val">{{ number_format($totalProjects) }}</div>
            <div class="kpi-subtext">
                <span>{{ $activeProjects }} مشاريع نشطة بالموقع</span>
            </div>
        </div>

        <div class="kpi-card purple">
            <div class="kpi-head">
                <span class="kpi-label">تفاعلات واهتمام الزوار</span>
                <div class="kpi-icon-badge"><i class="fa-solid fa-bolt"></i></div>
            </div>
            <div class="kpi-val">{{ number_format($totalBehaviors) }}</div>
            <div class="kpi-subtext">
                <span style="color:#25D366;"><i class="fa-brands fa-whatsapp"></i> {{ $whatsappClicks }}</span> • 
                <span style="color:#d7b64a;">{{ $brochureDownloads }} كتالوج</span> • 
                <span style="color:#38bdf8;">{{ $quizCompletions }} استشارة ذكية</span>
            </div>
        </div>

        <div class="kpi-card gold">
            <div class="kpi-head">
                <span class="kpi-label">الكروت الذكية VIP</span>
                <div class="kpi-icon-badge"><i class="fa-solid fa-id-card"></i></div>
            </div>
            <div class="kpi-val">{{ number_format($activeSmartCards) }}</div>
            <div class="kpi-subtext">
                <span>بطاقات نشطة من أصل {{ $totalSmartCards }} صادرة</span>
            </div>
        </div>
    </div>

    {{-- 3. شبكة الرسوم البيانية --}}
    <div class="dash-analytics-grid">
        {{-- رسم بياني: وتيرة جذب العملاء شهرياً --}}
        <div class="dash-card">
            <div class="card-head">
                <div class="card-title">
                    <i class="fa-solid fa-chart-line" style="color:var(--dash-gold);"></i>
                    <span>معدل استحواذ وتسجيل العملاء (آخر 6 أشهر)</span>
                </div>
                <span style="font-size:0.8rem; color:var(--dash-muted);">تحديث تلقائي</span>
            </div>
            <div class="chart-container-wrapper">
                <canvas id="leadsTrendChart"></canvas>
            </div>
        </div>

        {{-- مسار قمع تحويل العملاء (Sales Funnel) --}}
        <div class="dash-card">
            <div class="card-head">
                <div class="card-title">
                    <i class="fa-solid fa-filter-circle-dollar" style="color:var(--dash-red);"></i>
                    <span>مراحل قمع المبيعات (CRM Funnel)</span>
                </div>
            </div>
            <div class="funnel-list">
                @php
                    $colors = ['#38bdf8', '#fbbf24', '#a78bfa', '#fb923c', '#34d399', '#71717a'];
                    $ci = 0;
                @endphp
                @foreach($funnelStages as $stageName => $count)
                    @php
                        $percentage = $totalLeads > 0 ? round(($count / $totalLeads) * 100) : 0;
                        $color = $colors[$ci % count($colors)];
                        $ci++;
                    @endphp
                    <div class="funnel-item">
                        <div class="funnel-meta">
                            <span style="color: {{ $color }};">{{ $stageName }}</span>
                            <span style="color: var(--dash-text);">{{ $count }} عميل ({{ $percentage }}%)</span>
                        </div>
                        <div class="funnel-bar-bg">
                            <div class="funnel-bar-fill" style="width: {{ max($percentage, 4) }}%; --funnel-color: {{ $color }};"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- 4. رسومات دائرية ومؤشرات الطلب والميزانية --}}
    <div class="kpi-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); margin-bottom: 2rem;">
        <div class="dash-card">
            <div class="card-head">
                <div class="card-title">
                    <i class="fa-solid fa-chart-pie" style="color:var(--dash-gold);"></i>
                    <span>توزيع طلبات العملاء حسب الغرض</span>
                </div>
            </div>
            <div class="chart-container-wrapper" style="min-height: 220px;">
                <canvas id="purposeChart"></canvas>
            </div>
        </div>

        <div class="dash-card">
            <div class="card-head">
                <div class="card-title">
                    <i class="fa-solid fa-wallet" style="color:#10B981;"></i>
                    <span>توزيع ميزانيات الشراء المستهدفة</span>
                </div>
            </div>
            <div class="chart-container-wrapper" style="min-height: 220px;">
                <canvas id="budgetChart"></canvas>
            </div>
        </div>

        <div class="dash-card">
            <div class="card-head">
                <div class="card-title">
                    <i class="fa-solid fa-cubes" style="color:#8B5CF6;"></i>
                    <span>حالة مخزون الوحدات العقارية</span>
                </div>
            </div>
            <div class="chart-container-wrapper" style="min-height: 220px;">
                <canvas id="unitsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- 5. جدول آخر العملاء وسجل التفاعلات الحية --}}
    <div class="dash-bottom-grid">
        {{-- جدول آخر العملاء المسجلين --}}
        <div class="dash-card">
            <div class="card-head">
                <div class="card-title">
                    <i class="fa-solid fa-user-clock" style="color:var(--dash-gold);"></i>
                    <span>أحدث العملاء والـ Leads الوافدة</span>
                </div>
                <a href="{{ route('admin.leads.index') }}" style="color:var(--dash-gold); font-size:0.85rem; text-decoration:none;">
                    عرض الكل ({{ $totalLeads }}) ←
                </a>
            </div>

            <div style="overflow-x: auto;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>العميل</th>
                            <th>الغرض والوحدة</th>
                            <th>الميزانية</th>
                            <th>الحالة</th>
                            <th>إجراء سريع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentClients as $client)
                            <tr>
                                <td>
                                    <div style="font-weight:700;">{{ $client->full_name }}</div>
                                    <div style="font-size:0.78rem; color:var(--dash-muted);">{{ $client->phone }}</div>
                                </td>
                                <td>
                                    <span style="font-size:0.82rem;">{{ $client->purpose ?? 'عام' }}</span>
                                    <div style="font-size:0.75rem; color:var(--dash-muted);">{{ $client->project_or_city ?? 'كافة المشاريع' }}</div>
                                </td>
                                <td>
                                    <span style="font-weight:600; color:var(--dash-gold);">{{ $client->budget ?? 'مرن' }}</span>
                                </td>
                                <td>
                                    <span class="status-pill status-{{ $client->lead_status }}">
                                        {{ $client->lead_status }}
                                    </span>
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
                                <td colspan="5" style="text-align:center; color:var(--dash-muted); padding:2rem;">لا يوجد عملاء مسجلين حتى الآن.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- سجل التفاعل وسلوك الزوار المباشر (Behavior Feed) --}}
        <div class="dash-card">
            <div class="card-head">
                <div class="card-title">
                    <i class="fa-solid fa-wave-square" style="color:var(--dash-red);"></i>
                    <span>نبض سلوك الزوار المباشر (Live)</span>
                </div>
                <a href="{{ route('admin.analytics.index') }}" style="color:var(--dash-gold); font-size:0.85rem; text-decoration:none;">
                    التحليلات التفصيلية ←
                </a>
            </div>

            <div class="behavior-feed">
                @forelse($recentBehaviors as $b)
                    <div class="behavior-item">
                        <div class="behavior-icon">
                            @if($b->event_type == 'whatsapp_click')
                                <i class="fa-brands fa-whatsapp" style="color:#25D366;"></i>
                            @elseif($b->event_type == 'brochure_download')
                                <i class="fa-solid fa-file-pdf" style="color:#ef4444;"></i>
                            @elseif($b->event_type == 'quiz_complete')
                                <i class="fa-solid fa-wand-magic-sparkles" style="color:var(--dash-gold);"></i>
                            @elseif($b->event_type == 'calculator_calc')
                                <i class="fa-solid fa-calculator" style="color:#0ea5e9;"></i>
                            @else
                                <i class="fa-solid fa-eye"></i>
                            @endif
                        </div>
                        <div class="behavior-info">
                            <div class="behavior-text">
                                @if($b->event_type == 'whatsapp_click')
                                    ضغط على زر الواتساب لمشروع <strong>{{ $b->project?->name_ar ?? 'عام' }}</strong>
                                @elseif($b->event_type == 'brochure_download')
                                    قام بتحميل كتالوج مشروع <strong>{{ $b->project?->name_ar ?? 'مشروع عقاري' }}</strong>
                                @elseif($b->event_type == 'quiz_complete')
                                    أكمل استبيان المستشار العقاري الذكي بنجاح
                                @elseif($b->event_type == 'calculator_calc')
                                    استخدم حاسبة الأقساط والتمويل
                                @else
                                    تصفح صفحة: {{ $b->page_title ?? 'الموقع' }}
                                @endif
                                @if($b->client)
                                    <span style="color:var(--dash-gold);">({{ $b->client->full_name }})</span>
                                @endif
                            </div>
                            <div class="behavior-time">
                                <i class="fa-regular fa-clock"></i> {{ $b->created_at->diffForHumans() }} • 
                                <span style="text-transform: capitalize;">{{ $b->device ?? 'desktop' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; color:var(--dash-muted); padding:2rem;">
                        لا توجد تفاعلات سلوكية مسجلة بعد.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // إعدادات الخط والألوان للرسوم البيانية
        Chart.defaults.font.family = "'Cairo', sans-serif";
        Chart.defaults.color = '#8E8E93';

        // 1. رسم وتيرة جذب العملاء شهرياً
        const leadsTrendCtx = document.getElementById('leadsTrendChart');
        if (leadsTrendCtx) {
            new Chart(leadsTrendCtx, {
                type: 'line',
                data: {
                    labels: @json($monthsLabels),
                    datasets: [{
                        label: 'عدد العملاء والـ Leads',
                        data: @json($monthlyLeads),
                        borderColor: '#d7b64a',
                        backgroundColor: 'rgba(215, 182, 74, 0.1)',
                        borderWidth: 3,
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: '#B40000',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(228, 220, 199, 0.05)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 2. رسم توزيع الأغراض
        const purposeCtx = document.getElementById('purposeChart');
        if (purposeCtx) {
            new Chart(purposeCtx, {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($purposeDistribution)),
                    datasets: [{
                        data: @json(array_values($purposeDistribution)),
                        backgroundColor: ['#d7b64a', '#B40000', '#0ea5e9', '#10B981', '#8b5cf6', '#f59e0b'],
                        borderWidth: 2,
                        borderColor: '#121214'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // 3. رسم توزيع الميزانيات
        const budgetCtx = document.getElementById('budgetChart');
        if (budgetCtx) {
            new Chart(budgetCtx, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($budgetDistribution)),
                    datasets: [{
                        label: 'الطلبات',
                        data: @json(array_values($budgetDistribution)),
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
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

        // 4. رسم حالة الوحدات
        const unitsCtx = document.getElementById('unitsChart');
        if (unitsCtx) {
            new Chart(unitsCtx, {
                type: 'pie',
                data: {
                    labels: ['متاحة', 'محجوزة', 'مباعة'],
                    datasets: [{
                        data: [{{ $availableUnits }}, {{ $reservedUnits }}, {{ $soldUnits }}],
                        backgroundColor: ['#10B981', '#f59e0b', '#ef4444'],
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

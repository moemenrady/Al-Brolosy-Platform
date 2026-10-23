@extends('layouts.admin')

@section('content')
<style>
    /* ===================================== */
    /* 1. المتغيرات الخاصة بصفحة الكروت الذكية */
    /* ===================================== */
    :root {
        --sc-gold: #c5a059;
        --sc-gold-light: #d4af37;
        --sc-dark-bg: #0a0a0a;
        --sc-card-bg: #141414;
        --sc-glass-bg: rgba(20, 20, 20, 0.7);
        --sc-border: rgba(228, 220, 199, 0.15);
        --status-active: #10B981;
        --status-pending: #F59E0B;
        --status-rejected: #EF4444;
        --status-blocked: #6B7280;
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .smart-cards-page {
        font-family: 'Cairo', sans-serif;
        color: var(--text-main);
        padding-bottom: 2rem;
        direction: rtl;
    }

    .page-header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1.2rem;
        border-bottom: 1px solid var(--glass-border);
    }

    .page-header-title {
        font-size: clamp(1.3rem, 2vw, 1.8rem);
        color: var(--gold);
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }

    .btn-lux {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.7rem 1.4rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.92rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        font-family: 'Cairo', sans-serif;
        white-space: nowrap;
    }

    .btn-lux-primary { background: var(--primary-red); color: #fff; }
    .btn-lux-primary:hover { background: #d80000; transform: translateY(-2px); }
    .btn-lux-gold { background: rgba(215, 182, 74, 0.18); color: var(--gold); border: 1px solid rgba(215, 182, 74, 0.4); }
    .btn-lux-gold:hover { background: var(--gold); color: #000; transform: translateY(-2px); }

    /* ===================================== */
    /* 2. سيكشن الإحصائيات (Stats Section)   */
    /* ===================================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.2rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--sc-border);
        border-radius: 16px;
        padding: 1.2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition-smooth);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        border-color: var(--gold);
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .stat-info h4 {
        margin: 0;
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .stat-info p {
        margin: 0;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    /* ===================================== */
    /* 3. شريط البحث والفلاتر                */
    /* ===================================== */
    .filter-bar-card {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 14px;
        padding: 1rem 1.2rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .filter-tabs {
        display: flex;
        gap: 6px;
        overflow-x: auto;
    }

    .filter-tab-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.04);
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 700;
        transition: all 0.2s;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .filter-tab-btn:hover,
    .filter-tab-btn.active {
        background: rgba(215, 182, 74, 0.15);
        color: var(--gold);
        border-color: rgba(215, 182, 74, 0.35);
    }

    .search-wrapper {
        position: relative;
        flex: 1;
        max-width: 400px;
        min-width: 250px;
    }

    .search-input {
        width: 100%;
        background: #16161a !important;
        border: 1px solid rgba(215, 182, 74, 0.25) !important;
        padding: 0.65rem 2.5rem 0.65rem 1rem;
        border-radius: 10px;
        color: #ffffff !important;
        font-family: 'Cairo', sans-serif;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.3s;
    }

    .search-input:focus {
        border-color: var(--gold) !important;
        box-shadow: 0 0 10px rgba(215, 182, 74, 0.2) !important;
    }

    .search-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
    }

    /* ===================================== */
    /* 4. Showcase & 3D Interactive Card     */
    /* ===================================== */
    .showcase-section {
        background: radial-gradient(circle at center, rgba(30, 20, 20, 0.6) 0%, rgba(10, 10, 10, 0.95) 100%);
        border: 1px solid var(--sc-border);
        border-radius: 20px;
        padding: 2.5rem 1.5rem;
        margin-bottom: 2.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .showcase-info {
        text-align: center;
        margin-bottom: 2rem;
        z-index: 2;
    }

    .showcase-info h3 {
        font-size: 1.6rem;
        color: var(--gold);
        font-weight: 800;
        margin-bottom: 0.4rem;
    }

    .sc-visual-wrapper {
        perspective: 1200px;
        display: flex;
        justify-content: center;
        z-index: 2;
        width: 100%;
    }
    
    .sc-card-floater {
        animation: floatingCard 4s ease-in-out infinite;
        width: 100%;
        display: flex;
        justify-content: center;
    }
    
    @keyframes floatingCard {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .sc-card-mockup {
        width: 100%;
        max-width: 380px;
        aspect-ratio: 1.6 / 1;
        border-radius: 18px;
        padding: 1.6rem;
        position: relative;
        overflow: hidden;
        background: radial-gradient(circle at top right, rgba(255, 255, 255, .18) 0%, transparent 35%),
                    linear-gradient(135deg, #4d0f1c 0%, #6d1026 35%, #86162f 70%, #5b0d20 100%);
        border: 1px solid rgba(212, 175, 55, .4);
        box-shadow: 0 20px 45px rgba(0, 0, 0, .6), inset 0 1px 0 rgba(255, 255, 255, .2);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transform-style: preserve-3d;
        transition: transform .1s ease-out;
    }
    
    .sc-card-mockup::before {
        content: ""; position: absolute; inset: 0;
        background: linear-gradient(120deg, transparent 0%, rgba(255, 255, 255, .08) 35%, transparent 70%);
        opacity: .8; pointer-events: none;
    }
    
    .sc-card-top { display: flex; justify-content: space-between; align-items: flex-start; z-index: 2; }
    .sc-card-inner-logo span { color: var(--gold); font-weight: 800; font-size: 1.25rem; letter-spacing: 1px; }
    .sc-card-chip { width: 45px; height: 35px; background: linear-gradient(135deg, var(--sc-gold-light) 0%, #8a6309 100%); border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.3); }
    .sc-card-bottom { z-index: 2; direction: ltr; text-align: left; }
    .sc-card-number-preview { font-family: 'Courier New', monospace; font-size: clamp(1.1rem, 5vw, 1.45rem); letter-spacing: 3px; color: #FFF9F1; text-shadow: 0 2px 8px rgba(0,0,0,.6); font-weight: bold; }
    .sc-card-name-preview { font-size: 0.95rem; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 1.5px; margin-top: 4px; }

    /* ===================================== */
    /* 5. Cards Grid View                    */
    /* ===================================== */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .grid-card {
        background: var(--bg-card);
        border: 1px solid var(--sc-border);
        border-radius: 16px;
        padding: 1.4rem;
        cursor: pointer;
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 160px;
    }

    .grid-card:hover {
        transform: translateY(-5px);
        border-color: var(--gold);
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    }

    .grid-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .card-id { color: var(--text-muted); font-size: 0.85rem; font-weight: 700; }
    .status-badge {
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .status-active { color: var(--status-active); background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); }
    .status-pending { color: var(--status-pending); background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); }
    .status-rejected { color: var(--status-rejected); background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); }
    .status-blocked { color: var(--status-blocked); background: rgba(107, 114, 128, 0.2); border: 1px solid rgba(107, 114, 128, 0.4); }

    .grid-card-body .c-num {
        font-family: 'Courier New', monospace;
        font-size: 1.15rem;
        color: var(--gold);
        margin-bottom: 0.6rem;
        font-weight: 800;
        letter-spacing: 1px;
    }
    .grid-card-body .c-client {
        color: var(--text-main);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-actions-bar {
        display: flex;
        gap: 8px;
        margin-top: 1rem;
        padding-top: 0.8rem;
        border-top: 1px dashed var(--sc-border);
    }

    .card-action-btn {
        flex: 1;
        padding: 6px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-family: 'Cairo', sans-serif;
        transition: all 0.2s;
    }

    .btn-action-edit {
        background: rgba(215, 182, 74, 0.15);
        color: var(--gold);
    }
    .btn-action-edit:hover { background: var(--gold); color: #000; }

    .btn-action-unlink {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
    }
    .btn-action-unlink:hover { background: #EF4444; color: #fff; }

    /* ===================================== */
    /* 6. Modals Styling                     */
    /* ===================================== */
    .custom-modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(8px);
        z-index: 2000; display: none; align-items: center; justify-content: center;
        padding: 1rem;
    }
    .custom-modal-overlay.active { display: flex; }

    .custom-modal {
        background: #141418;
        border: 1px solid var(--gold);
        border-radius: 20px;
        width: 100%; max-width: 750px; max-height: 90vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 60px rgba(0,0,0,0.8);
        overflow: hidden;
    }

    .modal-header {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid var(--sc-border);
        display: flex; justify-content: space-between; align-items: center;
        background: rgba(255,255,255,0.02);
    }
    .modal-header h4 { color: var(--gold); font-size: 1.2rem; margin: 0; display: flex; align-items: center; gap: 10px; }
    .close-modal { background: none; border: none; color: var(--text-muted); font-size: 1.5rem; cursor: pointer; transition: color 0.3s; }
    .close-modal:hover { color: var(--primary-red); }

    .modal-body { 
        padding: 1.5rem; 
        overflow-y: auto; 
    }

    .modal-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;
    }

    .info-section {
        background: rgba(255, 255, 255, 0.02); padding: 1.2rem; border-radius: 12px; border: 1px solid var(--sc-border);
        margin-bottom: 1.2rem;
    }
    .info-section-title {
        color: var(--gold); font-size: 1.05rem; margin-bottom: 1rem; border-bottom: 1px dashed var(--sc-border); padding-bottom: 0.5rem; font-weight: 800;
    }
    
    .info-row { display: flex; justify-content: space-between; margin-bottom: 0.8rem; font-size: 0.95rem; flex-wrap: wrap; gap: 5px; }
    .info-label { color: var(--text-muted); }
    .info-value { color: var(--text-main); font-weight: 600; text-align: left; }

    /* Explicit high-contrast form controls */
    .form-group { margin-bottom: 1.2rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.88rem; font-weight: 700; }
    
    .form-control-lux {
        width: 100%;
        padding: 0.8rem 1rem;
        background: #16161a !important;
        border: 1px solid rgba(215, 182, 74, 0.3) !important;
        border-radius: 10px;
        color: #ffffff !important;
        font-family: 'Cairo', sans-serif;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s;
    }
    .form-control-lux:focus {
        border-color: var(--gold) !important;
        box-shadow: 0 0 10px rgba(215, 182, 74, 0.25) !important;
    }

    select.form-control-lux,
    select.form-control-lux option,
    select.form-control-lux optgroup {
        background-color: #1a1a20 !important;
        color: #ffffff !important;
        padding: 10px !important;
    }

    .btn-submit {
        background: var(--gold); color: #000; border: none; padding: 0.85rem 2rem; border-radius: 10px;
        font-weight: 800; cursor: pointer; transition: all 0.3s; width: 100%; font-family: 'Cairo'; margin-top: 0.5rem;
    }
    .btn-submit:hover { background: var(--sc-gold-light); transform: translateY(-2px); }

    @media (max-width: 768px) {
        .modal-grid { grid-template-columns: 1fr; gap: 1rem; }
        .page-header-container { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="smart-cards-page">
    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #6ee7b7; padding: 1rem 1.4rem; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 700;">
            <i class="fa-solid fa-circle-check ml-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- رأس الصفحة مع الأزرار الإجرائية السريعة --}}
    <div class="page-header-container">
        <div>
            <h1 class="page-header-title">
                <i class="fa-solid fa-id-card-clip"></i>
                <span>إدارة وتفعيل الكروت الذكية VIP</span>
            </h1>
            <p style="color:var(--text-muted); font-size:0.9rem; margin-top:4px;">
                ربط وتفعيل كروت الولاء للعملاء الفعليين، إدارة حالات الكروت، وتوليد كروت جديدة للمخزون.
            </p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <button type="button" onclick="openAssignModal()" class="btn-lux btn-lux-primary">
                <i class="fa-solid fa-user-check"></i>
                <span>تفعيل كارت لعميل VIP</span>
            </button>
            <button type="button" onclick="openGenerateModal()" class="btn-lux btn-lux-gold">
                <i class="fa-solid fa-microchip"></i>
                <span>توليد كروت للمخزون</span>
            </button>
        </div>
    </div>

    {{-- شبكة الإحصائيات السريعة --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(212, 175, 55, 0.12); color: var(--gold);">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div class="stat-info">
                <h4>{{ number_format($stats['total']) }}</h4>
                <p>إجمالي الكروت</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.12); color: var(--status-active);">
                <i class="fa-solid fa-check-double"></i>
            </div>
            <div class="stat-info">
                <h4>{{ number_format($stats['active']) }}</h4>
                <p>كروت مفعلة ونشطة</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.12); color: var(--status-pending);">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div class="stat-info">
                <h4>{{ number_format($stats['pending']) }}</h4>
                <p>متاحة بالمخزون</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.12); color: var(--status-rejected);">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div class="stat-info">
                <h4>{{ number_format($stats['blocked']) }}</h4>
                <p>محظورة / ملغاة</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59, 130, 246, 0.12); color: #60a5fa;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <h4>{{ number_format($stats['assigned']) }}</h4>
                <p>مرتبطة بعملاء</p>
            </div>
        </div>
    </div>

    {{-- شريط الفلاتر والبحث --}}
    <div class="filter-bar-card">
        <div class="filter-tabs">
            <a href="{{ route('admin.smart-cards') }}" class="filter-tab-btn {{ !request('status') ? 'active' : '' }}">
                الكل ({{ $stats['total'] }})
            </a>
            <a href="{{ route('admin.smart-cards', ['status' => 'active']) }}" class="filter-tab-btn {{ request('status') === 'active' ? 'active' : '' }}">
                المفعلة ({{ $stats['active'] }})
            </a>
            <a href="{{ route('admin.smart-cards', ['status' => 'pending']) }}" class="filter-tab-btn {{ request('status') === 'pending' ? 'active' : '' }}">
                مخزون غير مفعل ({{ $stats['pending'] }})
            </a>
            <a href="{{ route('admin.smart-cards', ['status' => 'assigned']) }}" class="filter-tab-btn {{ request('status') === 'assigned' ? 'active' : '' }}">
                المرتبطة بعملاء ({{ $stats['assigned'] }})
            </a>
            <a href="{{ route('admin.smart-cards', ['status' => 'blocked']) }}" class="filter-tab-btn {{ request('status') === 'blocked' ? 'active' : '' }}">
                المحظورة ({{ $stats['blocked'] }})
            </a>
        </div>

        <form action="{{ route('admin.smart-cards') }}" method="GET" style="display:flex; gap:8px;">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" name="search" class="search-input" value="{{ request('search') }}" placeholder="بحث برقم الكارت، اسم العميل، الهاتف...">
            </div>
            <button type="submit" class="btn-lux btn-lux-gold" style="padding:0.65rem 1rem;">بحث</button>
        </form>
    </div>

    {{-- استعراض الكارت المجسم 3D --}}
    @php
        $featuredCard = $cards->firstWhere('status', 'active') ?? $cards->first();
        $featuredClientName = $featuredCard && $featuredCard->client ? $featuredCard->client->full_name : 'ALBROLOSY VIP MEMBER';
        $featuredCardNumber = $featuredCard ? $featuredCard->card_number : 'ALB-VIP-88992';
    @endphp

    <div class="showcase-section" id="showcase-wrapper">
        <div class="showcase-info">
            <h3>منظومة البرلسي للكروت الذكية الفاخرة</h3>
            <p style="color: var(--text-muted); font-size:0.95rem; margin:0;">
                كارت العضوية الحصري لملاك وحدات وعملاء البرلسي للتطوير العقاري
            </p>
        </div>

        <div class="sc-visual-wrapper">
            <div class="sc-card-floater">
                <div class="sc-card-mockup" id="showcase-card">
                    <div class="sc-card-top">
                        <div class="sc-card-inner-logo">
                            <span>ALBROLOSY</span>
                            <div style="font-size:0.65rem; color:#fff; opacity:0.8; letter-spacing:2px;">VIP RESIDENCE</div>
                        </div>
                        <div class="sc-card-chip"></div>
                    </div>
                    <div class="sc-card-bottom">
                        <div class="sc-card-number-preview" id="preview-card-num">{{ $featuredCardNumber }}</div>
                        <div class="sc-card-name-preview" id="preview-client-name">{{ $featuredClientName }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- شبكة الكروت --}}
    <div class="cards-grid">
        @forelse($cards as $card)
            @php
                $clientName = $card->client ? $card->client->full_name : 'غير مخصص لعميل بعد';
                $clientPhone = $card->client ? $card->client->phone : '';
                
                switch($card->status) {
                    case 'active':
                        $statusClass = 'status-active';
                        $statusText = 'نشط (مفعل)';
                        break;
                    case 'pending':
                        $statusText = 'متاح بالمخزون (غير مفعل)';
                        $statusClass = 'status-pending';
                        break;
                    case 'blocked':
                        $statusText = 'محظور';
                        $statusClass = 'status-blocked';
                        break;
                    case 'rejected':
                        $statusText = 'مرفوض';
                        $statusClass = 'status-rejected';
                        break;
                    default:
                        $statusText = $card->status;
                        $statusClass = 'status-pending';
                }
            @endphp

            <div class="grid-card" onclick="openCardModal({{ json_encode([
                'id' => $card->id,
                'number' => $card->card_number,
                'status' => $card->status,
                'status_ar' => $statusText,
                'note' => $card->status_note,
                'client_name' => $clientName,
                'client_phone' => $clientPhone,
                'created_at' => $card->created_at ? $card->created_at->format('Y-m-d') : '--',
                'activated_at' => $card->activated_at ? $card->activated_at->format('Y-m-d H:i') : 'غير مفعل'
            ]) }})">
                <div class="grid-card-header">
                    <span class="card-id">#{{ $card->id }}</span>
                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                </div>
                <div class="grid-card-body">
                    <div class="c-num">{{ $card->card_number }}</div>
                    <div class="c-client">
                        <i class="fa-solid fa-user-tie" style="color: var(--gold);"></i>
                        <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 90%;">
                            {{ $clientName }}
                        </span>
                    </div>
                    @if($clientPhone)
                        <div style="font-size:0.8rem; color:var(--text-muted); margin-top:4px;" dir="ltr">
                            <i class="fa-solid fa-phone" style="font-size:0.75rem;"></i> {{ $clientPhone }}
                        </div>
                    @endif
                </div>

                <div class="card-actions-bar" onclick="event.stopPropagation()">
                    <button type="button" class="card-action-btn btn-action-edit" onclick="openCardModal({{ json_encode([
                        'id' => $card->id,
                        'number' => $card->card_number,
                        'status' => $card->status,
                        'status_ar' => $statusText,
                        'note' => $card->status_note,
                        'client_name' => $clientName,
                        'client_phone' => $clientPhone,
                        'created_at' => $card->created_at ? $card->created_at->format('Y-m-d') : '--',
                        'activated_at' => $card->activated_at ? $card->activated_at->format('Y-m-d H:i') : 'غير مفعل'
                    ]) }})">
                        <i class="fa-solid fa-sliders"></i> تعديل الحالة
                    </button>

                    @if($card->client_id)
                        <form action="{{ route('admin.smart-cards.unlink', $card->id) }}" method="POST" onsubmit="return confirm('هل تريد فك ارتباط هذا الكارت من العميل وإعادته للمخزون؟')" style="margin:0; flex:1;">
                            @csrf
                            <button type="submit" class="card-action-btn btn-action-unlink" style="width:100%;">
                                <i class="fa-solid fa-link-slash"></i> فك الارتباط
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem; color: var(--text-muted); background:var(--bg-card); border-radius:16px;">
                <i class="fa-solid fa-id-card" style="font-size:3rem; color:var(--gold); margin-bottom:1rem; display:block;"></i>
                <h4>لا توجد كروت ذكية مطابقة للبحث أو الفلتر الحالي</h4>
            </div>
        @endforelse
    </div>

    {{-- روابط الترقيم --}}
    <div style="margin-top: 2.5rem;">
        {{ $cards->links() }}
    </div>
</div>

{{-- مودال 1: تفعيل كارت لعميل فعلي --}}
<div class="custom-modal-overlay" id="assignModalOverlay">
    <div class="custom-modal">
        <div class="modal-header">
            <h4><i class="fa-solid fa-user-check"></i> تفعيل كارت ذكي VIP لعميل</h4>
            <button class="close-modal" onclick="closeAssignModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.smart-cards.assign') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>اختر العميل المستهدف <span style="color:var(--primary-red);">*</span></label>
                    <select name="client_id" class="form-control-lux" required>
                        <option value="">-- اضغط لاختيار العميل --</option>
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}">
                                {{ $c->full_name }} ({{ $c->phone ?: 'بدون هاتف' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>اختيار الكارت (اختياري)</label>
                    <select name="card_id" class="form-control-lux">
                        <option value="">-- اختيار تلقائي: أول كارت متاح بالمخزون --</option>
                        @foreach($availableCards as $ac)
                            <option value="{{ $ac->id }}">{{ $ac->card_number }} (متاح بالمخزون)</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>ملاحظات التفعيل</label>
                    <textarea name="status_note" class="form-control-lux" rows="2" placeholder="مثال: تم تسليم الكارت الفعلي للعميل في مقر الشركة"></textarea>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-check"></i> حفظ وتفعيل الكارت للعميل فوراً
                </button>
            </form>
        </div>
    </div>
</div>

{{-- مودال 2: توليد كروت جديدة للمخزون --}}
<div class="custom-modal-overlay" id="generateModalOverlay">
    <div class="custom-modal" style="max-width: 500px;">
        <div class="modal-header">
            <h4><i class="fa-solid fa-microchip"></i> توليد كروت ذكية جديدة للمخزون</h4>
            <button class="close-modal" onclick="closeGenerateModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.smart-cards.generate') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>العدد المطلوب توليده <span style="color:var(--primary-red);">*</span></label>
                    <select name="count" class="form-control-lux" required>
                        <option value="10">10 كروت ذكية</option>
                        <option value="25" selected>25 كارت ذكي</option>
                        <option value="50">50 كارت ذكي</option>
                        <option value="100">100 كارت ذكي</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>بادئة رقم الكارت (Prefix)</label>
                    <input type="text" name="prefix" class="form-control-lux" value="ALB-VIP" placeholder="مثال: ALB-VIP">
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-plus-circle"></i> توليد وإضافة إلى المخزون
                </button>
            </form>
        </div>
    </div>
</div>

{{-- مودال 3: تفاصيل وتعديل حالة الكارت --}}
<div class="custom-modal-overlay" id="cardModalOverlay">
    <div class="custom-modal">
        <div class="modal-header">
            <h4><i class="fa-solid fa-microchip"></i> تفاصيل الكارت الذكي</h4>
            <button class="close-modal" onclick="closeCardModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <div class="modal-body">
            <div class="modal-grid">
                <div>
                    <div class="info-section">
                        <h5 class="info-section-title">بيانات الكارت</h5>
                        <div class="info-row"><span class="info-label">رقم الكارت:</span> <span class="info-value" id="m-card-number" style="font-family: monospace; letter-spacing:1px; color:var(--gold);"></span></div>
                        <div class="info-row"><span class="info-label">الحالة الحالية:</span> <span class="info-value status-badge" id="m-card-status"></span></div>
                        <div class="info-row"><span class="info-label">تاريخ الإنشاء:</span> <span class="info-value" id="m-card-created"></span></div>
                        <div class="info-row"><span class="info-label">تاريخ التفعيل:</span> <span class="info-value" id="m-card-activated"></span></div>
                    </div>

                    <div class="info-section">
                        <h5 class="info-section-title">بيانات العميل المرتبط</h5>
                        <div class="info-row"><span class="info-label">الاسم:</span> <span class="info-value" id="m-client-name"></span></div>
                        <div class="info-row"><span class="info-label">رقم الهاتف:</span> <span class="info-value" id="m-client-phone" dir="ltr"></span></div>
                    </div>
                </div>

                <div>
                    <div class="info-section" style="border-color: var(--primary-red);">
                        <h5 class="info-section-title" style="color: var(--primary-red);"><i class="fa-solid fa-sliders"></i> تحديث حالة الكارت</h5>
                        <form id="editCardForm" method="POST" action="">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>حالة الكارت</label>
                                <select name="status" id="m-edit-status" class="form-control-lux">
                                    <option value="active">نشط (Active)</option>
                                    <option value="pending">متاح بالمخزون (Pending)</option>
                                    <option value="blocked">محظور (Blocked)</option>
                                    <option value="rejected">مرفوض (Rejected)</option>
                                    <option value="under_review">قيد المراجعة (Under Review)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>ملاحظات الحالة</label>
                                <textarea name="status_note" id="m-edit-note" class="form-control-lux" rows="3" placeholder="ملاحظات الإدارة..."></textarea>
                            </div>
                            <button type="submit" class="btn-submit">حفظ تحديث الحالة</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Modals management
    const cardModalOverlay = document.getElementById('cardModalOverlay');
    const assignModalOverlay = document.getElementById('assignModalOverlay');
    const generateModalOverlay = document.getElementById('generateModalOverlay');
    const editForm = document.getElementById('editCardForm');

    function openCardModal(cardData) {
        document.getElementById('m-card-number').innerText = cardData.number;
        document.getElementById('m-card-created').innerText = cardData.created_at;
        document.getElementById('m-card-activated').innerText = cardData.activated_at;
        document.getElementById('m-client-name').innerText = cardData.client_name;
        document.getElementById('m-client-phone').innerText = cardData.client_phone || 'غير مسجل';

        const statusEl = document.getElementById('m-card-status');
        statusEl.innerText = cardData.status_ar;
        statusEl.className = 'info-value status-badge';
        if (cardData.status === 'active') statusEl.classList.add('status-active');
        else if (cardData.status === 'pending') statusEl.classList.add('status-pending');
        else if (cardData.status === 'blocked') statusEl.classList.add('status-blocked');
        else statusEl.classList.add('status-rejected');

        document.getElementById('m-edit-status').value = cardData.status;
        document.getElementById('m-edit-note').value = cardData.note || '';

        editForm.action = `/admin/smart-cards/${cardData.id}`;
        cardModalOverlay.classList.add('active');
    }

    function closeCardModal() { cardModalOverlay.classList.remove('active'); }
    function openAssignModal() { assignModalOverlay.classList.add('active'); }
    function closeAssignModal() { assignModalOverlay.classList.remove('active'); }
    function openGenerateModal() { generateModalOverlay.classList.add('active'); }
    function closeGenerateModal() { generateModalOverlay.classList.remove('active'); }

    // Close on overlay click
    [cardModalOverlay, assignModalOverlay, generateModalOverlay].forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('active');
        });
    });

    // 2. 3D Card Hover Interaction
    const wrapper = document.getElementById('showcase-wrapper');
    const card3D = document.getElementById('showcase-card');
    if (wrapper && card3D) {
        wrapper.addEventListener('mousemove', (e) => {
            const rect = wrapper.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = ((y - centerY) / centerY) * -12;
            const rotateY = ((x - centerX) / centerX) * 12;
            card3D.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });
        wrapper.addEventListener('mouseleave', () => {
            card3D.style.transform = `rotateX(0deg) rotateY(0deg)`;
            card3D.style.transition = `transform 0.4s ease`;
            setTimeout(() => card3D.style.transition = `transform .1s ease-out`, 400);
        });
    }
</script>
@endsection
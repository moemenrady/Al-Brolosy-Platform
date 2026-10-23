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
    }

    .page-header-title {
        font-size: 1.8rem;
        color: var(--gold);
        margin-bottom: 2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* ===================================== */
    /* 2. سيكشن الإحصائيات (Stats Section)   */
    /* ===================================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--sc-border);
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition-smooth);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: var(--gold);
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-info h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .stat-info p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    /* ===================================== */
    /* 3. شريط البحث (Search Section)        */
    /* ===================================== */
    .search-section {
        margin-bottom: 2.5rem;
        display: flex;
        justify-content: center;
    }

    .search-wrapper {
        position: relative;
        width: 100%;
        max-width: 600px;
    }

    .search-icon {
        position: absolute;
        right: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gold);
        font-size: 1.2rem;
    }

    .search-input {
        width: 100%;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--sc-border);
        border-radius: 30px;
        padding: 1rem 3rem 1rem 1.5rem;
        color: var(--text-main);
        font-family: 'Cairo', sans-serif;
        font-size: 1rem;
        transition: var(--transition-smooth);
        outline: none;
    }

    .search-input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        background: rgba(0, 0, 0, 0.5);
    }

    /* ===================================== */
    /* 4. Section 1: Showcase 3D Card        */
    /* ===================================== */
    .showcase-section {
        background: radial-gradient(circle at 50% 50%, #1a1a24 0%, var(--bg-card) 100%);
        border-radius: 20px;
        padding: 3rem 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 3rem;
        border: 1px solid var(--sc-border);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        position: relative;
        overflow: hidden;
    }

    .showcase-info {
        text-align: center;
        margin-bottom: 2.5rem;
        z-index: 2;
    }

    .showcase-info h3 {
        font-size: 1.6rem;
        color: var(--warm-beige);
        margin-bottom: 0.5rem;
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
        50% { transform: translateY(-12px); }
        100% { transform: translateY(0px); }
    }
    
    .sc-card-mockup {
        width: 100%;
        max-width: 360px;
        aspect-ratio: 1.6 / 1; /* الحفاظ على نسبة طول وعرض الكارت */
        border-radius: 18px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        background: radial-gradient(circle at top right, rgba(255, 255, 255, .18) 0%, transparent 35%),
                    linear-gradient(135deg, #4d0f1c 0%, #6d1026 35%, #86162f 70%, #5b0d20 100%);
        border: 1px solid rgba(212, 175, 55, .25);
        box-shadow: 0 20px 45px rgba(0, 0, 0, .45), inset 0 1px 0 rgba(255, 255, 255, .15);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transform-style: preserve-3d;
        transition: transform .1s ease-out;
    }
    
    .sc-card-mockup::before {
        content: ""; position: absolute; inset: 0;
        background: linear-gradient(120deg, transparent 0%, rgba(255, 255, 255, .06) 35%, transparent 70%);
        opacity: .8; pointer-events: none;
    }
    
    .sc-card-top { display: flex; justify-content: space-between; align-items: flex-start; z-index: 2; transform: translateZ(20px); }
    .sc-card-inner-logo span { color: var(--warm-beige); font-weight: bold; font-size: 1.2rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5)); }
    .sc-card-chip { width: 45px; height: 35px; background: linear-gradient(135deg, var(--sc-gold-light) 0%, #8a6309 100%); border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.3); }
    .sc-card-bottom { z-index: 2; transform: translateZ(30px); direction: ltr; text-align: left; }
    .sc-card-number-preview { font-family: 'Courier New', monospace; font-size: clamp(1rem, 5vw, 1.42rem); letter-spacing: 3px; color: #FFF9F1; text-shadow: 0 2px 8px rgba(0,0,0,.45); }
    .sc-card-name-preview { font-size: 0.95rem; color: rgba(255,255,255,0.85); text-transform: uppercase; letter-spacing: 1.5px; }

    /* ===================================== */
    /* 5. Section 2: Cards Grid View         */
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
        padding: 1.5rem;
        cursor: pointer;
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 140px;
    }

    .grid-card:hover {
        transform: translateY(-5px);
        border-color: var(--gold);
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }

    .grid-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .card-id { color: var(--text-muted); font-size: 0.9rem; }
    .status-badge {
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        background: rgba(255,255,255,0.1);
        white-space: nowrap;
    }
    .status-active { color: var(--status-active); background: rgba(16, 185, 129, 0.1); }
    .status-pending { color: var(--status-pending); background: rgba(245, 158, 11, 0.1); }
    .status-rejected { color: var(--status-rejected); background: rgba(239, 68, 68, 0.1); }
    .status-blocked { color: var(--status-blocked); background: rgba(107, 114, 128, 0.1); }

    .grid-card-body .c-num {
        font-family: 'Courier New', monospace;
        font-size: 1.15rem;
        color: var(--warm-beige);
        margin-bottom: 0.8rem;
        letter-spacing: 1px;
    }
    .grid-card-body .c-client {
        color: var(--text-main);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ===================================== */
    /* 6. Modal Styling                      */
    /* ===================================== */
    .custom-modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(8px);
        z-index: 2000; display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden; transition: var(--transition-smooth);
        padding: 1rem; /* حماية من الالتصاق بحواف الموبايل */
    }
    .custom-modal-overlay.active { opacity: 1; visibility: visible; }

    .custom-modal {
        background: var(--bg-main);
        border: 1px solid var(--gold);
        border-radius: 20px;
        width: 100%; max-width: 900px; max-height: 90vh;
        display: flex;
        flex-direction: column;
        transform: scale(0.9); transition: var(--transition-smooth);
        box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    }
    .custom-modal-overlay.active .custom-modal { transform: scale(1); }

    .modal-header {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid var(--sc-border);
        display: flex; justify-content: space-between; align-items: center;
        background: rgba(255,255,255,0.02);
        border-radius: 20px 20px 0 0;
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
        background: var(--bg-card); padding: 1.2rem; border-radius: 12px; border: 1px solid var(--sc-border);
        margin-bottom: 1.5rem;
    }
    .info-section-title {
        color: var(--warm-beige); font-size: 1.1rem; margin-bottom: 1rem; border-bottom: 1px dashed var(--sc-border); padding-bottom: 0.5rem;
    }
    
    .info-row { display: flex; justify-content: space-between; margin-bottom: 0.8rem; font-size: 0.95rem; flex-wrap: wrap; gap: 5px; }
    .info-label { color: var(--text-muted); }
    .info-value { color: var(--text-main); font-weight: 500; text-align: left; }

    /* Points Section specific */
    .points-display { text-align: center; margin-bottom: 1.5rem; background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 10px; border: 1px solid rgba(212,175,55,0.1); }
    .points-number { font-size: 2.2rem; color: var(--gold); font-weight: bold; line-height: 1.2; margin-bottom: 5px; }
    .points-history { max-height: 200px; overflow-y: auto; padding-right: 5px; }
    .history-item { display: flex; justify-content: space-between; padding: 0.8rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.9rem; align-items: center; }
    .history-item:last-child { border-bottom: none; }
    .history-add { color: var(--status-active); font-weight: bold; }
    .history-sub { color: var(--status-rejected); font-weight: bold; }

    /* Edit Form */
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem; }
    .form-control {
        width: 100%; padding: 0.8rem 1rem; background: rgba(0,0,0,0.2); border: 1px solid var(--sc-border);
        border-radius: 8px; color: var(--text-main); font-family: 'Cairo'; outline: none; transition: border 0.3s;
    }
    .form-control:focus { border-color: var(--gold); }
    .btn-submit {
        background: var(--gold); color: #000; border: none; padding: 0.8rem 2rem; border-radius: 8px;
        font-weight: bold; cursor: pointer; transition: all 0.3s; width: 100%; font-family: 'Cairo'; margin-top: 0.5rem;
    }
    .btn-submit:hover { background: var(--sc-gold-light); transform: translateY(-2px); }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(228, 220, 199, 0.2); border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--gold); }

    /* ===================================== */
    /* 7. التجاوب (Mobile Responsive)        */
    /* ===================================== */
    @media (max-width: 768px) {
        .page-header-title { font-size: 1.5rem; }
        .showcase-section { padding: 2rem 1rem; }
        .showcase-info h3 { font-size: 1.3rem; }
        .modal-grid { grid-template-columns: 1fr; gap: 1rem; }
        .info-section { padding: 1rem; }
        .stats-grid { grid-template-columns: 1fr 1fr; gap: 1rem; }
        .stat-card { padding: 1rem; flex-direction: column; text-align: center; gap: 0.5rem; }
        .stat-icon { width: 40px; height: 40px; font-size: 1.2rem; }
        .stat-info h4 { font-size: 1.4rem; }
    }
    
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
        .sc-card-mockup { padding: 1.2rem; }
        .sc-card-inner-logo span { font-size: 1rem; }
        .cards-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="smart-cards-page">
    <h2 class="page-header-title">
        <i class="fa-regular fa-id-card"></i> إدارة الكروت الذكية (VIP)
    </h2>

    @php
        // حساب الإحصائيات ديناميكياً
        $totalCards = $cards->count();
        $activeCards = $cards->where('status', 'active')->count();
        $pendingCards = $cards->whereIn('status', ['pending', 'under_review'])->count();
        $inactiveCards = $totalCards - $activeCards - $pendingCards;
    @endphp

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(212, 175, 55, 0.1); color: var(--gold);">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $totalCards }}</h4>
                <p>إجمالي الكروت</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--status-active);">
                <i class="fa-solid fa-check-double"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $activeCards }}</h4>
                <p>كروت مفعلة (نشطة)</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--status-pending);">
                <i class="fa-regular fa-clock"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $pendingCards }}</h4>
                <p>قيد الانتظار/المراجعة</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--status-rejected);">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $inactiveCards }}</h4>
                <p>مرفوض / محظور</p>
            </div>
        </div>
    </div>

    <div class="search-section">
        <div class="search-wrapper">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" id="smartSearchInput" class="search-input" placeholder="ابحث برقم الكارت، اسم العميل، أو رقم الهاتف...">
        </div>
    </div>

    <div class="showcase-section">
        <div class="showcase-info">
            <h3>منظومة البرلسي للكروت الذكية</h3>
            <p style="color: var(--text-muted);">إدارة وتتبع ولائيات العملاء باحترافية</p>
        </div>
        
        <div class="sc-visual-wrapper" id="showcase-wrapper">
            <div class="sc-card-floater">
                <div class="sc-card-mockup" id="showcase-card">
                    <div class="sc-card-top">
                        <div class="sc-card-inner-logo">
                            <span>ALBROLOSY VIP</span>
                        </div>
                        <div class="sc-card-chip"></div>
                    </div>
                    <div class="sc-card-bottom">
                        <div class="sc-card-number-preview">**** **** **** 8945</div>
                        <div class="sc-card-name-preview">ALBROLOSY MEMBER</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cards-grid" id="cardsGridContainer">
        @forelse($cards as $card)
            @php
                $statusClass = match($card->status) {
                    'active' => 'status-active',
                    'pending', 'under_review' => 'status-pending',
                    'rejected', 'blocked', 'cancelled' => 'status-rejected',
                    default => 'status-blocked',
                };
                $statusText = match($card->status) {
                    'active' => 'نشط',
                    'pending' => 'قيد الانتظار',
                    'under_review' => 'قيد المراجعة',
                    'approved' => 'مقبول',
                    'rejected' => 'مرفوض',
                    'blocked' => 'محظور',
                    'expired' => 'منتهي',
                    'cancelled' => 'ملغي',
                    default => $card->status,
                };
                // تجهيز داتا البحث
                $clientName = $card->client ? $card->client->name : 'بدون عميل';
                $clientPhone = $card->client ? $card->client->phone : '';
                $searchData = strtolower($card->card_number . ' ' . $clientName . ' ' . $clientPhone);
            @endphp
            
            <div class="grid-card search-item" data-search="{{ $searchData }}" onclick="openCardModal({{ json_encode([
                'id' => $card->id,
                'number' => $card->card_number ?? 'غير مصدر بعد',
                'status' => $card->status,
                'status_ar' => $statusText,
                'note' => $card->status_note,
                'client_name' => $clientName,
                'client_phone' => $clientPhone,
                'created_at' => $card->created_at->format('Y-m-d H:i'),
                'activated_at' => $card->activated_at ? $card->activated_at->format('Y-m-d H:i') : 'لم يفعل'
            ]) }})">
                <div class="grid-card-header">
                    <span class="card-id">#{{ $card->id }}</span>
                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                </div>
                <div class="grid-card-body">
                    <div class="c-num">{{ $card->card_number ? implode(' ', str_split($card->card_number, 4)) : '**** **** **** ****' }}</div>
                    <div class="c-client">
                        <i class="fa-solid fa-user-tie" style="color: var(--gold);"></i>
                        <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 90%;">{{ $clientName }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div id="no-data-msg" style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--text-muted);">
                لا توجد كروت ذكية مسجلة حالياً.
            </div>
        @endforelse
    </div>
    
    <div id="no-search-results" style="display: none; text-align: center; padding: 3rem; color: var(--text-muted);">
        لا توجد نتائج مطابقة لبحثك.
    </div>
</div>

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
                        <div class="info-row"><span class="info-label">تاريخ الطلب:</span> <span class="info-value" id="m-card-created"></span></div>
                        <div class="info-row"><span class="info-label">تاريخ التفعيل:</span> <span class="info-value" id="m-card-activated"></span></div>
                    </div>

                    <div class="info-section">
                        <h5 class="info-section-title">بيانات العميل المرتبط</h5>
                        <div class="info-row"><span class="info-label">الاسم:</span> <span class="info-value" id="m-client-name"></span></div>
                        <div class="info-row"><span class="info-label">رقم الهاتف:</span> <span class="info-value" id="m-client-phone" dir="ltr"></span></div>
                    </div>

                    <div class="info-section" style="border-color: var(--primary-red);">
                        <h5 class="info-section-title" style="color: var(--primary-red);">تعديل حالة الكارت</h5>
                        <form id="editCardForm" method="POST" action="">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>الحالة</label>
                                <select name="status" id="m-edit-status" class="form-control">
                                    <option value="pending">قيد الانتظار</option>
                                    <option value="under_review">قيد المراجعة</option>
                                    <option value="approved">مقبول</option>
                                    <option value="active">نشط</option>
                                    <option value="blocked">محظور</option>
                                    <option value="rejected">مرفوض</option>
                                    <option value="cancelled">ملغي</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>ملاحظات الحالة (تظهر للعميل أو للإدارة)</label>
                                <textarea name="status_note" id="m-edit-note" class="form-control" rows="2" placeholder="اكتب سبب الرفض أو الحظر إن وجد..."></textarea>
                            </div>
                            <button type="submit" class="btn-submit">حفظ التعديلات</button>
                        </form>
                    </div>
                </div>

                <div>
                    <div class="info-section" style="height: 100%; display: flex; flex-direction: column;">
                        <h5 class="info-section-title"><i class="fa-solid fa-coins" style="color:var(--gold);"></i> نظام النقاط والمكافآت</h5>
                        
                        <div class="points-display">
                            <div style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">إجمالي النقاط المتاحة</div>
                            <div class="points-number">12,450</div>
                            <div style="font-size: 0.8rem; color: var(--status-active);">تعادل تقريباً 12,450 ج.م</div>
                        </div>

                        <h6 style="color: var(--warm-beige); margin: 1.5rem 0 1rem; font-size: 0.95rem;">سجل حركة النقاط (أحدث العمليات)</h6>
                        <div class="points-history">
                            <div class="history-item">
                                <div>
                                    <div style="color: var(--text-main);">مكافأة سداد قسط مبكر</div>
                                    <div style="color: var(--text-muted); font-size: 0.75rem;">2024-05-12 10:30 AM</div>
                                </div>
                                <div class="history-add">+ 5,000 نقطة</div>
                            </div>
                            <div class="history-item">
                                <div>
                                    <div style="color: var(--text-main);">استبدال في نادي البرلسي</div>
                                    <div style="color: var(--text-muted); font-size: 0.75rem;">2024-04-20 08:15 PM</div>
                                </div>
                                <div class="history-sub">- 1,200 نقطة</div>
                            </div>
                            <div class="history-item">
                                <div>
                                    <div style="color: var(--text-main);">هدية عيد ميلاد العميل</div>
                                    <div style="color: var(--text-muted); font-size: 0.75rem;">2024-03-01 00:00 AM</div>
                                </div>
                                <div class="history-add">+ 1,000 نقطة</div>
                            </div>
                            <div class="history-item">
                                <div>
                                    <div style="color: var(--text-main);">دفعة تعاقد مشروع الساحل</div>
                                    <div style="color: var(--text-muted); font-size: 0.75rem;">2024-01-15 11:20 AM</div>
                                </div>
                                <div class="history-add">+ 7,650 نقطة</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. نظام البحث اللحظي اللطيف (Smart Search) ---
        const searchInput = document.getElementById('smartSearchInput');
        const searchItems = document.querySelectorAll('.search-item');
        const noResultsMsg = document.getElementById('no-search-results');

        if(searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let hasVisibleItems = false;

                searchItems.forEach(item => {
                    const data = item.getAttribute('data-search');
                    if (data.includes(searchTerm)) {
                        item.style.display = 'flex';
                        hasVisibleItems = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if(noResultsMsg) {
                    noResultsMsg.style.display = hasVisibleItems || searchItems.length === 0 ? 'none' : 'block';
                }
            });
        }

        // --- 2. تفاعل الـ 3D للكارت عند حركة الماوس (اختياري لزيادة الجاذبية) ---
        const wrapper = document.getElementById('showcase-wrapper');
        const card3D = document.getElementById('showcase-card');
        
        if(wrapper && card3D) {
            wrapper.addEventListener('mousemove', (e) => {
                const rect = wrapper.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                // حساب زاوية الدوران خفيفة جداً حتى لا تزعج المستخدم
                const rotateX = ((y - centerY) / centerY) * -10;
                const rotateY = ((x - centerX) / centerX) * 10;
                
                card3D.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });

            wrapper.addEventListener('mouseleave', () => {
                card3D.style.transform = `rotateX(0deg) rotateY(0deg)`;
                card3D.style.transition = `transform 0.5s ease`;
                setTimeout(() => card3D.style.transition = `transform .1s ease-out`, 500);
            });
        }
    });

    // --- 3. وظائف المودال (Modal Functions) ---
    const modalOverlay = document.getElementById('cardModalOverlay');
    const editForm = document.getElementById('editCardForm');

    function openCardModal(cardData) {
        // تعبئة البيانات في المودال
        document.getElementById('m-card-number').innerText = cardData.number;
        document.getElementById('m-card-created').innerText = cardData.created_at;
        document.getElementById('m-card-activated').innerText = cardData.activated_at;
        document.getElementById('m-client-name').innerText = cardData.client_name;
        document.getElementById('m-client-phone').innerText = cardData.client_phone || 'غير مسجل';
        
        // تلوين الحالة
        const statusEl = document.getElementById('m-card-status');
        statusEl.innerText = cardData.status_ar;
        statusEl.className = 'info-value status-badge'; // Reset classes
        if(['active'].includes(cardData.status)) statusEl.classList.add('status-active');
        else if(['pending', 'under_review'].includes(cardData.status)) statusEl.classList.add('status-pending');
        else if(['rejected', 'blocked', 'cancelled'].includes(cardData.status)) statusEl.classList.add('status-rejected');
        else statusEl.classList.add('status-blocked');

        // تعبئة فورم التعديل
        document.getElementById('m-edit-status').value = cardData.status;
        document.getElementById('m-edit-note').value = cardData.note || '';
        
        // تحديث رابط الـ Form 
        // (قم بتعديل /admin/smart-cards حسب الـ Route الفعلي الخاص بالتحديث في مشروعك)
        editForm.action = `/admin/smart-cards/${cardData.id}`;

        // إظهار المودال ومنع سكرول الصفحة خلفه
        modalOverlay.classList.add('active');
        document.body.style.overflow = 'hidden'; 
    }

    function closeCardModal() {
        modalOverlay.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // إغلاق المودال عند الضغط في المساحة الفارغة حوله
    modalOverlay.addEventListener('click', function(e) {
        if(e.target === this) closeCardModal();
    });
</script>
@endsection
@php
    // قاموس الترجمة المدمج لتحويل قيم قواعد البيانات الإنجليزية إلى عربية
    $ar = [
        'purpose' => [
            'residential' => 'سكني',
            'investment' => 'استثماري',
            'summer' => 'مصيفي',
            'clinic' => 'عيادة طبية',
            'office' => 'مقر إداري',
            'commercial_shop' => 'محل تجاري',
        ],
        'unit_type' => [
            'apartment' => 'شقة',
            'villa' => 'فيلا مستقلة',
            'townhouse' => 'تاون هاوس',
            'twinhouse' => 'توين هاوس',
            'duplex' => 'دوبلكس',
            'penthouse' => 'بنتهاوس',
            'studio' => 'استوديو',
            'chalet' => 'شاليه',
            'clinic' => 'عيادة',
            'office' => 'مكتب',
            'shop' => 'محل',
        ],
        'budget' => [
            'lt_2m' => 'أقل من 2 مليون جنيه',
            '2_4m' => 'من 2 إلى 4 مليون جنيه',
            '4_6m' => 'من 4 إلى 6 مليون جنيه',
            '6_10m' => 'من 6 إلى 10 مليون جنيه',
            '10_20m' => 'من 10 إلى 20 مليون جنيه',
            'gt_20m' => 'أكثر من 20 مليون جنيه',
        ],
        'payment_method' => [
            'cash' => 'كاش (نقداً)',
            'installments' => 'نظام تقسيط',
            'either' => 'كاش أو تقسيط (مرن)',
        ],
        'purchase_time' => [
            'immediately' => 'فوراً',
            '3_months' => 'خلال 3 أشهر',
            '6_months' => 'خلال 6 أشهر',
            '1_year' => 'خلال سنة',
            'more_than_year' => 'أكثر من سنة',
        ],
        'preferred_contact' => [
            'call' => 'مكالمة هاتفية',
            'whatsapp' => 'واتساب',
            'email' => 'البريد الإلكتروني',
        ],
        'contact_time' => [
            'morning' => 'الفترة الصباحية',
            'afternoon' => 'فترة الظهيرة',
            'evening' => 'الفترة المسائية',
            'anytime' => 'في أي وقت',
        ],
        'marital_status' => [
            'single' => 'أعزب / عزباء',
            'married' => 'متزوج / متزوجة',
            'divorced' => 'مطلق / مطلقة',
            'widowed' => 'أرمل / أرملة',
        ],
        'family_size' => [
            '1' => 'فرد واحد',
            '2-3' => 'من 2 إلى 3 أفراد',
            '4-5' => 'من 4 إلى 5 أفراد',
            '6+' => '6 أفراد فأكثر',
        ],
        'card_status' => [
            'pending' => 'قيد المراجعة',
            'under_review' => 'جاري المراجعة',
            'approved' => 'تمت الموافقة',
            'active' => 'نشط VIP',
            'rejected' => 'مرفوض',
            'blocked' => 'محظور',
            'expired' => 'منتهي الصلاحية',
            'cancelled' => 'ملغى',
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي الفاخر | البرلسي للتطوير العقاري</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* ===================================== */
        /* 1. إعدادات المتغيرات والثيمات المستوحاة */
        /* ===================================== */
        :root {
            --primary-red: #B40000;
            --black: #000000;
            --card-bg-dark: #0d0d0f;
            --light-gray: #76767A;
            --dark-gray: #696969;
            --warm-beige: #E4DCC7;
            --cream-beige: #E6E0D0;
            --off-white: #F0F0F0;
            --border-dark: rgba(228, 220, 199, 0.15);
            --transition-smooth: 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--black);
            color: var(--off-white);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* خلفية سينمائية ناعمة */
        .page-overlay {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at 80% 20%, rgba(180, 0, 0, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(228, 220, 199, 0.05) 0%, transparent 50%);
            z-index: 1;
            pointer-events: none;
        }

        .profile-wrapper {
            position: relative;
            z-index: 5;
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 5% 6rem 5%;
        }

        /* الهيدر العلوي للملف */
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-dark);
            padding-bottom: 2rem;
            margin-bottom: 3rem;
        }

        .brand-name {
            color: var(--warm-beige);
            font-size: 1.6rem;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
        }

        .back-home-btn {
            color: var(--light-gray);
            text-decoration: none;
            font-size: 0.9rem;
            border: 1px solid var(--border-dark);
            padding: 0.5rem 1.2rem;
            border-radius: 4px;
            transition: var(--transition-smooth);
        }

        .back-home-btn:hover {
            color: var(--primary-red);
            border-color: var(--primary-red);
            background: rgba(180, 0, 0, 0.05);
        }

        /* شبكة العرض الرئيسية */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }

        @media (min-width: 1024px) {
            .main-grid {
                grid-template-columns: 350px 1fr;
            }
        }

        /* ===================================== */
        /* الكارت الجانبي وتأثير البطاقة الذكية */
        /* ===================================== */
        .sidebar-card {
            background: var(--card-bg-dark);
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            padding: 2rem;
            height: fit-content;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        .client-avatar-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem auto;
        }

        .client-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-red);
            padding: 4px;
        }

        .client-name {
            font-size: 1.4rem;
            color: var(--cream-beige);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .client-location {
            font-size: 0.85rem;
            color: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-bottom: 2rem;
        }

        /* تصميم الكارت الذكي VIP */
        .smart-card-lux {
            background: linear-gradient(135deg, #16161a 0%, #000000 100%);
            border: 1px solid #d4af37;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: right;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.7);
            margin-top: 1.5rem;
        }

        .smart-card-lux::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(212, 175, 55, 0.1), transparent);
            transform: rotate(45deg);
            transition: 0.8s;
        }

        .smart-card-lux:hover::before {
            left: 100%;
        }

        .card-chip {
            width: 40px;
            height: 30px;
            background: linear-gradient(135deg, #e4dcc7 0%, #b3a98f 100%);
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .card-number {
            font-family: 'Courier New', Courier, monospace;
            font-size: 1.2rem;
            letter-spacing: 2px;
            color: #fff;
            margin-bottom: 1rem;
            text-align: center;
            direction: ltr;
        }

        .card-holder-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .card-label {
            font-size: 0.65rem;
            color: var(--light-gray);
            text-transform: uppercase;
        }

        .card-value {
            font-size: 0.85rem;
            color: var(--warm-beige);
        }

        .badge-status {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            font-size: 0.75rem;
            border-radius: 4px;
            font-weight: bold;
        }

        .status-active {
            background: rgba(0, 180, 0, 0.15);
            color: #00ff00;
            border: 1px solid rgba(0, 255, 0, 0.3);
        }

        .status-pending {
            background: rgba(180, 180, 0, 0.15);
            color: #ffff00;
            border: 1px solid rgba(255, 255, 0, 0.3);
        }

        .status-rejected {
            background: rgba(180, 0, 0, 0.15);
            color: #ff3333;
            border: 1px solid rgba(255, 0, 0, 0.3);
        }

        /* ===================================== */
        /* قسم محتوى التبويبات والبيانات الكبيرة   */
        /* ===================================== */
        .content-area {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* نظام التبويبات السلس (Tabs) */
        .tabs-menu {
            display: flex;
            gap: 0.5rem;
            border-bottom: 1px solid var(--border-dark);
            overflow-x: auto;
            scrollbar-width: none;
        }

        .tabs-menu::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            background: transparent;
            border: none;
            color: var(--light-gray);
            padding: 1rem 1.5rem;
            font-size: 1rem;
            cursor: pointer;
            white-space: nowrap;
            border-bottom: 2px solid transparent;
            transition: var(--transition-smooth);
            font-family: inherit;
        }

        .tab-btn.active {
            color: var(--primary-red);
            border-bottom-color: var(--primary-red);
            font-weight: 600;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease forwards;
        }

        .tab-content.active {
            display: block;
        }

        /* كروت عرض البيانات المصنفة */
        .data-grid-lux {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .data-grid-lux {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .info-box-lux {
            background: var(--card-bg-dark);
            border: 1px solid var(--border-dark);
            padding: 1.5rem;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            transition: var(--transition-smooth);
        }

        .info-box-lux:hover {
            border-color: rgba(255, 77, 77, 0.3);
            transform: translateY(-2px);
        }

        .info-label {
            font-size: 0.8rem;
            color: var(--light-gray);
        }

        .info-val {
            font-size: 1.1rem;
            color: var(--off-white);
            font-weight: 600;
        }

        /* ===================================== */
        /* الجدول الزمني والتايم لاين (History) */
        /* ===================================== */
        .timeline-wrapper {
            position: relative;
            padding-right: 1.5rem;
            border-right: 2px solid var(--border-dark);
            margin-top: 1rem;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            right: calc(-1.5rem - 6px);
            top: 6px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--primary-red);
            border: 2px solid var(--black);
            box-shadow: 0 0 0 4px rgba(180, 0, 0, 0.2);
        }

        .timeline-header-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .timeline-title {
            font-size: 1.1rem;
            color: var(--cream-beige);
            font-weight: 600;
        }

        .timeline-date {
            font-size: 0.8rem;
            color: var(--light-gray);
            direction: ltr;
        }

        .timeline-body {
            background: var(--card-bg-dark);
            border: 1px solid var(--border-dark);
            padding: 1.2rem;
            border-radius: 8px;
            color: var(--light-gray);
            font-size: 0.9rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="page-overlay"></div>

    <div class="profile-wrapper">
        <header class="profile-header">
            <a href="/" class="brand-name">Albrolosy</a>
            <a href="/" class="back-home-btn">العودة للرئيسية &larr;</a>
        </header>

        <div class="main-grid">

            <aside class="sidebar-card">
                <div class="client-avatar-wrapper">
                    <img src="{{ $client->photo ? asset($client->photo) : 'https://www.w3schools.com/howto/img_avatar.png' }}"
                        alt="{{ $client->full_name }}" class="client-avatar">
                </div>
                <h2 class="client-name">{{ $client->full_name }}</h2>
                <div class="client-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span>{{ $client->governorate }}، {{ $client->city ?? 'مدينة غير محددة' }}</span>
                </div>

                <div class="smart-card-lux">
                    <div class="card-chip"></div>
                    <div class="card-number">
                        @if ($client->activeSmartCard)
                            {{ implode(' ', str_split($client->activeSmartCard->card_number, 4)) }}
                        @else
                            •••• •••• •••• ••••
                        @endif
                    </div>
                    <div class="card-holder-row">
                        <div>
                            <div class="card-label">حالة بطاقة الذكية</div>
                            <div class="card-value">
                                @php
                                    // استخراج حالة الكارت وتحديد الكلاس واللون المناسب
                                    $cardStatus = $client->activeSmartCard
                                        ? $client->activeSmartCard->status
                                        : 'pending';
                                    $statusClass =
                                        $cardStatus === 'active'
                                            ? 'status-active'
                                            : ($cardStatus === 'rejected'
                                                ? 'status-rejected'
                                                : 'status-pending');
                                    $statusText = $ar['card_status'][$cardStatus] ?? 'غير محدد';
                                @endphp

                                @if ($client->activeSmartCard)
                                    <span class="badge-status {{ $statusClass }}">{{ $statusText }}</span>
                                @else
                                    <span class="badge-status status-pending">لا توجد بطاقة نشطة</span>
                                @endif
                            </div>
                        </div>
                        <div style="text-align: left;">
                            <div class="card-label">عضوية منصة</div>
                            <div class="card-value" style="color:#d4af37;">Albrolosy</div>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="content-area">

                <nav class="tabs-menu">
                    <button class="tab-btn active" onclick="switchTab(event, 'interests')">الاهتمامات العقارية</button>
                    <button class="tab-btn" onclick="switchTab(event, 'financial')">البيانات المالية</button>
                    <button class="tab-btn" onclick="switchTab(event, 'personal')">البيانات الشخصية والتواصل</button>
                    <button class="tab-btn" onclick="switchTab(event, 'history')">سجل الحركات المتبادلة</button>
                </nav>

                <div id="interests" class="tab-content active">
                    <div class="data-grid-lux">
                        <div class="info-box-lux">
                            <span class="info-label">الغرض من الشراء</span>
                            <span class="info-val">
                                {{ $client->purpose ? $ar['purpose'][$client->purpose] ?? $client->purpose : 'غير محدد' }}
                            </span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">نوع الوحدة المطلوبة</span>
                            <span class="info-val">
                                {{ $client->unit_type ? $ar['unit_type'][$client->unit_type] ?? $client->unit_type : 'غير محدد' }}
                            </span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">المشروع أو المنطقة المفضلة</span>
                            <span class="info-val">{{ $client->project_or_city ?? 'كل المشاريع' }}</span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">المساحة المطلوبة التقريبية</span>
                            <span
                                class="info-val">{{ $client->required_area ? $client->required_area . ' متر مربع' : 'غير محددة' }}</span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">عدد غرف النوم المفضلة</span>
                            <span
                                class="info-val">{{ $client->bedrooms ? $client->bedrooms . ' غرف' : 'غير محدد' }}</span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">الخطة الزمنية المتوقعة للشراء</span>
                            <span class="info-val">
                                {{ $client->purchase_time ? $ar['purchase_time'][$client->purchase_time] ?? $client->purchase_time : 'قيد الدراسة' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div id="financial" class="tab-content">
                    <div class="data-grid-lux">
                        <div class="info-box-lux">
                            <span class="info-label">الميزانية التقريبية المرصودة</span>
                            <span class="info-val">
                                {{ $client->budget ? $ar['budget'][$client->budget] ?? $client->budget : 'غير محددة' }}
                            </span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">طريقة الدفع المفضلة</span>
                            <span class="info-val">
                                {{ $client->payment_method ? $ar['payment_method'][$client->payment_method] ?? $client->payment_method : 'مرنة' }}
                            </span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">المقدم المتاح المتوقع دفعه</span>
                            <span class="info-val" style="color: #00ff00;">
                                {{ $client->expected_down_payment ? number_format($client->expected_down_payment) . ' جنيه مصري' : 'قيد النقاش' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div id="personal" class="tab-content">
                    <div class="data-grid-lux">
                        <div class="info-box-lux">
                            <span class="info-label">رقم الهاتف الأساسي المسجل</span>
                            <span class="info-val" dir="ltr">{{ $client->phone }}</span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">البريد الإلكتروني المعتمد</span>
                            <span class="info-val">{{ $client->email ?? 'لا يوجد بريد مسجل' }}</span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">الحالة الاجتماعية</span>
                            <span class="info-val">
                                {{ $client->marital_status ? $ar['marital_status'][$client->marital_status] ?? $client->marital_status : 'غير محدد' }}
                            </span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">حجم العائلة</span>
                            <span class="info-val">
                                {{ $client->family_size ? $ar['family_size'][$client->family_size] ?? $client->family_size : 'غير محدد' }}
                            </span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">وسيلة التواصل المفضلة لدينا</span>
                            <span class="info-val">
                                {{ $client->preferred_contact ? $ar['preferred_contact'][$client->preferred_contact] ?? $client->preferred_contact : 'اتصال هاتفي' }}
                            </span>
                        </div>
                        <div class="info-box-lux">
                            <span class="info-label">أفضل وقت للتواصل معك</span>
                            <span class="info-val">
                                {{ $client->contact_time ? $ar['contact_time'][$client->contact_time] ?? $client->contact_time : 'أي وقت' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div id="history" class="tab-content">
                    <div class="timeline-wrapper">
                        @forelse($client->histories as $history)
                            <div class="timeline-item">
                                <div class="timeline-header-item">
                                    <h4 class="timeline-title">{{ $history->title }}</h4>
                                    <span
                                        class="timeline-date">{{ $history->created_at->format('Y-m-d h:i A') }}</span>
                                </div>
                                <div class="timeline-body">
                                    {{ $history->description ?? 'تم تسجيل إجراء جديد ناجح في ملفك الشخصي.' }}
                                </div>
                            </div>
                        @empty
                            <p style="color: var(--light-gray); text-align: center; padding: 2rem;">لا توجد حركات مسجلة
                                حالياً مرئية لك.</p>
                        @endforelse
                    </div>
                </div>

            </main>

        </div>
    </div>

    <script>
        function switchTab(event, tabId) {
            // إزالة الكلاس الفعال من كل الأزرار
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            // إخفاء كافة التبويبات
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            // تفعيل الزر والتبويب المطلوبين
            event.currentTarget.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        }
    </script>
</body>

</html>

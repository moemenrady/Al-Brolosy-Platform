<!DOCTYPE html>
<html lang="ar" data-theme="dark" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البرلسي - الملف النخبوي</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ===================================== */
        /* 1. إعدادات المتغيرات والثيمات         */
        /* ===================================== */
        :root {
            --primary-red: #B40000;
            --black: #000000;
            --warm-beige: #E4DCC7;
            --cream-beige: #E6E0D0;
            --off-white: #F0F0F0;
            --gold: #D4AF37;
        }

        html[data-theme="dark"] {
            --bg-main: #000000;
            --bg-secondary: #0D0D0D;
            --text-main: #F0F0F0;
            --text-muted: #8E8E93;
            --glass: rgba(25, 25, 25, 0.8);
            --glass-border: rgba(228, 220, 199, 0.1);
        }

        html[data-theme="light"] {
            --bg-main: #F8F8F8;
            --bg-secondary: #FFFFFF;
            --text-main: #1A1A1A;
            --text-muted: #666666;
            --glass: rgba(255, 255, 255, 0.9);
            --glass-border: rgba(180, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            overflow-x: hidden;
            font-family: 'Cairo', sans-serif;
        }

        /* ===================================== */
        /* 2. شاشة التحميل (Premium Loader)      */
        /* ===================================== */
        .loader-overlay {
            position: fixed;
            inset: 0;
            background-color: var(--black);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 1s ease, visibility 1s;
        }

        .brand-logo-box {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .spin-90 {
            transform: rotate(90deg);
            transition: transform 1s linear;
        }

        .spin-360 {
            transform: rotate(360deg);
            transition: transform 1s cubic-bezier(0.65, 0, 0.15, 1);
        }

        /* ===================================== */
        /* 3. الهيكل والـ Layout                  */
        /* ===================================== */
        .profile-page {
            position: relative;
            min-height: 100vh;
            padding: 2rem 5%;
            padding-top: 120px;
        }

        /* خلفية الفيديو المخففة */
        .bg-overlay-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            opacity: 0.15;
            filter: grayscale(1);
        }

        .header-nav {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 2rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }

        .brand-name {
            color: var(--warm-beige);
            font-size: 1.5rem;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            letter-spacing: 3px;
        }

        /* ===================================== */
        /* 4. مكونات الصفحة (Components)          */
        /* ===================================== */

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }

        @media (min-width: 1024px) {
            .profile-grid {
                grid-template-columns: 400px 1fr;
            }
        }

        /* منطقة المحتوى الرئيسي */
        .main-profile-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* لوحة الأدمن (Admin Status) */
        .admin-banner {
            background: rgba(180, 0, 0, 0.1);
            border: 1px solid var(--primary-red);
            border-radius: 15px;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-btn {
            background: var(--primary-red);
            color: #fff;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .admin-btn:hover {
            background: #900000;
            transform: translateY(-3px);
        }

        /* ===================================== */
        /* 5. بانر الملف العقاري (الجديد)         */
        /* ===================================== */
        .client-profile-banner {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .profile-avatar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid var(--gold);
            object-fit: cover;
            padding: 2px;
        }

        .profile-content .profile-badge {
            color: #28a745;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .profile-content h3 {
            color: var(--warm-beige);
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }

        .profile-content p {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.6;
            max-width: 500px;
        }

        .btn-profile {
            background: linear-gradient(135deg, var(--gold), #f1d592);
            color: #000;
            padding: 1rem 1.8rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            transition: 0.3s;
            white-space: nowrap;
        }

        .btn-profile:hover {
            transform: translateY(-4px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
        }

        /* أقسام البيانات (Glass Sections) */
        .info-section {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 2.5rem;
        }

        .section-title {
            font-family: 'Cairo', sans-serif;
            font-size: 1.6rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 700;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--glass-border);
        }

        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .data-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .data-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .data-value {
            font-size: 1.05rem;
            font-weight: 600;
        }

        /* الأزرار التفاعلية */
        .action-bar {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn-edit {
            background: var(--warm-beige);
            color: var(--black);
            padding: 1rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-edit:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(228, 220, 199, 0.2);
        }

        .btn-logout {
            border: 1px solid var(--primary-red);
            color: var(--primary-red);
            padding: 1rem 2rem;
            border-radius: 10px;
            background: transparent;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: 0.3s;
            font-family: 'Cairo', sans-serif;
        }

        .btn-logout:hover {
            background: var(--primary-red);
            color: #fff;
        }

        /* قسم البطاقة الذكية */
        .apply-card-section {
            overflow: hidden;
        }

        .apply-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .apply-card-desc {
            color: var(--text-muted);
            line-height: 1.8;
            max-width: 700px;
        }

        .apply-card-btn {
            background: linear-gradient(135deg, var(--gold), #f1d592);
            color: #000;
            border: none;
            padding: 1rem 1.8rem;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            transition: .3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Cairo', sans-serif;
        }

        .apply-card-btn:hover {
            transform: translateY(-4px);
        }

        .card-form-wrapper {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: all .5s ease;
        }

        .card-form-wrapper.active {
            max-height: 1000px;
            opacity: 1;
            margin-top: 2rem;
        }

        .smart-card-preview {
            background: linear-gradient(135deg, rgba(212, 175, 55, .15), rgba(180, 0, 0, .08));
            border: 1px solid rgba(212, 175, 55, .25);
            border-radius: 18px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .smart-card-title {
            color: var(--gold);
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .smart-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: .7rem;
        }

        .form-group label {
            font-weight: 600;
        }

        .form-group input {
            background: rgba(255, 255, 255, .03);
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            border-radius: 12px;
            padding: 1rem;
            outline: none;
            font-family: 'Cairo', sans-serif;
        }

        .form-group input:focus {
            border-color: var(--gold);
        }

        .phone-box {
            display: flex;
            gap: 1rem;
        }

        .phone-box input {
            flex: 1;
        }

        .hotline-link {
            min-width: 120px;
            text-decoration: none;
            background: rgba(212, 175, 55, .12);
            border: 1px solid rgba(212, 175, 55, .3);
            color: var(--gold);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            font-weight: 700;
            dir: ltr;
            /* الحفاظ على شكل الرقم */
        }

        .phone-note {
            color: var(--text-muted);
        }

        .submit-smart-btn {
            border: none;
            cursor: pointer;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            background: var(--primary-red);
            color: white;
            transition: .3s;
            font-family: 'Cairo', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .submit-smart-btn:hover {
            transform: translateY(-3px);
            background: #930000;
        }

        /* ريسبونسيف الموبايل */
        @media (max-width: 768px) {
            .profile-page {
                padding-top: 100px;
            }

            .section-title {
                font-size: 1.4rem;
            }

            .data-grid {
                grid-template-columns: 1fr 1fr;
            }

            .action-bar {
                flex-direction: column;
            }

            .apply-card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .phone-box {
                flex-direction: column;
            }

            .hotline-link {
                width: 100%;
                min-height: 55px;
            }

            .client-profile-banner {
                flex-direction: column;
                text-align: center;
            }

            .profile-info {
                flex-direction: column;
            }

            .btn-profile {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <div id="premium-loader" class="loader-overlay">
        <div class="loader-content">
            <div id="loader-logo" class="brand-logo-box">
                <img src="{{ asset('albrolosy_logo.png') }}" alt="شعار البرلسي" style="max-width: 100%;">
            </div>
        </div>
    </div>

    <nav class="header-nav">
        <a href="/" class="brand-name">البرلسي</a>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <button id="theme-switcher"
                style="background:none; border:none; color:inherit; cursor:pointer; font-size: 1.2rem;">
                <i class="fa-solid fa-circle-half-stroke"></i>
            </button>
        </div>
    </nav>

    <video autoplay muted loop class="bg-overlay-video">
        <source src="{{ asset('home/base_video_desktop.mp4') }}" type="video/mp4">
    </video>

    <main class="profile-page">
        <div class="profile-grid">

            @if (!$activeCard)
                <section class="info-section apply-card-section">
                    <div class="apply-card-header">
                        <div>
                            <h2 class="section-title" style="margin-bottom:1rem;">
                                <i class="fa-solid fa-credit-card" style="color:var(--gold);"></i>
                                <span>بطاقة البرلسي الذكية</span>
                            </h2>

                            <p class="apply-card-desc">
                                افتح مزايا حصرية، وأولوية الوصول للمشاريع العقارية،
                                وعروضاً استثنائية وتجربة مخصصة لتلبي تطلعاتك.
                            </p>
                        </div>

                        <button type="button" id="showCardForm" class="apply-card-btn">
                            <i class="fa-solid fa-crown"></i>
                            قدم طلبك الآن
                        </button>
                    </div>

                    <div id="cardApplicationForm" class="card-form-wrapper">
                        <div class="smart-card-preview">
                            <div class="smart-card-title">
                                <i class="fa-solid fa-gem"></i>
                                بطاقة العضوية النخبوية
                            </div>

                            <p>
                                انضم إلى برنامج العضوية النخبوية الخاص بنا واحصل على دعم متميز، فرص استثمارية حصرية،
                                وصلاحيات استثنائية.
                            </p>
                        </div>

                        <form action="{{ route('smart-card.apply') }}" method="POST" class="smart-form">
                            @csrf

                            <div class="form-group">
                                <label>الاسم بالكامل</label>
                                <input type="text" name="full_name" value="{{ $client->full_name ?? $user->name }}"
                                    placeholder="أدخل اسمك بالكامل">
                            </div>

                            <div class="form-group">
                                <label>رقم الهاتف</label>

                                <div class="phone-box">
                                    <input type="tel" name="phone" value="{{ $client->phone ?? '' }}"
                                        placeholder="01XXXXXXXXX" dir="ltr" style="text-align: right;">

                                    <a href="tel:15035" class="hotline-link" dir="ltr">
                                        <i class="fa-solid fa-phone"></i>
                                        15035
                                    </a>
                                </div>

                                <small class="phone-note">
                                    تحتاج للمساعدة؟ تواصل مع خط الدعم المميز الخاص بنا.
                                </small>
                            </div>

                            <button type="submit" class="submit-smart-btn">
                                <i class="fa-solid fa-paper-plane"></i>
                                إرسال الطلب
                            </button>
                        </form>
                    </div>
                </section>
            @endif

            <div class="main-profile-content">

                @if ($isAdmin)
                    <div class="admin-banner">
                        <div>
                            <h4 style="color:var(--primary-red);">صلاحية الإدارة النخبوية</h4>
                            <p style="font-size:0.8rem; color:var(--text-muted); margin-top:0.3rem;">لديك تحكم كامل في
                                إدارة التطورات والمشاريع المعمارية.</p>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" class="admin-btn">
                            <i class="fa-solid fa-gauge-high"></i> لوحة التحكم
                        </a>
                    </div>
                @endif

                <!-- ===================================== -->
                <!-- إضافة الجزء المطلوب للملف العقاري هنا -->
                <!-- ===================================== -->
                @if (isset($client) && $client)
                    <div class="client-profile-banner">
                        <div class="profile-info">
                            <div class="profile-avatar">
                                <img src="{{ $client->photo ? asset($client->photo) : asset('images/default-avatar.png') }}"
                                    alt="{{ $client->full_name }}">
                            </div>

                            <div class="profile-content">
                                <span class="profile-badge">
                                    <i class="fas fa-check-circle"></i>
                                    <span>تم إنشاء ملفك الشخصي</span>
                                </span>

                                <h3>
                                    مرحباً، {{ $client->full_name }}
                                </h3>

                                <p>
                                    يمكنك الآن متابعة حالة طلباتك، بطاقة العميل الذكية، سجل التعاملات، وتحديث بياناتك من
                                    خلال ملفك الشخصي بكل سهولة.
                                </p>
                            </div>
                        </div>

                        <div class="profile-actions">
                            <a href="{{ route('client.profile') }}" class="btn-profile">
                                <i class="fas fa-user-circle"></i>
                                <span>الذهاب إلى الملف الشخصي</span>
                            </a>
                        </div>
                    </div>
                @endif
                <!-- نهاية الجزء المطلوب -->

                <section class="info-section">
                    <h2 class="section-title">
                        <i class="fa-solid fa-user-tie" style="color:var(--primary-red);"></i>
                        <span>المحفظة الشخصية</span>
                    </h2>

                    <div class="data-grid">
                        <div class="data-item">
                            <span class="data-label">الاسم بالكامل</span>
                            <span class="data-value">{{ $client->full_name ?? $user->name }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">رقم التواصل</span>
                            <span class="data-value" dir="ltr"
                                style="text-align: right;">{{ $client->phone ?? 'غير مرتبط' }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">البريد الإلكتروني</span>
                            <span class="data-value">{{ $user->email }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">الحالة الاجتماعية</span>
                            <span class="data-value">{{ $client->marital_status ?? '—' }}</span>
                        </div>
                    </div>
                </section>

                @if ($client)
                    <section class="info-section">
                        <h2 class="section-title">
                            <i class="fa-solid fa-city" style="color:var(--primary-red);"></i>
                            <span>الاهتمامات الاستثمارية</span>
                        </h2>

                        <div class="data-grid">
                            <div class="data-item">
                                <span class="data-label">المشروع المستهدف</span>
                                <span class="data-value">{{ $client->project_or_city }}</span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">نوع الوحدة المفضلة</span>
                                <span class="data-value">{{ $client->unit_type }}</span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">الميزانية المرصودة</span>
                                <span
                                    class="data-value">{{ number_format((float) str_replace(',', '', $client->budget)) }}
                                    جنيه</span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">وقت الشراء المتوقع</span>
                                <span class="data-value">{{ $client->purchase_time }}</span>
                            </div>
                        </div>
                    </section>
                @endif

                <div class="action-bar">
                    <a href="{{ route('profile.edit') }}" class="btn-edit">
                        <i class="fa-solid fa-pen-nib"></i> تحديث البيانات
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fa-solid fa-power-off"></i> تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // 1. التحميل (Premium Loader)
            const loader = document.getElementById("premium-loader");
            const logo = document.getElementById("loader-logo");

            setTimeout(() => {
                logo.classList.add("spin-90");
            }, 100);

            window.addEventListener("load", () => {
                setTimeout(() => {
                    logo.classList.remove("spin-90");
                    logo.classList.add("spin-360");
                    setTimeout(() => {
                        loader.style.opacity = "0";
                        setTimeout(() => {
                            loader.style.visibility = "hidden";
                        }, 1000);
                    }, 1000);
                }, 500);
            });

            // Theme Switcher
            const themeBtn = document.getElementById('theme-switcher');
            themeBtn?.addEventListener('click', () => {
                if (window.preferences && typeof window.preferences.toggleTheme === 'function') {
                    window.preferences.toggleTheme();
                } else {
                    // Fallback toggle
                    const html = document.documentElement;
                    const currentTheme = html.getAttribute('data-theme');
                    html.setAttribute('data-theme', currentTheme === 'dark' ? 'light' : 'dark');
                }
            });
        });
    </script>
    <script>
        // إظهار وإخفاء فورم التقديم على البطاقة
        const showCardFormBtn = document.getElementById('showCardForm');

        if (showCardFormBtn) {
            showCardFormBtn.addEventListener('click', () => {
                document
                    .getElementById('cardApplicationForm')
                    .classList.toggle('active');
            });
        }
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en" data-theme="dark" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-en="Albrolosy - Luxury Portal" data-ar="البرلسي - البوابة الفاخرة">Albrolosy - Luxury Portal</title>

    <!-- الخطوط الفاخرة -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- مكتبة الأيقونات FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===================================== */
        /* 1. إعدادات المتغيرات والثيمات الفاخرة  */
        /* ===================================== */
        :root {
            --primary-red: #B40000;
            --black: #000000;
            --light-gray: #76767A;
            --dark-gray: #696969;
            --warm-beige: #E4DCC7;
            --cream-beige: #E6E0D0;
            --off-white: #F0F0F0;

            --gold-gradient: linear-gradient(135deg, #E4DCC7 0%, #B3A580 100%);
            --red-gradient: linear-gradient(135deg, #B40000 0%, #7A0000 100%);
            --glass-bg: rgba(26, 26, 26, 0.65);
            --glass-border: rgba(228, 220, 199, 0.15);
        }

        /* الوضع الداكن (الافتراضي للشركة ليعطي الطابع الفخم) */
        html[data-theme="dark"] {
            --bg-main: #000000;
            --bg-secondary: #0D0D0D;
            --bg-card: rgba(18, 18, 18, 0.8);
            --text-main: #F0F0F0;
            --text-muted: #8E8E93;
            --border-color: #2C2C2E;
            --input-bg: rgba(20, 20, 20, 0.8);
            --glass-bg: rgba(13, 13, 13, 0.7);
            --glass-border: rgba(228, 220, 199, 0.12);
        }

        /* الوضع الفاتح */
        html[data-theme="light"] {
            --bg-main: #F4F4F6;
            --bg-secondary: #FFFFFF;
            --bg-card: rgba(255, 255, 255, 0.9);
            --text-main: #1C1C1E;
            --text-muted: #636366;
            --border-color: #E5E5EA;
            --input-bg: #FAFAFC;
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(180, 0, 0, 0.1);
        }

        /* تنسيقات عامة لتوافق اللغات والخطوط */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            transition: background-color 0.4s ease, border-color 0.4s ease;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
            background-color: var(--bg-main);
            color: var(--text-main);
        }

        html[dir="rtl"] {
            font-family: 'Cairo', sans-serif;
        }

        html[dir="ltr"] {
            font-family: 'Montserrat', sans-serif;
        }

        /* عناوين برستيجية خاصة بالتطوير العقاري الفاخر */
        h1,
        h2,
        h3,
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* ===================================== */
        /* 2. شاشة التحميل (Preloader)            */
        /* ===================================== */
        .loader-overlay {
            position: fixed;
            inset: 0;
            background-color: var(--black);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s cubic-bezier(0.77, 0, 0.175, 1), visibility 0.8s;
        }

        .loader-content {
            text-align: center;
        }

        .brand-logo-box {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(0deg);
        }

        .logo-img {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 0 10px rgba(228, 220, 199, 0.3));
        }

        .spin-90 {
            transform: rotate(90deg);
            transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .spin-360 {
            transform: rotate(360deg);
            transition: transform 1.2s cubic-bezier(0.65, 0, 0.15, 1);
        }

        /* ===================================== */
        /* 3. الهيكل الرئيسي وتصميم الشقين (Split) */
        /* ===================================== */
        .auth-container {
            display: grid;
            grid-template-columns: 1fr;
            min-height: 100vh;
            width: 100%;
            position: relative;
        }

        @media (min-width: 1024px) {
            .auth-container {
                grid-template-columns: 1.1fr 0.9fr;
                /* الشق الأيسر للوسائط والشق الأيمن للفورم */
            }
        }

        /* الجانب البصري الفاخر (Visual Side) */
        .visual-side {
            position: relative;
            display: none;
            overflow: hidden;
            background-color: var(--black);
        }

        @media (min-width: 1024px) {
            .visual-side {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 3rem;
                height: 100vh;
            }
        }

        .visual-bg-image {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.85)),
                url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            transform: scale(1.05);
            animation: majesticZoom 20s infinite alternate ease-in-out;
            z-index: 1;
        }

        @keyframes majesticZoom {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.08);
            }
        }

        .visual-overlay {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, transparent 20%, rgba(0, 0, 0, 0.7) 100%);
            z-index: 2;
        }

        .visual-header {
            position: relative;
            z-index: 3;
        }

        .visual-content-inner {
            position: relative;
            z-index: 3;
            max-width: 550px;
        }

        .visual-tagline {
            color: var(--warm-beige);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 1rem;
            display: block;
        }

        .visual-title {
            color: #FFFFFF;
            font-size: 3rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
        }

        .visual-desc {
            color: var(--cream-beige);
            font-size: 1rem;
            line-height: 1.6;
            opacity: 0.9;
        }

        .visual-footer {
            position: relative;
            z-index: 3;
            color: var(--light-gray);
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        /* جانب النوافذ والـ Forms */
        .form-side {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            background-color: var(--bg-main);
            overflow-y: auto;
            position: relative;
            height: 100vh;
        }

        @media (min-width: 640px) {
            .form-side {
                padding: 3rem;
            }
        }

        /* الهيدر العلوي الموحد لصفحة الفورم */
        .form-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            z-index: 10;
        }

        .brand-name {
            color: var(--warm-beige);
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .lang-switch-btn {
            background: none;
            border: none;
            color: var(--text-main);
            cursor: pointer;
            display: flex;
            gap: 0.3rem;
            font-size: 0.9rem;
            transition: color 0.3s;
            padding: 0.5rem;
            font-weight: 500;
        }

        .lang-switch-btn:hover {
            color: var(--primary-red);
        }

        .lang-switch-btn .active {
            color: var(--primary-red);
            font-weight: bold;
        }

        .theme-switcher-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            color: var(--text-main);
        }

        .theme-switcher-btn:hover {
            color: var(--primary-red);
        }

        .icon-svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
            stroke: currentColor;
            transition: transform 0.5s ease;
        }

        .theme-switcher-btn:hover .icon-svg {
            transform: rotate(30deg);
        }

        /* حاوية الكارد الفاخرة */
        .form-card-wrapper {
            width: 100%;
            max-width: 450px;
            margin: auto 0;
            z-index: 5;
            perspective: 1000px;
        }

        .form-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.6s ease;
        }

        .form-card:hover {
            border-color: rgba(180, 0, 0, 0.25);
            box-shadow: 0 20px 45px rgba(180, 0, 0, 0.08);
        }

        /* التحكم بالتبديل التفاعلي بين الدخول والتسجيل */
        .tabs-header {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 2rem;
            position: relative;
        }

        .tab-btn {
            flex: 1;
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.1rem;
            font-weight: 600;
            padding: 1rem 0;
            cursor: pointer;
            position: relative;
            transition: color 0.3s ease;
        }

        .tab-btn.active {
            color: var(--text-main);
        }

        .tab-indicator {
            position: absolute;
            bottom: -1px;
            height: 2px;
            width: 50%;
            background: var(--primary-red);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html[dir="ltr"] .tab-indicator {
            left: 0;
        }

        html[dir="rtl"] .tab-indicator {
            right: 0;
        }

        /* شاشات الفورمات المتجاورة */
        .forms-slider {
            display: flex;
            overflow: hidden;
            width: 100%;
        }

        .form-block {
            width: 100%;
            flex-shrink: 0;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.5s;
        }

        /* التبديل عبر تحريك الـ Slider */
        .forms-slider.show-register .form-block {
            transform: translateX(-100%);
        }

        html[dir="rtl"] .forms-slider.show-register .form-block {
            transform: translateX(100%);
        }

        /* تنسيقات حقول المدخلات الإبداعية */
        .form-group {
            position: relative;
            margin-bottom: 1.6rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 1.2rem;
            color: var(--text-muted);
            transition: color 0.3s;
            font-size: 1.1rem;
        }

        html[dir="rtl"] .input-wrapper i {
            left: auto;
            right: 1.2rem;
        }

        .form-input {
            width: 100%;
            padding: 1.1rem 1.2rem 1.1rem 3rem;
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-main);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            outline: none;
        }

        html[dir="rtl"] .form-input {
            padding: 1.1rem 3rem 1.1rem 1.2rem;
        }

        .form-input:focus {
            border-color: var(--primary-red);
            background-color: var(--bg-secondary);
            box-shadow: 0 0 0 4px rgba(180, 0, 0, 0.1);
        }

        /* التفاعل عند التركيز مع أيقونات الحقول */
        .form-input:focus+i {
            color: var(--primary-red);
        }

        /* تسمية الحقول العلوية الخفيفة */
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }

        /* خيارات إضافية (تذكرني / نسيت كلمة السر) */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            margin-bottom: 2rem;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
            color: var(--text-muted);
        }

        .checkbox-container input {
            display: none;
        }

        .custom-checkmark {
            width: 18px;
            height: 18px;
            border: 2px solid var(--border-color);
            border-radius: 5px;
            margin-right: 0.5rem;
            display: inline-block;
            position: relative;
            transition: all 0.3s;
        }

        html[dir="rtl"] .custom-checkmark {
            margin-right: 0;
            margin-left: 0.5rem;
        }

        .checkbox-container input:checked+.custom-checkmark {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
        }

        .checkbox-container input:checked+.custom-checkmark::after {
            content: "\f00c";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            color: #FFFFFF;
            font-size: 0.7rem;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .forgot-link {
            color: var(--primary-red);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: var(--warm-beige);
            text-decoration: underline;
        }

        /* أزرار التشغيل الفخمة */
        .btn-submit {
            width: 100%;
            padding: 1.1rem;
            background: var(--red-gradient);
            border: none;
            border-radius: 12px;
            color: #FFFFFF;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(180, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.8rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(180, 0, 0, 0.45);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* الفاصل الأنيق */
        .divider-container {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .divider-container::before,
        .divider-container::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }

        .divider-container:not(:empty)::before {
            margin-right: 1rem;
        }

        .divider-container:not(:empty)::after {
            margin-left: 1rem;
        }

        /* زر الدخول بحساب Google الفاخر */
        .btn-google {
            width: 100%;
            padding: 1.1rem;
            background-color: transparent;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-main);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            transition: all 0.3s ease;
        }

        .btn-google:hover {
            background-color: var(--bg-secondary);
            border-color: var(--text-main);
        }

        .google-icon {
            width: 20px;
            height: 20px;
        }

        /* الفوتر المتوافق مع شروط حماية البيانات */
        .form-footer-privacy {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.75rem;
            margin-top: 2.5rem;
            line-height: 1.5;
            width: 100%;
        }

        /* ===================================== */
        /* 4. معالجة حالات الأخطاء والرسائل للباك  */
        /* ===================================== */
        .validation-error {
            background-color: rgba(180, 0, 0, 0.1);
            border-left: 3px solid var(--primary-red);
            color: var(--text-main);
            padding: 0.8rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            display: none;
            /* يتم تفعيلها برمجياً أو باستخدام شروط Blade */
        }

        html[dir="rtl"] .validation-error {
            border-left: none;
            border-right: 3px solid var(--primary-red);
        }
    </style>
</head>

<body>

    <!-- ===================================== -->
    <!-- شاشة التحميل المتناسقة (Preloader)    -->
    <!-- ===================================== -->
    <div id="premium-loader" class="loader-overlay">
        <div class="loader-content">
            <div id="loader-logo" class="brand-logo-box">
                <!-- لوجو البرلسي الفخم -->
                <img src="{{ asset('albrolosy_logo.png') }}" alt="Albrolosy Logo" class="logo-img">
            </div>
        </div>
    </div>

    <!-- الحاوية الأساسية للجريد -->
    <main class="auth-container">

        <!-- ===================================== -->
        <!-- الشق الأيسر: الجمالي/السينمائي (Desktop)-->
        <!-- ===================================== -->
        <section class="visual-side">
            <div class="visual-bg-image"></div>
            <div class="visual-overlay"></div>

            <div class="visual-header">
                <!-- فارغ للحفاظ على التوازن أو لوضع أيقونة صغيرة -->
            </div>

            <div class="visual-content-inner">
                <span class="visual-tagline" data-en="A Legacy of Elegance" data-ar="إرث من الفخامة والتميز">A Legacy of
                    Elegance</span>
                <h2 class="visual-title" data-en="Discover Sovereign Spaces" data-ar="اكتشف مساحات تليق بسيادتك">
                    Discover Sovereign Spaces</h2>
                <p class="visual-desc"
                    data-en="Step inside our exclusive sanctuary of premium architecture. Managing your elite properties is now tailored with utmost digital perfection."
                    data-ar="ادخل إلى عالمنا الحصري من الهندسة المعمارية الفاخرة. تسيير ومتابعة عقاراتك النخبوية أصبح الآن مجهزاً بأرقى التفاصيل الرقمية.">
                    Step inside our exclusive sanctuary of premium architecture. Managing your elite properties is now
                    tailored with utmost digital perfection.</p>
            </div>

            <div class="visual-footer">
                <p>© {{ date('Y') }} Albrolosy Developments. All Rights Reserved.</p>
            </div>
        </section>

        <!-- ===================================== -->
        <!-- الشق الأيمن: النوافذ التفاعلية (Forms)-->
        <!-- ===================================== -->
        <section class="form-side">

            <!-- الهيدر والتحكم -->
            <header class="form-header">
                <a href="/" class="brand-name">Albrolosy</a>

                <div class="header-controls">
                    <!-- زر تغيير اللغة التفاعلي -->
                    <button id="lang-switcher" class="lang-switch-btn">
                        <span class="lang-en active">En</span>
                        <span class="lang-separator">/</span>
                        <span class="lang-ar active">Ar</span>
                    </button>

                    <!-- زر تغيير الثيم -->
                    <button id="theme-switcher" class="theme-switcher-btn" title="Toggle Theme">
                        <svg class="icon-svg" id="theme-icon" viewBox="0 0 24 24">
                            <path
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                fill="none" />
                        </svg>
                    </button>
                </div>
            </header>

            <!-- حاوية الكارد التفاعلية للتبديل -->
            <div class="form-card-wrapper">
                <div class="form-card">

                    <!-- التبويبات التفاعلية (Tabs) -->
                    <div class="tabs-header">
                        <button class="tab-btn active" id="tab-login" onclick="switchTab('login')" data-en="Login"
                            data-ar="تسجيل الدخول">Login</button>
                        <button class="tab-btn" id="tab-register" onclick="switchTab('register')" data-en="Register"
                            data-ar="حساب جديد">Register</button>
                        <div class="tab-indicator" id="indicator"></div>
                    </div>

                    <!-- مساحة السلايدر التفاعلي للمحتوى -->
                    <div class="forms-slider" id="forms-slider">

                        <!-- ===================================== -->
                        <!-- 1. نموذج تسجيل الدخول (Login Form)   -->
                        <!-- ===================================== -->
                        <div class="form-block">
                            <!-- مثال لتنبيه أخطاء Laravel في الباك إند: -->
                            <!--
                            @if ($errors->any())
<div class="validation-error" style="display: block;">
                                    <ul>
                                        @foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
                                    </ul>
                                </div>
@endif
                            -->

                            <form action="{{ route('login') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label class="form-label" for="login-email" data-en="Email Address"
                                        data-ar="البريد الإلكتروني">Email Address</label>
                                    <div class="input-wrapper">
                                        <input type="email" id="login-email" name="email" class="form-input"
                                            placeholder="name@domain.com" required value="{{ old('email') }}">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="login-pass" data-en="Password"
                                        data-ar="كلمة المرور">Password</label>
                                    <div class="input-wrapper">
                                        <input type="password" id="login-pass" name="password" class="form-input"
                                            placeholder="••••••••••••" required>
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                </div>

                                <div class="form-options">
                                    <label class="checkbox-container">
                                        <input type="checkbox" name="remember" id="remember_me">
                                        <span class="custom-checkmark"></span>
                                        <span data-en="Remember Me" data-ar="تذكرني على هذا الجهاز">Remember Me</span>
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="forgot-link"
                                            data-en="Forgot Password?" data-ar="نسيت كلمة السر؟">Forgot Password?</a>
                                    @endif
                                </div>

                                <button type="submit" class="btn-submit">
                                    <span data-en="Sign In Securely" data-ar="تسجيل دخول آمن">Sign In Securely</span>
                                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                </button>
                            </form>
                        </div>

                        <!-- ===================================== -->
                        <!-- 2. نموذج تسجيل حساب جديد (Register) -->
                        <!-- ===================================== -->
                        <div class="form-block">
                            <form action="{{ route('register') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label class="form-label" for="reg-name" data-en="Full Name"
                                        data-ar="الاسم الكامل">Full Name</label>
                                    <div class="input-wrapper">
                                        <input type="text" id="reg-name" name="name" class="form-input"
                                            placeholder="e.g. Abdullah Albrolosy" required
                                            value="{{ old('name') }}">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="reg-email" data-en="Email Address"
                                        data-ar="البريد الإلكتروني">Email Address</label>
                                    <div class="input-wrapper">
                                        <input type="email" id="reg-email" name="email" class="form-input"
                                            placeholder="name@domain.com" required value="{{ old('email') }}">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="reg-pass" data-en="Choose Password"
                                        data-ar="كلمة المرور">Choose Password</label>
                                    <div class="input-wrapper">
                                        <input type="password" id="reg-pass" name="password" class="form-input"
                                            placeholder="••••••••••••" required>
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 2rem;">
                                    <label class="form-label" for="reg-pass-confirm" data-en="Confirm Password"
                                        data-ar="تأكيد كلمة المرور">Confirm Password</label>
                                    <div class="input-wrapper">
                                        <input type="password" id="reg-pass-confirm" name="password_confirmation"
                                            class="form-input" placeholder="••••••••••••" required>
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>
                                </div>

                                <button type="submit" class="btn-submit">
                                    <span data-en="Create Elite Account" data-ar="إنشاء حساب نخبوي">Create Elite
                                        Account</span>
                                    <i class="fa-solid fa-user-plus"></i>
                                </button>
                            </form>
                        </div>

                    </div> <!-- نهاية السلايدر -->

                    <!-- الفاصل بين التسجيل التقليدي وتفعيل جوجل -->
                    <div class="divider-container">
                        <span data-en="Or Continue With" data-ar="أو المتابعة من خلال">Or Continue With</span>
                    </div>

                    <!-- زر جوجل الفاخر متصل بمسار الباك الممرر -->
                    <button type="button" onclick="window.location.href='{{ route('google.login') }}'"
                        class="btn-google">
                        <!-- أيقونة جوجل SVG الرسمية بدقة متناهية -->
                        <svg class="google-icon" viewBox="0 0 24 24">
                            <path fill="#EA4335"
                                d="M12 5.04c1.66 0 3.2.57 4.38 1.69l3.27-3.27C17.67 1.48 14.99 1 12 1 7.35 1 3.4 3.65 1.5 7.5l3.86 3C6.27 7.55 8.91 5.04 12 5.04z" />
                            <path fill="#4285F4"
                                d="M23.49 12.275c0-.805-.07-1.585-.2-2.34H12v4.445h6.46c-.28 1.48-1.12 2.735-2.38 3.585l3.7 2.87c2.16-2 3.41-4.945 3.41-8.56z" />
                            <path fill="#FBBC05"
                                d="M5.36 14.71c-.24-.715-.38-1.48-.38-2.27s.14-1.555.38-2.27l-3.86-3C.68 8.785 0 10.315 0 12s.68 3.215 1.5 4.56l3.86-3z" />
                            <path fill="#34A853"
                                d="M12 23c3.24 0 5.97-1.07 7.96-2.91l-3.7-2.87c-1.03.69-2.35 1.1-4.26 1.1-3.09 0-5.73-2.51-6.64-5.46l-3.86 3C3.4 20.35 7.35 23 12 23z" />
                        </svg>
                        <span data-en="Google Elite Identity" data-ar="بوابة الهوية عبر Google">Google Elite
                            Identity</span>
                    </button>

                </div>
            </div>

            <!-- الفوتر المصاحب للخصوصية -->
            <footer class="form-footer-privacy">
                <p data-en="By proceeding, you agree to Albrolosy Privacy Policy & Terms of Elite Membership."
                    data-ar="بمتابعتك، فإنك توافق على سياسة الخصوصية وشروط العضوية النخبوية لشركة البرلسي.">By
                    proceeding, you agree to Albrolosy Privacy Policy & Terms of Elite Membership.</p>
            </footer>

        </section>
    </main>

    <!-- ===================================== -->
    <!-- 5. منطق الواجهة البرمجي (Javascript)  -->
    <!-- ===================================== -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // 1. التحكم بشاشة التحميل (Loader Overlay)
            const loader = document.getElementById("premium-loader");
            const logo = document.getElementById("loader-logo");

            // بدء الدوران التجريبي
            setTimeout(() => {
                logo.classList.add("spin-90");
            }, 80);

            // تفعيل الدوران الكامل بعد التجهيز وإخفاء الشاشة
            window.addEventListener("load", () => {
                setTimeout(() => {
                    logo.classList.remove("spin-90");
                    logo.classList.add("spin-360");
                    setTimeout(() => {
                        loader.style.opacity = "0";
                        setTimeout(() => {
                            loader.style.visibility = "hidden";
                        }, 800);
                    }, 800);
                }, 400);
            });

            // Fallback احتياطي في حال تأخر تحميل الموارد بالخادم
            setTimeout(() => {
                if (loader.style.visibility !== "hidden") {
                    loader.style.opacity = "0";
                    setTimeout(() => {
                        loader.style.visibility = "hidden";
                    }, 800);
                }
            }, 3000);

            const langBtn = document.getElementById('lang-switcher');

            langBtn?.addEventListener('click', () => {
                window.preferences?.toggleLanguage();
                updateTabIndicator();
            });

            const themeBtn = document.getElementById('theme-switcher');
            themeBtn?.addEventListener('click', () => {
                window.preferences?.toggleTheme();
            });
        });

        // 4. التحكم بالتنقل بين الـ Tabs والـ Slider
        function switchTab(type) {
            const slider = document.getElementById('forms-slider');
            const tabLogin = document.getElementById('tab-login');
            const tabRegister = document.getElementById('tab-register');
            const indicator = document.getElementById('indicator');
            const isRtl = document.documentElement.getAttribute('dir') === 'rtl';

            if (type === 'login') {
                slider.classList.remove('show-register');
                tabLogin.classList.add('active');
                tabRegister.classList.remove('active');
            } else {
                slider.classList.add('show-register');
                tabRegister.classList.add('active');
                tabLogin.classList.remove('active');
            }
            updateTabIndicator();
        }

        // حساب حركة خط مؤشر التبويب بناءً على اتجاه اللغة الحالي
        function updateTabIndicator() {
            const indicator = document.getElementById('indicator');
            const tabLogin = document.getElementById('tab-login');
            const tabRegister = document.getElementById('tab-register');
            const isRtl = document.documentElement.getAttribute('dir') === 'rtl';

            if (tabRegister.classList.contains('active')) {
                if (isRtl) {
                    indicator.style.transform = 'translateX(-100%)';
                } else {
                    indicator.style.transform = 'translateX(100%)';
                }
            } else {
                indicator.style.transform = 'translateX(0)';
            }
        }
    </script>
</body>

</html>

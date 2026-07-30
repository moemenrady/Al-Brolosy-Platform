<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-en="Eng. Ghanim Al-Brolosy - CEO & Founder" data-ar="م. غانم البرلسي - المؤسس والرئيس التنفيذي">م. غانم
        البرلسي - المؤسس والرئيس التنفيذي</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap"
        rel="stylesheet">

    <style>
        /* ===================================== */
        /* 1. إعدادات المتغيرات والثيمات والألوان */
        /* ===================================== */
        :root {
            --primary-red: #B40000;
            --black: #000000;
            --light-gray: #76767A;
            --dark-gray: #696969;
            --warm-beige: #E4DCC7;
            --cream-beige: #E6E0D0;
            --off-white: #F0F0F0;
            --transition-lux: 0.5s cubic-bezier(0.25, 1, 0.5, 1);
        }

        html[data-theme="dark"] {
            --bg-main: #000000;
            --bg-secondary: #0d0d0f;
            --bg-tertiary: #131315;
            --text-main: #F0F0F0;
            --text-muted: #aaacb0;
            --border-color: rgba(228, 220, 199, 0.15);
            --card-glass: rgba(13, 13, 15, 0.85);
        }

        html[data-theme="light"] {
            --bg-main: #F4F4F6;
            --bg-secondary: #ffffff;
            --bg-tertiary: #eaeaea;
            --text-main: #111111;
            --text-muted: #555558;
            --border-color: rgba(0, 0, 0, 0.1);
            --card-glass: rgba(255, 255, 255, 0.9);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            transition: background-color var(--transition-lux), color var(--transition-lux);
            overflow-x: hidden;
        }

        html[dir="rtl"] {
            font-family: 'Cairo', sans-serif;
        }

        html[dir="ltr"] {
            font-family: 'Playfair Display', 'Helvetica Neue', Arial, sans-serif;
        }

        /* ===================================== */
        /* 2. الهيدر واللوجو الفاخر              */
        /* ===================================== */
        .hero-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.8), transparent);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
        }

        .brand-logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo-circle {
            width: 50px;
            height: 50px;
            border: 1px solid var(--warm-beige);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: var(--black);
        }

        .brand-logo-circle img {
            width: 80%;
            height: 80%;
            object-fit: contain;
        }

        .brand-title {
            color: var(--warm-beige);
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .action-btn {
            background: none;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 0.6rem 1.4rem;
            color: var(--warm-beige);
            cursor: pointer;
            font-size: 1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition-lux);
        }

        .action-btn:hover {
            border-color: var(--primary-red);
            background-color: rgba(180, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .icon-svg {
            width: 20px;
            height: 20px;
            stroke: var(--warm-beige);
            fill: none;
        }

        /* ===================================== */
        /* 3. سيكشن الـ Hero وبطل الصفحة         */
        /* ===================================== */
        .founder-hero {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 9rem 5% 5rem;
            overflow: hidden;
        }

        .bg-video-wrapper {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .bg-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.15;
            transition: opacity 1.5s ease;
        }

        .cinematic-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, var(--bg-main) 5%, rgba(0, 0, 0, 0.75) 50%, rgba(0, 0, 0, 0.95) 100%);
            z-index: 2;
        }

        .founder-container {
            position: relative;
            z-index: 10;
            max-width: 1300px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr;
            gap: 4rem;
            align-items: center;
        }

        @media (min-width: 1024px) {
            .founder-container {
                grid-template-columns: 1.1fr 0.9fr;
            }
        }

        .founder-info-block {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .tag-badge {
            align-self: flex-start;
            background: rgba(180, 0, 0, 0.15);
            border: 1px solid var(--primary-red);
            color: var(--warm-beige);
            padding: 0.5rem 1.4rem;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }

        .founder-name {
            font-size: 3rem;
            font-weight: 800;
            color: var(--cream-beige);
            line-height: 1.2;
            margin-bottom: 0.8rem;
        }

        @media (min-width: 768px) {
            .founder-name {
                font-size: 4rem;
            }
        }

        .founder-title {
            font-size: 1.4rem;
            color: var(--primary-red);
            font-weight: 700;
            margin-bottom: 1.8rem;
        }

        .contact-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2.5rem;
        }

        .social-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 0.8rem 1.5rem;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--off-white);
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            transition: var(--transition-lux);
        }

        .social-btn:hover {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(180, 0, 0, 0.3);
        }

        .social-btn svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        .interactive-tabs-container {
            background: var(--card-glass);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2.5rem;
            backdrop-filter: blur(15px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
            transition: border-color var(--transition-lux), background-color var(--transition-lux);
        }

        .tabs-header {
            display: flex;
            gap: 1rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1.2rem;
            margin-bottom: 1.8rem;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .tabs-header::-webkit-scrollbar {
            display: none;
        }

        .tab-trigger {
            background: none;
            border: none;
            color: var(--text-muted);
            padding: 0.6rem 1.2rem;
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: var(--transition-lux);
            border-bottom: 2px solid transparent;
        }

        .tab-trigger.active {
            color: var(--primary-red);
            border-color: var(--primary-red);
        }

        .tab-content {
            display: none;
            font-size: 1.15rem;
            line-height: 1.9;
            color: var(--text-main);
            animation: fadeIn 0.5s ease forwards;
        }

        .tab-content.active {
            display: block;
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

        /* الجانب البصري للصور */
        .founder-visuals {
            display: flex;
            flex-direction: column;
            gap: 1.8rem;
            align-items: center;
        }

        .main-portrait-wrapper {
            position: relative;
            width: 100%;
            max-width: 440px;
            aspect-ratio: 4 / 5;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 30px 50px rgba(0, 0, 0, 0.6);
            background: #0d0d0f;
        }

        .main-portrait {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.4s ease-in-out, transform 1.5s ease-out;
        }

        .main-portrait-wrapper:hover .main-portrait {
            transform: scale(1.03);
        }

        /* مصغرات الصور (تم الضبط لصورتين فقط بناءً على طلبك) */
        .thumbnail-gallery {
            display: flex;
            gap: 15px;
            justify-content: center;
            width: 100%;
            max-width: 440px;
        }

        .thumbnail-item {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
            transition: var(--transition-lux);
            opacity: 0.5;
        }

        .thumbnail-item:hover,
        .thumbnail-item.active {
            border-color: var(--primary-red);
            opacity: 1;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 20px rgba(180, 0, 0, 0.2);
        }

        .thumbnail-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ===================================== */
        /* 4. كروت الأرقام القياسية              */
        /* ===================================== */
        .stats-section {
            padding: 5rem 5%;
            background-color: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            position: relative;
            z-index: 20;
        }

        .stats-grid {
            max-width: 1300px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2.5rem;
        }

        .stat-card {
            background: var(--bg-main);
            border: 1px solid var(--border-color);
            padding: 3rem 2.5rem;
            border-radius: 12px;
            text-align: center;
            transition: var(--transition-lux);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary-red);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--primary-red);
            margin-bottom: 0.8rem;
        }

        .stat-title {
            font-size: 1.3rem;
            color: var(--text-main);
            font-weight: 700;
            margin-bottom: 0.8rem;
        }

        .stat-desc {
            font-size: 1.1rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ===================================== */
        /* 5. قسم الشركات المملوكة (جديد ومميز)  */
        /* ===================================== */
        .companies-section {
            padding: 6rem 5%;
            background-color: var(--bg-main);
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--cream-beige);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            text-align: center;
            color: var(--primary-red);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 4rem;
        }

        .companies-grid {
            max-width: 1300px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .company-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: var(--transition-lux);
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .company-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-red);
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform 0.4s ease;
        }

        .company-card:hover {
            transform: translateY(-5px);
            border-color: rgba(180, 0, 0, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .company-card:hover::before {
            transform: scaleY(1);
        }

        .company-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .company-field {
            color: var(--text-muted);
            font-size: 1rem;
            line-height: 1.5;
        }

        .company-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            font-size: 0.95rem;
            font-weight: 600;
        }

        .company-country {
            color: var(--warm-beige);
        }

        .company-role {
            color: var(--primary-red);
        }

        /* ===================================== */
        /* 6. قسم الأوسمة والجوائز               */
        /* ===================================== */
        .awards-section {
            padding: 6rem 5%;
            background-color: var(--bg-tertiary);
            border-top: 1px solid var(--border-color);
        }

        .awards-timeline {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            padding-right: 2rem;
            border-right: 2px solid var(--primary-red);
        }

        html[dir="ltr"] .awards-timeline {
            padding-right: 0;
            padding-left: 2rem;
            border-right: none;
            border-left: 2px solid var(--primary-red);
        }

        .award-item {
            position: relative;
            margin-bottom: 3rem;
            padding-right: 2rem;
        }

        html[dir="ltr"] .award-item {
            padding-right: 0;
            padding-left: 2rem;
        }

        .award-item::before {
            content: '';
            position: absolute;
            top: 5px;
            right: -2.6rem;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--bg-main);
            border: 3px solid var(--primary-red);
            box-shadow: 0 0 10px rgba(180, 0, 0, 0.5);
        }

        html[dir="ltr"] .award-item::before {
            right: auto;
            left: -2.6rem;
        }

        .award-year {
            font-size: 1.2rem;
            color: var(--primary-red);
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .award-title {
            font-size: 1.5rem;
            color: var(--text-main);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .award-desc {
            color: var(--text-muted);
            font-size: 1.1rem;
            line-height: 1.7;
        }

        /* زر الإغلاق والرجوع */
        .back-home-wrapper {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
        }

        .back-home-btn {
            border: 1px solid var(--primary-red);
            color: var(--warm-beige);
            padding: 1rem 3rem;
            text-decoration: none;
            font-size: 1.15rem;
            font-weight: bold;
            transition: var(--transition-lux);
            border-radius: 4px;
        }

        .back-home-btn:hover {
            background-color: var(--primary-red);
            color: #fff;
            box-shadow: 0 10px 20px rgba(180, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        html[dir="rtl"] .back-home-btn::before {
            content: '← ';
        }

        html[dir="ltr"] .back-home-btn::before {
            content: '→ ';
        }

        /* ===================================== */
        /* 7. فوتر الصفحة                        */
        /* ===================================== */
        .footer-lux {
            padding: 3rem 5%;
            background-color: var(--black);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .footer-logo {
            margin-bottom: 1.2rem;
            color: var(--warm-beige);
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* التجاوب مع الجوال */
        @media (max-width: 768px) {
            .header-actions .action-btn span {
                display: none;
            }

            .founder-hero {
                padding: 8rem 5% 4rem;
            }

            .back-home-wrapper {
                justify-content: center;
            }

            .contact-group {
                justify-content: center;
            }

            .tag-badge {
                align-self: center;
            }

            .founder-name,
            .founder-title {
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <header class="hero-header">
        <a href="/" class="brand-logo-container">
            <div class="brand-logo-circle">
                <img src="{{ asset('albrolosy_logo.png') }}" alt="Al-Brolosy Logo">
            </div>
            <span class="brand-title">AlBrolosy</span>
        </a>

        <div class="header-actions">
            <button id="theme-switcher" class="action-btn" type="button" title="Toggle Theme">
                <svg class="icon-svg" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span data-en="Theme" data-ar="المظهر">المظهر</span>
            </button>

            <button id="lang-switcher" class="action-btn" type="button">
                <svg class="icon-svg" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 0H3m14 11h6m-3-3v6M17 14h6" />
                </svg>
                <span class="lang-en">EN</span><span class="lang-separator">/</span><span class="lang-ar">AR</span>
            </button>
        </div>
    </header>

    <section class="founder-hero">
        <!-- تم الاكتفاء بالخلفية السينمائية المتدرجة مع إمكانية إضافة فيديو إن وجد -->
        <div class="cinematic-overlay"></div>

        <div class="founder-container">

            <div class="founder-info-block">
                <span class="tag-badge" data-en="FOUNDER & CEO" data-ar="مؤسس مجموعة شركات ورئيس تنفيذي">مؤسس مجموعة
                    شركات ورئيس تنفيذي</span>
                <h1 class="founder-name" data-en="Eng. Ghanim Al-Brolosy" data-ar="م. غانم البرلسي">م. غانم البرلسي</h1>
                <div class="founder-title" data-en="A legacy of strategic leadership across the Middle East"
                    data-ar="قائد استراتيجي ومؤسس كيانات إقليمية رائدة عبر الخليج والشرق الأوسط">قائد استراتيجي ومؤسس
                    كيانات إقليمية رائدة عبر الخليج والشرق الأوسط</div>

                <div class="contact-group">
                    <a href="https://ghanimalbrolosy.com/" target="_blank" class="social-btn" title="Official Website">
                        <svg viewBox="0 0 512 512">
                            <path
                                d="M352 256c0 22.2-1.2 43.6-3.3 64H163.3c-2.1-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64h185.4c2.1 20.4 3.3 41.8 3.3 64zm28.8-64H503.9c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64H380.8c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32H376.7c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0H167.7c10-63.9 29.8-117.4 55.3-151.6c-25.5 34.2-45.3 87.7-55.3 151.6zM8.1 192H131.2c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64H8.1C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.4c-25.5-34.2-45.3-87.7-55.3-151.6h176.6c-10 63.9-29.8 117.4-55.3 151.6c25.5-34.2 45.3-87.7 55.3-151.6zM135.3 352H18.6c29.9 74.1 93.6 130.9 171.9 151.6c-25.5-34.2-45.3-87.7-55.3-151.6zm358.1 0H376.7c-10 63.9-29.8 117.4-55.3 151.6c78.3-20.7 142-77.5 171.9-151.6z" />
                        </svg>
                        <span data-en="Official Website" data-ar="الموقع الرسمي">الموقع الرسمي</span>
                    </a>
                    <a href="mailto:info@ghanimalbrolosy.com" class="social-btn" title="Email">
                        <svg viewBox="0 0 512 512">
                            <path
                                d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
                        </svg>
                        <span data-en="Contact via Email" data-ar="تواصل عبر البريد">تواصل عبر البريد</span>
                    </a>
                </div>

                <div class="interactive-tabs-container">
                    <div class="tabs-header">
                        <button class="tab-trigger active" data-tab="story" data-en="His Story"
                            data-ar="قصته وبداياته">قصته وبداياته</button>
                        <button class="tab-trigger" data-tab="philosophy" data-en="Philosophy"
                            data-ar="نهجه وفلسفته">نهجه وفلسفته</button>
                        <button class="tab-trigger" data-tab="education" data-en="Education"
                            data-ar="المسيرة الأكاديمية">المسيرة الأكاديمية</button>
                    </div>

                    <div class="tab-content active" id="story">
                        <p data-en="Born in El-Sherka El-Engleziya - Dekernes, Dakahlia, Eng. Ghanim pursued his dream of studying engineering early on. He graduated in 2006, specializing in electricity and renewable energy. His ambition carried him to Kuwait, starting as a manufacturing and design engineer, then evolving into project management. His journey reflects a transition from a hardworking young engineer to a strategic leader founding prominent companies across the Gulf and Middle East."
                            data-ar="وُلد غانم البرلسي في قرية الشركة الانجليزية - مركز دكرنس - الدقهلية، حيث بدأ حلمه مبكراً بدراسة الهندسة. تخرّج عام 2006، متخصصاً في الآلات الكهربائية ومشاريع الطاقة المتجددة. حمل طموحه إلى الكويت ليبدأ كمهندس تصنيع وتصميم، ثم انتقل لإدارة المشاريع. تعكس رحلته الانتقال من المهندس الشاب المجتهد إلى قائد استراتيجي يبتكر حلولاً استثمارية ويقود كيانات كبرى مثل دماك الخليجية والبرلسي للتطوير العقاري.">
                            وُلد غانم البرلسي في قرية الشركة الانجليزية - مركز دكرنس - الدقهلية، حيث بدأ حلمه مبكراً
                            بدراسة الهندسة. تخرّج عام 2006، متخصصاً في الآلات الكهربائية ومشاريع الطاقة المتجددة. حمل
                            طموحه إلى الكويت ليبدأ كمهندس تصنيع وتصميم، ثم انتقل لإدارة المشاريع. تعكس رحلته الانتقال من
                            المهندس الشاب المجتهد إلى قائد استراتيجي يبتكر حلولاً استثمارية ويقود كيانات كبرى مثل دماك
                            الخليجية والبرلسي للتطوير العقاري.
                        </p>
                    </div>

                    <div class="tab-content" id="philosophy">
                        <p data-en="He believes that success is not a coincidence, but a plan built with science and hard work. With the motto 'One Family.. One Success', he sees employees not just as operational elements, but as a united family driven by a shared vision. True investment begins with people, creating cohesive teams capable of innovation and strategic decision-making to achieve sustainable growth."
                            data-ar="آمن أن النجاح ليس صدفة، بل خطة تُبنى بالعلم والعمل. يتبنى فلسفة 'أسرة واحدة .. نجاح واحد'، فالموظفون ليسوا مجرد عناصر تشغيلية، بل أسرة تجمعها رؤية مشتركة. يؤمن أن الاستثمار الحقيقي يبدأ من الإنسان، وأن بناء فرق متماسكة قادرة على الابتكار هو ما يصنع الفارق، لتصبح كل شركة امتداداً لعائلة مهنية تسعى للنمو المستدام.">
                            آمن أن النجاح ليس صدفة، بل خطة تُبنى بالعلم والعمل. يتبنى فلسفة "أسرة واحدة .. نجاح واحد"،
                            فالموظفون ليسوا مجرد عناصر تشغيلية، بل أسرة تجمعها رؤية مشتركة. يؤمن أن الاستثمار الحقيقي
                            يبدأ من الإنسان، وأن بناء فرق متماسكة قادرة على الابتكار هو ما يصنع الفارق، لتصبح كل شركة
                            امتداداً لعائلة مهنية تسعى للتميز والنمو المستدام.
                        </p>
                    </div>

                    <div class="tab-content" id="education">
                        <p data-en="A strong academic foundation complements his vast practical experience. Eng. Ghanim holds a Bachelor’s degree in Engineering from Mansoura University (2006) majoring in Electrical Machines & Renewable Energy. He furthered his expertise by obtaining an MBA in 2026 and continues his academic pursuit as a PhD Researcher, adding deep scientific and technical dimensions to his corporate leadership."
                            data-ar="تستند خبرته العملية إلى خلفية أكاديمية قوية، حيث حصل على بكالوريوس الهندسة من جامعة المنصورة (2006) بتخصص الآلات الكهربائية ومشاريع الطاقة المتجددة. ولم يكتفِ بذلك، بل حصل على الماجستير المهني في إدارة الأعمال MBA لعام (2026)، ويواصل مسيرته كباحث أكاديمي (PhD)، مما يضيف بُعداً علمياً واستراتيجياً عميقاً لخبرته الواسعة.">
                            تستند خبرته العملية إلى خلفية أكاديمية قوية، حيث حصل على بكالوريوس الهندسة من جامعة المنصورة
                            (2006) بتخصص الآلات الكهربائية ومشاريع الطاقة المتجددة. ولم يكتفِ بذلك، بل حصل على الماجستير
                            المهني في إدارة الأعمال MBA لعام (2026)، ويواصل مسيرته كباحث أكاديمي (PhD)، مما يضيف بُعداً
                            علمياً واستراتيجياً عميقاً لخبرته وإدارته للشركات.
                        </p>
                    </div>
                </div>
            </div>

            <div class="founder-visuals" id="gallery-container">
                <div class="main-portrait-wrapper">
                    <!-- الصورة الأساسية (بناءً على طلبك هما صورتين فقط متوفرين) -->
                    <img id="main-active-img" src="{{ asset('images/founders/ghanim/1.png') }}"
                        alt="Eng. Ghanim Al-Brolosy" class="main-portrait">
                </div>

                <div class="thumbnail-gallery">
                    <div class="thumbnail-item active" id="thumb-1" onclick="manualSwitch(1)">
                        <img src="{{ asset('images/founders/ghanim/1.png') }}" alt="Ghanim Portrait 1">
                    </div>
                    <div class="thumbnail-item" id="thumb-2" onclick="manualSwitch(2)">
                        <img src="{{ asset('images/founders/ghanim/2.png') }}" alt="Ghanim Portrait 2">
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- الأرقام القياسية -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">18+</div>
                <div class="stat-title" data-en="Years of Experience" data-ar="عاماً من الخبرة">عاماً من الخبرة</div>
                <div class="stat-desc"
                    data-en="Extensive practical experience building robust entities across multiple sectors."
                    data-ar="خبرة عملية طويلة في بناء الكيانات القوية وإدارة وتطوير الأعمال المتعددة القطاعات.">خبرة
                    عملية طويلة في بناء الكيانات القوية وإدارة وتطوير الأعمال المتعددة القطاعات.</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">10</div>
                <div class="stat-title" data-en="Successful Companies" data-ar="شركات إقليمية وعالمية">شركات إقليمية
                    وعالمية</div>
                <div class="stat-desc"
                    data-en="Founded and managed diverse companies in real estate, technology, and trade."
                    data-ar="تأسيس وإدارة شبكة متكاملة من الشركات الرائدة في العقارات، التجارة، والتكنولوجيا.">تأسيس
                    وإدارة شبكة متكاملة من الشركات الرائدة في العقارات، التجارة، والتكنولوجيا.</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">6</div>
                <div class="stat-title" data-en="Countries" data-ar="دول تم العمل بها">دول تم التوسع بها</div>
                <div class="stat-desc" data-en="Kuwait, Egypt, UAE, Oman, China, and Cyprus."
                    data-ar="الكويت، مصر، الإمارات (دبي)، سلطنة عمان، الصين، وقبرص.">الكويت، مصر، الإمارات (دبي)، سلطنة
                    عمان، الصين، وقبرص.</div>
            </div>
        </div>
    </section>

    <!-- قسم الشركات المملوكة -->
    <section class="companies-section">
        <h2 class="section-title" data-en="Owned Companies & Entities" data-ar="الشركات المملوكة">الشركات المملوكة
        </h2>
        <p class="section-subtitle" data-en="An integrated network of leading companies across the Gulf & Middle East"
            data-ar="شبكة متكاملة من الشركات الرائدة عبر دول الخليج والشرق الأوسط">شبكة متكاملة من الشركات الرائدة عبر
            دول الخليج والشرق الأوسط</p>

        <div class="companies-grid">
            <!-- كارت 1 -->
            <div class="company-card">
                <div class="company-name" data-en="Damac Gulf" data-ar="دماك الخليجية">دماك الخليجية</div>
                <div class="company-field" data-en="Contracting, Infrastructure & Construction"
                    data-ar="مقاولات - بنية تحتية - وإنشاءات">مقاولات - بنية تحتية - وإنشاءات</div>
                <div class="company-meta">
                    <span class="company-country">🇰🇼 الكويت</span>
                    <span class="company-role">مؤسس ورئيس تنفيذي</span>
                </div>
            </div>
            <!-- كارت 2 -->
            <div class="company-card">
                <div class="company-name" data-en="Pro Damac" data-ar="برو دماك">برو دماك</div>
                <div class="company-field" data-en="General Trade" data-ar="تجارة عامة">تجارة عامة</div>
                <div class="company-meta">
                    <span class="company-country">🇰🇼 الكويت</span>
                    <span class="company-role">مؤسس ومدير عام</span>
                </div>
            </div>
            <!-- كارت 3 -->
            <div class="company-card">
                <div class="company-name" data-en="Al-Brolosy" data-ar="البرلسي">البرلسي</div>
                <div class="company-field" data-en="Real Estate Development" data-ar="تطوير عقاري">تطوير عقاري</div>
                <div class="company-meta">
                    <span class="company-country">🇪🇬 مصر</span>
                    <span class="company-role">مؤسس وعضو مجلس إدارة</span>
                </div>
            </div>
            <!-- كارت 4 -->
            <div class="company-card">
                <div class="company-name" data-en="Al-Ghanim Integrated" data-ar="الغانم المتكاملة">الغانم المتكاملة
                </div>
                <div class="company-field" data-en="Trade & Development" data-ar="التجارة والتطوير">التجارة والتطوير
                </div>
                <div class="company-meta">
                    <span class="company-country">🇴🇲 سلطنة عُمان</span>
                    <span class="company-role">شريك وعضو مجلس إدارة</span>
                </div>
            </div>
            <!-- كارت 5 -->
            <div class="company-card">
                <div class="company-name" data-en="Makased" data-ar="مقاصد">مقاصد</div>
                <div class="company-field" data-en="Technological Trade" data-ar="التجارة التكنولوجية">التجارة
                    التكنولوجية</div>
                <div class="company-meta">
                    <span class="company-country">🇦🇪 دبي - الإمارات</span>
                    <span class="company-role">مؤسس ومدير عام</span>
                </div>
            </div>
            <!-- كارت 6 -->
            <div class="company-card">
                <div class="company-name" data-en="Al-Ghanim International" data-ar="الغانم الدولية للتجارة">الغانم
                    الدولية للتجارة</div>
                <div class="company-field" data-en="General Trade & Manufacturing" data-ar="التجارة العامة والتصنيع">
                    التجارة العامة والتصنيع</div>
                <div class="company-meta">
                    <span class="company-country">🇨🇳 الصين</span>
                    <span class="company-role">مؤسس ومدير عام</span>
                </div>
            </div>
            <!-- كارت 7 -->
            <div class="company-card">
                <div class="company-name" data-en="Pro Damac Europe" data-ar="برو دماك أوروبا">برو دماك أوروبا</div>
                <div class="company-field" data-en="International Trade" data-ar="التجارة الدولية">التجارة الدولية
                </div>
                <div class="company-meta">
                    <span class="company-country">🇨🇾 قبرص</span>
                    <span class="company-role">مؤسس ومدير عام</span>
                </div>
            </div>
            <!-- كارت 8 -->
            <div class="company-card">
                <div class="company-name" data-en="AGI" data-ar="AGI">AGI</div>
                <div class="company-field" data-en="Technology & Innovation" data-ar="التكنولوجيا والابتكار">
                    التكنولوجيا والابتكار</div>
                <div class="company-meta">
                    <span class="company-country">🇰🇼 الكويت</span>
                    <span class="company-role">مؤسس ومدير عام</span>
                </div>
            </div>
            <!-- كارت 9 -->
            <div class="company-card">
                <div class="company-name" data-en="G-Tech" data-ar="G-Tech">G-Tech</div>
                <div class="company-field" data-en="Electronic & Tech Systems"
                    data-ar="الأنظمة الإلكترونية والتقنية">الأنظمة الإلكترونية والتقنية</div>
                <div class="company-meta">
                    <span class="company-country">🇰🇼 الكويت</span>
                    <span class="company-role">مؤسس ومدير عام</span>
                </div>
            </div>
            <!-- كارت 10 -->
            <div class="company-card">
                <div class="company-name" data-en="MAK-Tec" data-ar="MAK-Tec">MAK-Tec</div>
                <div class="company-field" data-en="Advanced Tech Solutions" data-ar="الحلول التقنية المتقدمة">الحلول
                    التقنية المتقدمة</div>
                <div class="company-meta">
                    <span class="company-country">🇰🇼 الكويت</span>
                    <span class="company-role">مؤسس ومدير عام</span>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم الأوسمة والجوائز -->
    <section class="awards-section">
        <h2 class="section-title" data-en="Awards & Honors" data-ar="الأوسمة والجوائز">الأوسمة والجوائز</h2>
        <p class="section-subtitle" data-en="A legacy celebrated with distinguished recognitions"
            data-ar="تتويج المسيرة بأرفع درجات التكريم والتقدير">تتويج المسيرة بأرفع درجات التكريم والتقدير</p>

        <div class="awards-timeline">
            <div class="award-item">
                <div class="award-year">2026</div>
                <div class="award-title" data-en="Administrative Excellence Award" data-ar="جائزة التميز الإداري">
                    جائزة التميز الإداري 2026</div>
                <div class="award-desc"
                    data-en="Recognition for exceptional achievements in business leadership and strategic expansion."
                    data-ar="تقدير على الإنجازات الاستثنائية في قيادة الأعمال والتوسع الاستراتيجي في الأسواق الإقليمية.">
                    تقدير على الإنجازات الاستثنائية في قيادة الأعمال والتوسع الاستراتيجي في الأسواق الإقليمية.</div>
            </div>
            <div class="award-item">
                <div class="award-year">2022</div>
                <div class="award-title" data-en="Administrative Excellence Medal" data-ar="وسام التميز الإداري">وسام
                    التميز الإداري</div>
                <div class="award-desc" data-en="Honored for outstanding leadership and robust corporate management."
                    data-ar="تكريم على القيادة المتميزة والإدارة الحكيمة للشركات والمشروعات الكبرى.">تكريم على القيادة
                    المتميزة والإدارة الحكيمة للشركات والمشروعات الكبرى.</div>
            </div>
            <div class="award-item">
                <div class="award-year">2020</div>
                <div class="award-title" data-en="Honest Contractor Star" data-ar="جائزة نجم المقاول الأمين">جائزة
                    نجم المقاول الأمين</div>
                <div class="award-desc"
                    data-en="Appreciation for profound commitment, credibility, and quality in project execution."
                    data-ar="تقدير على الالتزام والمصداقية العالية في تنفيذ المشاريع الإنشائية والهندسية.">تقدير على
                    الالتزام والمصداقية العالية في تنفيذ المشاريع الإنشائية والهندسية.</div>
            </div>
            <div class="award-item">
                <div class="award-year">2019</div>
                <div class="award-title" data-en="Golden Sponsor" data-ar="الراعي الذهبي">الراعي الذهبي</div>
                <div class="award-desc"
                    data-en="Honoring the company as a golden sponsor for a major real estate exhibition."
                    data-ar="تكريم شركة مقاصد كراعٍ ذهبي لمعرض عقاري كبير تأكيداً لدورها الريادي في السوق.">تكريم شركة
                    مقاصد كراعٍ ذهبي لمعرض عقاري كبير تأكيداً لدورها الريادي في السوق.</div>
            </div>
        </div>

        <div class="back-home-wrapper">
            <a href="/" class="back-home-btn" data-en="Back to main page" data-ar="العودة للرئيسية">العودة
                للرئيسية</a>
        </div>
    </section>

    <footer class="footer-lux">
        <div class="footer-logo">AlBrolosy</div>
        <p>&copy; 2026 المهندس غانم البرلسي — جميع الحقوق محفوظة | Developed by Ecom-Eg</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // أزرار اللغة والثيم
            document.getElementById("lang-switcher")?.addEventListener("click", () => {
                window.preferences?.toggleLanguage();
            });
            document.getElementById("theme-switcher")?.addEventListener("click", () => {
                window.preferences?.toggleTheme();
            });

            // التبويبات التفاعلية
            const triggers = document.querySelectorAll('.tab-trigger');
            const contents = document.querySelectorAll('.tab-content');

            triggers.forEach(trigger => {
                trigger.addEventListener('click', () => {
                    triggers.forEach(t => t.classList.remove('active'));
                    trigger.classList.add('active');
                    contents.forEach(content => content.classList.remove('active'));
                    const targetTab = trigger.getAttribute('data-tab');
                    document.getElementById(targetTab).classList.add('active');
                });
            });
        });

        // ==========================================
        // نظام السلايدر لصور المهندس غانم (تم ضبطه لصورتين فقط)
        // ==========================================
        let currentImgIndex = 1;
        const totalImages = 2; // تم التعديل لصورتين كما طلبت
        const basePath = "{{ asset('images/founders/ghanim') }}/";
        let slideInterval;

        const preloadedImages = [];
        for (let i = 1; i <= totalImages; i++) {
            const img = new Image();
            img.src = `${basePath}${i}.png`;
            preloadedImages.push(img);
        }

        function switchPortrait(index) {
            const mainImg = document.getElementById('main-active-img');
            mainImg.style.opacity = '0.4';

            setTimeout(() => {
                mainImg.src = `${basePath}${index}.png`;
                mainImg.style.opacity = '1';
            }, 150);

            document.querySelectorAll('.thumbnail-item').forEach(item => {
                item.classList.remove('active');
            });

            document.getElementById(`thumb-${index}`).classList.add('active');
            currentImgIndex = index;
        }

        function autoSlide() {
            let nextIndex = currentImgIndex + 1;
            if (nextIndex > totalImages) {
                nextIndex = 1;
            }
            switchPortrait(nextIndex);
        }

        function startSlider() {
            slideInterval = setInterval(autoSlide, 5000); // 5 ثواني للتنقل
        }

        function stopSlider() {
            clearInterval(slideInterval);
        }

        function manualSwitch(index) {
            if (index === currentImgIndex) return;
            stopSlider();
            switchPortrait(index);
            startSlider();
        }

        startSlider();

        const galleryContainer = document.getElementById('gallery-container');
        galleryContainer.addEventListener('mouseenter', stopSlider);
        galleryContainer.addEventListener('mouseleave', startSlider);
    </script>
</body>

</html>

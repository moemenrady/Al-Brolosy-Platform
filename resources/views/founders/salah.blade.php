<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-en="Eng. Salah Al-Brolosy - CEO" data-ar="م. صلاح البرلسي - الرئيس التنفيذي">م. صلاح البرلسي - الرئيس التنفيذي</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

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
            --text-main: #F0F0F0;
            --text-muted: #aaacb0;
            --border-color: rgba(228, 220, 199, 0.15);
            --card-glass: rgba(13, 13, 15, 0.85);
        }

        html[data-theme="light"] {
            --bg-main: #F4F4F6;
            --bg-secondary: #ffffff;
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
            font-size: 1.5rem; /* تم تكبير النص */
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
            font-size: 1rem; /* تم تكبير النص */
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
            opacity: 0.35;
            transition: opacity 1.5s ease;
        }

        .cinematic-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, var(--bg-main) 5%, rgba(0, 0, 0, 0.65) 50%, rgba(0, 0, 0, 0.9) 100%);
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
            font-size: 1rem; /* تم تكبير النص */
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }

        .founder-name {
            font-size: 3rem; /* تم تكبير النص */
            font-weight: 800;
            color: var(--cream-beige);
            line-height: 1.2;
            margin-bottom: 0.8rem;
        }

        @media (min-width: 768px) {
            .founder-name {
                font-size: 4rem; /* تم تكبير النص بشكل ملحوظ للشاشات الكبيرة */
            }
        }

        .founder-title {
            font-size: 1.4rem; /* تم تكبير النص */
            color: var(--primary-red);
            font-weight: 700;
            margin-bottom: 1.8rem;
        }

        /* زر الفيسبوك */
        .social-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1.8rem;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--off-white);
            text-decoration: none;
            border-radius: 8px;
            font-size: 1.1rem; /* تم تكبير النص */
            font-weight: 700;
            margin-bottom: 2.5rem;
            align-self: flex-start;
            transition: var(--transition-lux);
        }

        .social-btn:hover {
            background-color: #1877F2;
            border-color: #1877F2;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(24, 119, 242, 0.3);
        }

        .social-btn svg {
            width: 22px;
            height: 22px;
            fill: currentColor;
        }

        .interactive-tabs-container {
            background: var(--card-glass);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2.5rem; /* توسعة المساحة الداخلية */
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
            font-size: 1.15rem; /* تم تكبير النص */
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
            font-size: 1.15rem; /* تم تكبير النص */
            line-height: 1.9; /* زيادة المسافة بين السطور لراحة العين */
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
            max-width: 440px; /* تكبير بسيط للإطار */
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
            /* تسريع تأثير الفيد لتجنب رؤية التقطيع */
            transition: opacity 0.4s ease-in-out, transform 1.5s ease-out;
        }

        .main-portrait-wrapper:hover .main-portrait {
            transform: scale(1.03);
        }

        /* مصغرات الصور */
        .thumbnail-gallery {
            display: flex;
            gap: 15px;
            justify-content: center;
            width: 100%;
            max-width: 440px;
        }

        .thumbnail-item {
            width: 75px;
            height: 75px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
            transition: var(--transition-lux);
            opacity: 0.5;
        }

        @media (min-width: 768px) {
            .thumbnail-item {
                width: 85px;
                height: 85px;
            }
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
            font-size: 3.5rem; /* تم تكبير النص */
            font-weight: 800;
            color: var(--primary-red);
            margin-bottom: 0.8rem;
        }

        .stat-title {
            font-size: 1.3rem; /* تم تكبير النص */
            color: var(--text-main);
            font-weight: 700;
            margin-bottom: 0.8rem;
        }

        .stat-desc {
            font-size: 1.1rem; /* تم تكبير النص */
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* زر الإغلاق والرجوع */
        .back-home-wrapper {
            margin-top: 3rem;
            display: flex;
        }

        .back-home-btn {
            border: 1px solid var(--primary-red);
            color: var(--warm-beige);
            padding: 1rem 3rem;
            text-decoration: none;
            font-size: 1.15rem; /* تم تكبير النص */
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
        /* 5. فوتر الصفحة                        */
        /* ===================================== */
        .footer-lux {
            padding: 3rem 5%;
            background-color: var(--black);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            color: var(--text-muted);
            font-size: 1.1rem; /* تم تكبير النص */
        }

        .footer-logo {
            margin-bottom: 1.2rem;
            color: var(--warm-beige);
            font-size: 1.6rem; /* تم تكبير النص */
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* التجاوب مع الجوال (Mobile Responsiveness) */
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

            .social-btn {
                align-self: center;
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
        <div class="bg-video-wrapper">
            <video class="bg-video" autoplay loop muted playsinline>
                <source src="videos/albrolosy-vid.mp4" type="video/mp4">
            </video>
        </div>
        <div class="cinematic-overlay"></div>

        <div class="founder-container">

            <div class="founder-info-block">
                <span class="tag-badge" data-en="CO-FOUNDER & CEO" data-ar="الشريك المؤسس والرئيس التنفيذي">الشريك
                    المؤسس والرئيس التنفيذي</span>
                <h1 class="founder-name" data-en="Eng. Salah Al-Brolosy" data-ar="م. صلاح البرلسي">م. صلاح البرلسي</h1>
                <div class="founder-title" data-en="CEO of Al-Brolosy Real Estate Development"
                    data-ar="الرئيس التنفيذي لشركة البرلسي للتطوير العقاري">الرئيس التنفيذي لشركة البرلسي للتطوير
                    العقاري</div>

                <a href="https://www.facebook.com/SalahAlBorolosy/" target="_blank" class="social-btn"
                    title="Facebook Page">
                    <svg viewBox="0 0 320 512">
                        <path
                            d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" />
                    </svg>
                    <span data-en="Follow on Facebook" data-ar="تواصل عبر فيسبوك">صفحة الفيسبوك</span>
                </a>

                <div class="interactive-tabs-container">
                    <div class="tabs-header">
                        <button class="tab-trigger active" data-tab="journey" data-en="Our Journey"
                            data-ar="المسيرة المهنية">المسيرة المهنية</button>
                        <button class="tab-trigger" data-tab="roles" data-en="Leadership Roles"
                            data-ar="المناصب القيادية">المناصب القيادية</button>
                        <button class="tab-trigger" data-tab="philosophy" data-en="Our Philosophy"
                            data-ar="الرؤية والمنهج">الرؤية والمنهج</button>
                    </div>

                    <div class="tab-content active" id="journey">
                        <p data-en="Eng. Salah possesses a strong engineering background. He began his career in the State of Kuwait, where he was a co-founder of Damac Gulf Holding Company, specializing in general contracting. There, he held key executive roles that contributed to constructing and executing major projects in collaboration with local and regional partners. From Kuwait, his expansionist vision took off to establish an integrated real estate entity in Egypt, aligned with the region's urban ambitions."
                            data-ar="يمتلك م/صلاح خلفية هندسية قوية. بدأ مسيرته في دولة الكويت، حيث كان من المؤسسين لشركة دماك الخليجية، الشركة القابضة المتخصصة في المقاولات العامة، وهناك تولّى أدوارًا تنفيذية محورية ساهمت في بناء وتنفيذ مشاريع كبرى بالتعاون مع شركاء محليين وإقليميين. ومن الكويت، انطلقت رؤيته التوسعية لتأسيس كيان عقاري متكامل في مصر، يواكب الطموحات العمرانية للمنطقة.">
                            يمتلك م/صلاح خلفية هندسية قوية. بدأ مسيرته في دولة الكويت، حيث كان من المؤسسين لشركة دماك
                            الخليجية، الشركة القابضة المتخصصة في المقاولات العامة، وهناك تولّى أدوارًا تنفيذية محورية
                            ساهمت في بناء وتنفيذ مشاريع كبرى بالتعاون مع شركاء محليين وإقليميين. ومن الكويت، انطلقت
                            رؤيته التوسعية لتأسيس كيان عقاري متكامل في مصر، يواكب الطموحات العمرانية للمنطقة.
                        </p>
                    </div>

                    <div class="tab-content" id="roles">
                        <p data-en="As a Board Member of the Real Estate Development Division at the Chamber of Commerce, Head of the Investment Secretariat of the Nation's Future Party in Damietta, and CEO of Al-Brolosy, Eng. Salah leads a growth strategy built on developing integrated urban communities and forging partnerships based on efficiency and commitment to quality."
                            data-ar="بصفته عضو مجلس إدارة شعبة التطوير العقاري بالغرفة التجارية، ورئيس أمانة الاستثمار بحزب مستقبل وطن بدمياط، والرئيس التنفيذي لشركة البرلسي، يقود م.صلاح البرلسي استراتيجية النمو القائمة على تطوير مجتمعات عمرانية متكاملة، وإبرام شراكات قائمة على الكفاءة والالتزام بالجودة.">
                            بصفته عضو مجلس إدارة شعبة التطوير العقاري بالغرفة التجارية، ورئيس أمانة الاستثمار بحزب
                            مستقبل وطن بدمياط، والرئيس التنفيذي لشركة البرلسي، يقود م.صلاح البرلسي استراتيجية النمو
                            القائمة على تطوير مجتمعات عمرانية متكاملة، وإبرام شراكات قائمة على الكفاءة والالتزام
                            بالجودة.
                        </p>
                    </div>

                    <div class="tab-content" id="philosophy">
                        <p data-en="Eng. Salah is distinguished by his decisive leadership and practical approach, focusing on enhancing the investment value of projects. Recently, his expansion vision was crowned by launching the 'Sana Towers' project in New Mansoura, featuring the city's first 5-star hotel in strategic partnership with Saudi investors, reflecting his commitment to supporting national tourism and economy."
                            data-ar="يتميز بقيادته الحازمة ونهجه العملي لحرصه على تعزيز القيمة الاستثمارية للمشاريع وتحقيق أثر ملموس في البيئة العمرانية. وقد توجت رؤيته التوسعية مؤخراً بإطلاق مشروع «سانا تاورز» بمدينة المنصورة الجديدة، والذي يضم أول فندق 5 نجوم بالمدينة، بشراكة استراتيجية مع «بان القابضة» السعودية، مما يعكس التزامه بدعم السياحة والاقتصاد الوطني.">
                            يتميز بقيادته الحازمة ونهجه العملي لحرصه على تعزيز القيمة الاستثمارية للمشاريع وتحقيق أثر
                            ملموس في البيئة العمرانية. وقد توجت رؤيته التوسعية مؤخراً بإطلاق مشروع «سانا تاورز» بمدينة
                            المنصورة الجديدة، والذي يضم أول فندق 5 نجوم بالمدينة، بشراكة استراتيجية مع «بان القابضة»
                            السعودية، مما يعكس التزامه بدعم السياحة والاقتصاد الوطني.
                        </p>
                    </div>
                </div>

                <div class="back-home-wrapper">
                    <a href="/" class="back-home-btn" data-en="Back to main page"
                        data-ar="العودة للرئيسية">العودة للرئيسية</a>
                </div>
            </div>

            <div class="founder-visuals" id="gallery-container">
                <div class="main-portrait-wrapper">
                    <!-- تم التعديل هنا لدعم بيئة لارافيل بشكل صحيح من البداية ولتتطابق الصورة مع المصغرات -->
                    <img id="main-active-img" src="{{ asset('images/founders/salah/1.png') }}" alt="Eng. Salah Al-Brolosy"
                        class="main-portrait">
                </div>

                <div class="thumbnail-gallery">
                    <div class="thumbnail-item active" id="thumb-1" onclick="manualSwitch(1)">
                        <img src="{{ asset('images/founders/salah/1.png') }}" alt="Salah Portrait 1">
                    </div>
                    <div class="thumbnail-item" id="thumb-2" onclick="manualSwitch(2)">
                        <img src="{{ asset('images/founders/salah/2.png') }}" alt="Salah Portrait 2">
                    </div>
                    <div class="thumbnail-item" id="thumb-3" onclick="manualSwitch(3)">
                        <img src="{{ asset('images/founders/salah/3.png') }}" alt="Salah Portrait 3">
                    </div>
                    <div class="thumbnail-item" id="thumb-4" onclick="manualSwitch(4)">
                        <img src="{{ asset('images/founders/salah/4.png') }}" alt="Salah Portrait 4">
                    </div>
                    <div class="thumbnail-item" id="thumb-5" onclick="manualSwitch(5)">
                        <img src="{{ asset('images/founders/salah/5.png') }}" alt="Salah Portrait 5">
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">20+</div>
                <div class="stat-title" data-en="Years of Experience" data-ar="عاماً من الخبرة">عاماً من الخبرة</div>
                <div class="stat-desc"
                    data-en="In engineering and high-end real estate construction across Egypt & Gulf"
                    data-ar="في التشييد الهندسي والتطوير العقاري بمصر والخليج">في التشييد الهندسي والتطوير العقاري بمصر
                    والخليج</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">2</div>
                <div class="stat-title" data-en="Regional Markets" data-ar="أسواق إقليمية">أسواق إقليمية</div>
                <div class="stat-desc" data-en="Co-founded major companies in Kuwait and expanded to Egypt"
                    data-ar="تأسيس ودعم قطاع الإنشاء والمقاولات في الكويت ومصر">تأسيس ودعم قطاع الإنشاء والمقاولات في
                    الكويت ومصر</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">15+</div>
                <div class="stat-title" data-en="Executive Positions" data-ar="مبادرات استثمارية">مبادرات استثمارية
                </div>
                <div class="stat-desc" data-en="Leadership roles in Chamber of Commerce and Investment Sec."
                    data-ar="رئاسة أمانة الاستثمار وعضوية الغرفة التجارية للتطوير العقاري">رئاسة أمانة الاستثمار وعضوية
                    الغرفة التجارية للتطوير العقاري</div>
            </div>
        </div>
    </section>

    <footer class="footer-lux">
        <div class="footer-logo">AlBrolosy</div>
        <p>&copy; 2026 Al-Brolosy Real Estate Development. All rights reserved.</p>
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
        // نظام السلايدر المتطور لمعرض الصور (محدث)
        // ==========================================
        let currentImgIndex = 1;
        const totalImages = 5;
        const basePath = "{{ asset('images/founders/salah') }}/";
        let slideInterval;

        // 1. تقنية التحميل المسبق (Preloading) لجميع الصور حتى لا تتأخر أثناء العرض
        const preloadedImages = [];
        for (let i = 1; i <= totalImages; i++) {
            const img = new Image();
            img.src = `${basePath}${i}.png`;
            preloadedImages.push(img);
        }

        function switchPortrait(index) {
            const mainImg = document.getElementById('main-active-img');

            // إعطاء تأثير شفافية سريع قبل تغيير المصدر
            mainImg.style.opacity = '0.4';

            setTimeout(() => {
                // الصور محملة مسبقاً، لذا ستظهر فوراً ولن يظهر نص الـ alt
                mainImg.src = `${basePath}${index}.png`;
                mainImg.style.opacity = '1';
            }, 150);

            // تحديث حالة المصغرات النشطة
            document.querySelectorAll('.thumbnail-item').forEach(item => {
                item.classList.remove('active');
            });

            document.getElementById(`thumb-${index}`).classList.add('active');
            currentImgIndex = index;
        }

        // دالة التغيير التلقائي للصور
        function autoSlide() {
            let nextIndex = currentImgIndex + 1;
            if (nextIndex > totalImages) {
                nextIndex = 1;
            }
            switchPortrait(nextIndex);
        }

        // بدء السلايدر ليتغير كل 4 ثواني
        function startSlider() {
            slideInterval = setInterval(autoSlide, 4000);
        }

        // إيقاف السلايدر
        function stopSlider() {
            clearInterval(slideInterval);
        }

        // في حال ضغط المستخدم على مصغر بنفسه
        function manualSwitch(index) {
            if(index === currentImgIndex) return; // منع إعادة تحميل نفس الصورة إذا تم الضغط عليها مرتين
            stopSlider(); // نوقف التلقائي لحظياً
            switchPortrait(index);
            startSlider(); // نعيد تشغيله من جديد
        }

        // بدء السلايدر عند تحميل الصفحة
        startSlider();

        // إيقاف التغيير التلقائي عند وقوف الماوس على الصور ليتيح للمستخدم التركيز
        const galleryContainer = document.getElementById('gallery-container');
        galleryContainer.addEventListener('mouseenter', stopSlider);
        galleryContainer.addEventListener('mouseleave', startSlider);
    </script>
</body>

</html>
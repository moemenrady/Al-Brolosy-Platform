<style>
    /* ===================================== */
    /* 0. نظام الحركة الموحد (Motion System) */
    /* كل عنصر في الصفحة بيستخدم نفس الإحساس بالحركة */
    /* ===================================== */
    :root {
        /* الكيرف الشارب الموحد لأول 3 ثواني من ظهور أي عنصر */
        --ease-sharp: cubic-bezier(0.16, 1, 0.3, 1);
        /* كيرف للتفاعلات السريعة (ضغط/هوفر) */
        --ease-tactile: cubic-bezier(0.34, 1.56, 0.64, 1);
        /* مدة رد الفعل عند الضغط على أي حاجة قابلة للنقر */
        --dur-tactile: 0.18s;
        /* مدة ظهور العناصر عند التحميل */
        --dur-reveal: 0.9s;
        /* التأخير بين كل عنصر والي بعده في التسلسل */
        --stagger-step: 0.08s;
    }

    /* ===================================== */
    /* 1. إعدادات المتغيرات والثيمات         */
    /* ===================================== */
    :root {
        --primary-red: #B40000;
        --black: #000000;
        --light-gray: #76767A;
        --dark-gray: #696969;
        --warm-beige: #E4DCC7;
        --cream-beige: #E6E0D0;
        --off-white: #F0F0F0;

        /* مسافات متجاوبة بتتحسب تلقائي بين الموبايل والديسكتوب */
        --space-header-y: clamp(1rem, 3vw, 2rem);
        --space-header-x: clamp(1.25rem, 5vw, 5%);
        --space-drawer-pad: clamp(1.25rem, 4vw, 1.5rem);
    }

    /* الوضع الداكن (الافتراضي) */
    html[data-theme="dark"] {
        --bg-main: #000000;
        --bg-secondary: #1a1a1a;
        --text-main: #F0F0F0;
        --text-muted: #76767A;
        --border-color: #333333;
    }

    /* الوضع الفاتح */
    html[data-theme="light"] {
        --bg-main: #F0F0F0;
        --bg-secondary: #ffffff;
        --text-main: #000000;
        --text-muted: #696969;
        --border-color: #cccccc;
    }

    /* إعدادات الشاشة والخطوط */
    html {
        scroll-behavior: smooth;
    }

    html[dir="rtl"] {
        font-family: 'Cairo', 'Tajawal', sans-serif;
    }

    html[dir="ltr"] {
        font-family: 'Helvetica Neue', Arial, sans-serif;
    }

    /* احترام تفضيل تقليل الحركة (Accessibility) */
    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }

    /* ===================================== */
    /* 2. شاشة التحميل (Preloader)           */
    /* ===================================== */
    .loader-overlay {
        position: fixed;
        inset: 0;
        background-color: var(--black);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.8s var(--ease-sharp), visibility 0.8s;
    }

    .brand-logo-box {
        width: clamp(56px, 12vw, 80px);
        height: clamp(56px, 12vw, 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--warm-beige);
        transform: rotate(0deg) scale(1);
    }

    .spin-90 {
        transform: rotate(90deg) scale(0.94);
        transition: transform 1s var(--ease-sharp);
    }

    .spin-360 {
        transform: rotate(360deg) scale(1);
        transition: transform 0.9s var(--ease-sharp);
    }

    /* ===================================== */
    /* 4.1 Albrolosy Brand */
    /* ===================================== */

    .brand-brand {
        display: inline-flex;
        align-items: center;
        gap: clamp(0.45rem, 1vw, 0.75rem);

        color: var(--warm-beige);
        text-decoration: none;

        z-index: 50;
        white-space: nowrap;

        transform-origin: center left;
    }

    /* اللوجو */
    .brand-logo-wrap {
        width: clamp(34px, 3vw, 48px);
        height: clamp(34px, 3vw, 48px);

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        position: relative;

        perspective: 600px;
    }

    /* صورة اللوجو */
    .logo-img {
        width: 100%;
        height: 100%;

        object-fit: contain;

        display: block;

        transform-origin: center center;

        /* حركة بسيطة جدًا */
        animation: logoBreathing 4.5s ease-in-out infinite;

        will-change: transform, filter;

        transition:
            transform 0.5s var(--ease-sharp),
            filter 0.5s ease;
    }

    /* الاسم */
    .brand-name {
        color: var(--warm-beige);

        font-size: clamp(1rem,
                1.2vw + 0.45rem,
                1.45rem);

        font-weight: 700;

        letter-spacing: 1.8px;

        text-transform: uppercase;

        line-height: 1;

        transition:
            color 0.35s ease,
            letter-spacing 0.45s var(--ease-sharp);
    }

    /* Hover على البراند كله */
    .brand-brand:hover .logo-img {
        transform:
            translateY(-2px) rotate(-3deg) scale(1.06);

        filter:
            drop-shadow(0 5px 12px rgba(228, 220, 199, 0.18));
    }

    .brand-brand:hover .brand-name {
        color: var(--off-white);
        letter-spacing: 2.2px;
    }


    /* حركة التنفس الخفيفة للوجو */
    @keyframes logoBreathing {

        0%,
        100% {
            transform: translateY(0) scale(1) rotate(0deg);
        }

        50% {
            transform: translateY(-1px) scale(1.015) rotate(0.5deg);
        }
    }


    /* ===================================== */
    /* RTL */
    /* ===================================== */

    html[dir="rtl"] .brand-brand {
        flex-direction: row;
    }

    html[dir="rtl"] .brand-name {
        text-transform: none;
        letter-spacing: 0;
        font-family: 'Cairo', 'Tajawal', sans-serif;
    }

    html[dir="rtl"] .brand-brand:hover .brand-name {
        letter-spacing: 0;
    }


    /* ===================================== */
    /* Mobile */
    /* ===================================== */

    @media (max-width: 767px) {

        .brand-brand {
            gap: 0.45rem;
        }

        .brand-logo-wrap {
            width: 36px;
            height: 36px;
        }

        .brand-name {
            font-size: 1rem;
            letter-spacing: 1.3px;
        }

        html[dir="rtl"] .brand-name {
            font-size: 1.05rem;
        }
    }


    /* ===================================== */
    /* Small screens */
    /* ===================================== */

    @media (max-width: 380px) {

        .brand-logo-wrap {
            width: 32px;
            height: 32px;
        }

        .brand-name {
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        html[dir="rtl"] .brand-name {
            font-size: 0.95rem;
        }
    }


    /* ===================================== */
    /* Accessibility */
    /* ===================================== */

    @media (prefers-reduced-motion: reduce) {

        .logo-img {
            animation: none;
        }

        .brand-brand:hover .logo-img {
            transform: none;
        }
    }

    /* ===================================== */
    /* 3. قسم الـ Hero والفيديو              */
    /* ===================================== */
    .hero-section {
        position: relative;
        width: 100%;
        height: 100svh;
        /* svh بيمنع مشكلة قفز الفيديو مع شريط الموبايل */
        min-height: 480px;
        background-color: var(--black);
        overflow: hidden;
    }

    .hero-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        transform: scale(1.06);
        transition: opacity 1.4s var(--ease-sharp), transform 1.8s var(--ease-sharp);
        will-change: opacity, transform;
    }

    .hero-video.video-ready {
        opacity: 0.6;
        transform: scale(1);
    }

    /* الفيديو الغير مستخدم يفضل مخفي تمامًا ومش بياخد مساحة تحميل */
    .hero-video.video-inactive {
        display: none;
    }

    .hero-dark-overlay {
        display: none;
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom,
                rgba(0, 0, 0, 0.8) 0%,
                rgba(0, 0, 0, 0.2) 50%,
                rgba(0, 0, 0, 0.8) 100%);
        z-index: 10;
    }

    html.dark .hero-dark-overlay {
        display: block;
    }

    .hero-content-wrapper {
        position: relative;
        z-index: 20;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        opacity: 0;
        transition: opacity 0.6s var(--ease-sharp);
    }

    .hero-content-wrapper.content-visible {
        opacity: 1;
    }

    /* أي عنصر عليه كلاس hero-anim بيدخل بنفس الكيرف الشارب الموحد
       والتأخير بيتحسب أوتوماتيك من --d اللي متحطوطة على كل عنصر */
    .hero-anim {
        opacity: 0;
        transform: translateY(16px);
        transition:
            opacity var(--dur-reveal) var(--ease-sharp),
            transform var(--dur-reveal) var(--ease-sharp);
        transition-delay: calc(var(--d, 0) * var(--stagger-step));
    }

    .content-visible .hero-anim {
        opacity: 1;
        transform: translateY(0);
    }

    /* ===================================== */
    /* 4. الهيدر (Header) والـ Navigation    */
    /* ===================================== */
    .hero-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-header-y) var(--space-header-x);
        background-color: transparent;
        gap: clamp(0.5rem, 2vw, 1rem);
    }

    .brand-name {
        color: var(--warm-beige);
        font-size: clamp(1.05rem, 1.6vw + 0.6rem, 1.5rem);
        font-weight: bold;
        letter-spacing: 2px;
        text-transform: uppercase;
        text-decoration: none;
        z-index: 50;
        white-space: nowrap;
    }

    .hero-nav {
        display: none;
        gap: clamp(1.25rem, 2vw, 2rem);
    }

    @media (min-width: 1024px) {
        .hero-nav {
            display: flex;
        }
    }

    .nav-link {
        position: relative;
        color: var(--off-white);
        text-decoration: none;
        font-size: 0.9rem;
        letter-spacing: 1px;
        white-space: nowrap;
        padding: 0.35rem 0;
        transition: color 0.3s ease;
    }

    /* خط سفلي احترافي بيتحرك بنفس كيرف التاتش عند الهوفر/الضغط */
    .nav-link::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        height: 1.5px;
        width: 0;
        background: var(--primary-red);
        transition: width var(--dur-tactile) var(--ease-tactile);
    }

    .nav-link:hover {
        color: var(--primary-red);
    }

    .nav-link:hover::after,
    .nav-link:focus-visible::after {
        width: 100%;
    }

    /* ===================================== */
    /* 5. الأزرار والأيقونات في الهيدر       */
    /* ===================================== */
    .hero-actions {
        display: flex;
        align-items: center;
        gap: clamp(0.75rem, 2vw, 1.2rem);
    }

    /* ===================================== */
    /* 5.1 نظام رد الفعل الموحد عند الضغط     */
    /* كل حاجة تقدر تدوس عليها بتستخدم نفس الإحساس */
    /* ===================================== */
    .btn-tactile,
    .btn-consultation,
    .nav-link,
    .drawer-link,
    .drawer-btn {
        transition:
            transform var(--dur-tactile) var(--ease-tactile),
            color 0.3s ease,
            background-color 0.3s ease,
            border-color 0.3s ease,
            opacity 0.3s ease;
        -webkit-tap-highlight-color: transparent;
    }

    .btn-tactile:hover,
    .btn-consultation:hover,
    .drawer-btn:hover {
        transform: translateY(-1px);
    }

    .btn-tactile:active,
    .btn-consultation:active,
    .drawer-btn:active,
    .nav-link:active,
    .drawer-link:active {
        transform: scale(0.94);
    }

    /* حلقة فوكس واضحة لتصفح الكيبورد (Accessibility) */
    .btn-tactile:focus-visible,
    .btn-consultation:focus-visible,
    .nav-link:focus-visible,
    .drawer-link:focus-visible,
    .drawer-btn:focus-visible {
        outline: 2px solid var(--primary-red);
        outline-offset: 3px;
        border-radius: 2px;
    }

    .btn-consultation {
        border: 1px solid var(--primary-red);
        color: var(--warm-beige);
        padding: 0.5rem 1.5rem;
        text-decoration: none;
        display: none;
        min-height: 44px;
        align-items: center;
    }

    @media (min-width: 768px) {
        .btn-consultation {
            display: inline-flex;
        }
    }

    .btn-consultation:hover {
        background-color: var(--primary-red);
        color: var(--off-white);
    }

    .lang-switch-btn {
        background: none;
        border: none;
        color: var(--off-white);
        cursor: pointer;
        display: flex;
        gap: 0.3rem;
        font-size: 0.9rem;
        padding: 0.4rem;
        min-height: 44px;
        min-width: 44px;
        align-items: center;
        justify-content: center;
    }

    .lang-switch-btn:hover {
        color: var(--primary-red);
    }

    .lang-switch-btn .active {
        color: var(--warm-beige);
        font-weight: bold;
    }

    .hero-icons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .hero-icon {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.5rem;
        min-width: 44px;
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .hero-icon:hover {
        background-color: rgba(255, 255, 255, 0.08);
    }

    .icon-svg {
        width: 22px;
        height: 22px;
        fill: var(--off-white);
        stroke: var(--off-white);
        transition: all 0.3s;
        flex-shrink: 0;
    }

    .hero-icon:hover .icon-svg {
        fill: var(--primary-red);
        stroke: var(--primary-red);
    }

    /* زر الـ Hamburger (يظهر في الموبايل فقط) */
    .mobile-menu-btn {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 26px;
        height: 18px;
        padding: 0;
        min-width: 44px;
        min-height: 44px;
        align-items: center;
        background: transparent;
        border: none;
        cursor: pointer;
        z-index: 50;
        position: relative;
    }

    .mobile-menu-btn span {
        display: block;
        position: absolute;
        left: 9px;
        height: 2px;
        width: 26px;
        border-radius: 2px;
        background-color: var(--off-white);
        transition: transform var(--dur-tactile) var(--ease-tactile),
            opacity var(--dur-tactile) ease;
    }

    .mobile-menu-btn span:nth-child(1) {
        top: 14px;
    }

    .mobile-menu-btn span:nth-child(2) {
        top: 22px;
    }

    .mobile-menu-btn span:nth-child(3) {
        top: 30px;
    }

    @media (min-width: 1024px) {
        .mobile-menu-btn {
            display: none;
        }
    }

    /* ===================================== */
    /* 6. الموبايل دراور (Mobile Drawer)     */
    /* ===================================== */
    .drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s var(--ease-sharp), visibility 0.4s;
    }

    .drawer-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .mobile-drawer {
        position: fixed;
        top: 0;
        right: 0;

        width: min(320px, 85vw);
        height: 100dvh;
        /* dvh بيمنع قفز ارتفاع الدراور مع شريط الموبايل */

        background: var(--bg-main);
        color: var(--text-main);

        z-index: 9999;

        display: flex;
        flex-direction: column;

        box-shadow: 0 0 25px rgba(0, 0, 0, .5);

        transform: translateX(100%);
        will-change: transform;

        transition: transform 0.45s var(--ease-sharp);
    }

    .mobile-drawer.open {
        transform: translateX(0);
    }

    html[dir="rtl"] .mobile-drawer {
        right: auto;
        left: 0;
        transform: translateX(-100%);
    }

    html[dir="rtl"] .mobile-drawer.open {
        transform: translateX(0);
    }

    .mobile-menu-btn.active span:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
    }

    .mobile-menu-btn.active span:nth-child(2) {
        opacity: 0;
        transform: scaleX(0);
    }

    .mobile-menu-btn.active span:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
    }

    .mobile-drawer,
    .drawer-overlay {
        display: none;
    }

    @media (max-width: 1023px) {

        .mobile-drawer {
            display: flex;
        }

        .drawer-overlay {
            display: block;
        }
    }

    .drawer-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-drawer-pad);
        border-bottom: 1px solid var(--border-color);
        flex-shrink: 0;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 2rem;
        line-height: 1;
        color: var(--text-main);
        cursor: pointer;
        min-width: 44px;
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .close-btn:hover {
        color: var(--primary-red);
        background-color: rgba(180, 0, 0, 0.08);
    }

    .drawer-body {
        padding: var(--space-drawer-pad);
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .drawer-nav {
        display: flex;
        flex-direction: column;
        gap: clamp(1rem, 3vh, 1.5rem);
    }

    .drawer-nav a {
        color: var(--text-main);
        text-decoration: none;
        font-size: clamp(1.05rem, 3vw, 1.2rem);
        font-weight: 500;
        min-height: 44px;
        display: flex;
        align-items: center;
    }

    .drawer-nav a:hover {
        color: var(--primary-red);
    }

    .drawer-divider {
        border: 0;
        border-top: 1px solid var(--border-color);
        margin: 1.5rem 0;
    }

    .drawer-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0.8rem;
        margin-bottom: 0.8rem;
        min-height: 44px;
        border: 1px solid var(--primary-red);
        color: var(--primary-red);
        text-decoration: none;
        border-radius: 4px;
    }

    .drawer-btn:hover {
        background: var(--primary-red);
        color: #fff;
    }

    /* ===================================== */
    /* 7. مؤشر التمرير (Scroll cue)          */
    /* ===================================== */
    .scroll-cue {
        display: none;
        justify-content: center;
        padding-bottom: clamp(1.25rem, 4vh, 2.5rem);
    }

    @media (min-width: 640px) {
        .scroll-cue {
            display: flex;
        }
    }

    .scroll-cue-line {
        width: 1px;
        height: 42px;
        background: linear-gradient(to bottom, var(--warm-beige), transparent);
        position: relative;
        overflow: hidden;
    }

    .scroll-cue-line::after {
        content: "";
        position: absolute;
        top: -100%;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, transparent, var(--primary-red), transparent);
        animation: scrollPulse 2.2s var(--ease-sharp) infinite;
    }

    @keyframes scrollPulse {
        0% {
            top: -100%;
        }

        60%,
        100% {
            top: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .scroll-cue-line::after {
            animation: none;
        }
    }

    /* ===================================== */
    /* 8. أدوات إخفاء وإظهار الميديا         */
    /* ===================================== */
    .hide-mobile {
        display: none;
    }

    .show-mobile {
        display: block;
    }

    @media (min-width: 768px) {
        .hide-mobile {
            display: block;
        }

        .show-mobile {
            display: none;
        }
    }

    /* ===================================== */
    /* 9. ضبط دقيق لأحجام الشاشات الصغيرة جدًا */
    /* ===================================== */
    @media (max-width: 380px) {
        .hero-actions {
            gap: 0.5rem;
        }

        .hero-icons {
            gap: 0.15rem;
        }
    }

    /* شاشات كبيرة جدًا: منع تمدد المحتوى بلا حدود */
    @media (min-width: 1600px) {
        .hero-header {
            padding-left: max(5%, calc((100vw - 1536px) / 2 + 2rem));
            padding-right: max(5%, calc((100vw - 1536px) / 2 + 2rem));
        }
    }
</style>

<!-- شاشة التحميل -->
<div id="premium-loader" class="loader-overlay">
    <div class="loader-content">
        <div id="loader-logo" class="brand-logo-box">
            <img src="{{ asset('albrolosy_logo.png') }}" alt="Albrolosy Logo" class="logo-img" style="max-width: 100%;">
        </div>
    </div>
</div>

<section class="hero-section" id="main">

    <!--
        الفيديوهات: مفيش تحميل تلقائي هنا خالص.
        الـ src بتتحط ديناميكياً بالـ JS على حسب حجم الشاشة الفعلي،
        عشان الموبايل ميحملش فيديو الديسكتوب والعكس.
    -->
    <video id="d_hero-video" class="hero-video" muted loop playsinline preload="none"
        poster="{{ asset('images/d_hero-poster.webp') }}" data-src="{{ asset('videos/d_hero.mp4') }}">
    </video>
    <video id="m_hero-video" class="hero-video" muted loop playsinline preload="none"
        poster="{{ asset('images/m_hero-poster.webp') }}" data-src="{{ asset('videos/m_hero.mp4') }}">
    </video>

    <!-- طبقة التعتيم السينمائي -->
    <div class="hero-dark-overlay"></div>

    <!-- محتوى الـ Hero -->
    <div id="hero-content" class="hero-content-wrapper">

        <!-- الهيدر والناف بار -->
        <header class="hero-header">
            <a href="/" class="brand-brand hero-anim" style="--d:0" aria-label="Albrolosy">

                <span class="brand-logo-wrap">
                    <img src="{{ asset('albrolosy_logo.png') }}" alt="Albrolosy Logo" class="logo-img">
                </span>


                <span class="brand-name" data-en="Albrolosy" data-ar="البرلسي">
                    Albrolosy
                </span>

            </a>
            <!-- ناف بار الديسكتوب -->
            <nav class="hero-nav">

                <a href="#main" class="nav-link hero-anim" style="--d:1" data-en="Main" data-ar="الرئيسية">
                    الرئيسية
                </a>

                <a href="#sectors" class="nav-link hero-anim" style="--d:2" data-en="Sectors" data-ar="القطاعات">
                    القطاعات
                </a>

                <a href="#luxury-projects-grid" class="nav-link hero-anim" style="--d:3" data-en="Projects"
                    data-ar="المشاريع">
                    المشاريع
                </a>

                <a href="#about-us" class="nav-link hero-anim" style="--d:4" data-en="About Us" data-ar="من نحن">
                    من نحن
                </a>

                <a href="#join-team" class="nav-link hero-anim" style="--d:5" data-en="Join Our Team"
                    data-ar="انضم لفريقنا">
                    انضم لفريقنا
                </a>

            </nav>

            <div class="hero-actions hero-anim" style="--d:2">
                <a href="#consultation" class="btn-consultation btn-tactile">
                    <span data-en="Consultation" data-ar="طلب استشارة">
                        طلب استشارة
                    </span>
                </a>

                <button id="theme-switcher" class="hero-icon btn-tactile hide-mobile" type="button"
                    title="Toggle Theme">
                    <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <button id="lang-switcher" class="lang-switch-btn btn-tactile hide-mobile" type="button">
                    <span class="lang-en">EN</span>
                    <span class="lang-separator">/</span>
                    <span class="lang-ar">AR</span>
                </button>

                <div class="hero-icons">
                    <button class="hero-icon btn-tactile" id="search-toggle" title="Search">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                    <a href="{{ route('profile') }}" class="hero-icon btn-tactile" title="Profile">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </a>
                </div>

                <button id="mobile-menu-btn" class="mobile-menu-btn btn-tactile">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </header>

        <!-- مؤشر التمرير (Scroll indicator) -->
        <div class="scroll-cue hero-anim" style="--d:6" aria-hidden="true">
            <span class="scroll-cue-line"></span>
        </div>
    </div>
</section>

<!-- ===================================== -->
<!-- القائمة الجانبية (Mobile Drawer)      -->
<!-- ===================================== -->
<div id="drawer-overlay" class="drawer-overlay"></div>
<aside id="mobile-drawer" class="mobile-drawer">
    <div class="drawer-header-content">
        <a href="/" class="brand-name" style="color: var(--text-main);" data-en="Albrolosy"
            data-ar="البرلسي">Albrolosy</a>
        <button id="close-drawer" class="close-btn btn-tactile" aria-label="Close menu">&times;</button>
    </div>

    <div class="drawer-body">
        <nav class="drawer-nav">
            <a href="#main" class="drawer-link" data-en="Main" data-ar="الرئيسية">Main</a>
            <a href="#sectors" class="drawer-link" data-en="Sectors" data-ar="القطاعات">Sectors</a>
            <a href="#projects" class="drawer-link" data-en="Projects" data-ar="المشاريع">Projects</a>
            <a href="#about-us" class="drawer-link" data-en="About Us" data-ar="من نحن">About Us</a>
            <a href="#join-team" class="drawer-link" data-en="Join Our Team" data-ar="انضم لفريقنا">Join Our
                Team</a>
        </nav>

        <hr class="drawer-divider">

        <!-- الإجراءات داخل الدراور للموبايل -->
        <a href="#consultation" class="drawer-btn btn-tactile" data-en="Consultation"
            data-ar="طلب استشارة">Consultation</a>

        <div style="display: flex; justify-content: space-around; margin-top: 1rem;">
            <button id="lang-switcher" class="lang-switch-btn btn-tactile" type="button">
                <span class="lang-en">EN</span>
                <span class="lang-separator">/</span>
                <span class="lang-ar">AR</span>
            </button>

            <button id="theme-switcher-mobile" class="hero-icon btn-tactile" style="color: var(--text-main);">
                <svg class="icon-svg" style="fill: var(--text-main); stroke: var(--text-main);" viewBox="0 0 24 24">
                    <path
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        fill="none" />
                </svg>
            </button>
        </div>
    </div>
</aside>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        ["lang-switcher", "lang-switcher-mobile"].forEach((id) => {
            document.getElementById(id)?.addEventListener("click", () => {
                window.preferences?.toggleLanguage();
            });
        });

        ["theme-switcher", "theme-switcher-mobile"].forEach((id) => {
            document.getElementById(id)?.addEventListener("click", () => {
                window.preferences?.toggleTheme();
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // ==========================================
        // 1. تحديد نوع الجهاز وتحميل الفيديو المناسب فقط
        //    (الفيديو التاني مايتحملش نهائي - ولا poster ولا src)
        // ==========================================
        const loader = document.getElementById("premium-loader");
        const logo = document.getElementById("loader-logo");
        const videoDesktop = document.getElementById("d_hero-video");
        const videoMobile = document.getElementById("m_hero-video");
        const heroContent = document.getElementById("hero-content");

        const MOBILE_BREAKPOINT = 768;
        let currentMode = null; // 'mobile' | 'desktop'
        let hasFirstLoadCompleted = false;

        function getMode() {
            return window.innerWidth < MOBILE_BREAKPOINT ? "mobile" : "desktop";
        }

        function activateVideo(mode) {
            const active = mode === "mobile" ? videoMobile : videoDesktop;
            const inactive = mode === "mobile" ? videoDesktop : videoMobile;

            // الفيديو الغير مستخدم: نوقفه ونشيل الـ src بتاعه بالكامل
            // عشان المتصفح ميحملوش حتى لو كان جوه الـ DOM
            inactive.pause();
            inactive.removeAttribute("src");
            inactive.querySelectorAll("source").forEach(s => s.removeAttribute("src"));
            inactive.load();
            inactive.classList.add("video-inactive");
            inactive.classList.remove("video-ready");

            // الفيديو المستخدم: نحط الـ src بتاعه بس لو لسه معندوش
            if (!active.dataset.loaded) {
                active.src = active.dataset.src;
                active.dataset.loaded = "true";
            }
            active.classList.remove("video-inactive");
            return active;
        }

        function waitForVideoReady(video) {
            return new Promise((resolve) => {
                if (video.readyState >= 3) {
                    resolve();
                    return;
                }
                const onReady = () => {
                    video.removeEventListener("canplaythrough", onReady);
                    resolve();
                };
                video.addEventListener("canplaythrough", onReady, { once: true });
                // Fallback عشان لو الفيديو اتأخر أو فشل، الصفحة متفضلش واقفة
                setTimeout(resolve, 3000);
            });
        }

        currentMode = getMode();
        const initialVideo = activateVideo(currentMode);
        initialVideo.load();

        // بدء حركة اللوجو
        requestAnimationFrame(() => {
            logo.classList.add("spin-90");
        });

        waitForVideoReady(initialVideo).then(() => {
            logo.classList.remove("spin-90");
            logo.classList.add("spin-360");

            setTimeout(() => {
                loader.style.opacity = "0";
                setTimeout(() => {
                    loader.style.visibility = "hidden";
                    initialVideo.classList.add("video-ready");
                    initialVideo.play().catch(e => console.log("Autoplay prevented:", e));
                    heroContent.classList.add("content-visible");
                    hasFirstLoadCompleted = true;
                }, 700);
            }, 850);
        });

        // ==========================================
        // 2. إعادة التبديل بين فيديو الموبايل والديسكتوب
        //    لو المستخدم لف الجهاز أو غيّر حجم الشاشة عبر البريكبوينت
        //    (مع debounce عشان ميحصلش تحميل زيادة وقت الـ resize)
        // ==========================================
        let resizeTimer = null;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                const newMode = getMode();
                if (newMode === currentMode || !hasFirstLoadCompleted) return;

                currentMode = newMode;
                const newActive = activateVideo(currentMode);

                if (newActive.dataset.loaded === "true" && newActive.readyState >= 3) {
                    newActive.classList.add("video-ready");
                    newActive.play().catch(() => {});
                } else {
                    newActive.load();
                    waitForVideoReady(newActive).then(() => {
                        newActive.classList.add("video-ready");
                        newActive.play().catch(() => {});
                    });
                }
            }, 350);
        });

        // ==========================================
        // 3. Smooth Scrolling والتمرير السلس
        // ==========================================
        document.querySelectorAll('.nav-link, .drawer-link, .btn-consultation, .drawer-btn').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href.startsWith('#')) {
                    e.preventDefault();
                    const targetElement = document.getElementById(href.substring(1));
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                    // إغلاق الدراور إذا كان مفتوحاً
                    if (drawer.classList.contains('open')) {
                        closeDrawer();
                    }
                }
            });
        });

        // ==========================================
        // 4. Mobile Drawer Logic (هيكل القائمة الجانبية)
        // ==========================================
        const menuBtn = document.getElementById('mobile-menu-btn');
        const closeBtn = document.getElementById('close-drawer');
        const drawer = document.getElementById('mobile-drawer');
        const overlay = document.getElementById('drawer-overlay');

        function openDrawer() {
            drawer.classList.add('open');
            overlay.classList.add('active');
            menuBtn.classList.add('active');
            menuBtn.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            drawer.classList.remove('open');
            overlay.classList.remove('active');
            menuBtn.classList.remove('active');
            menuBtn.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        menuBtn?.addEventListener('click', () => {
            drawer.classList.contains('open') ? closeDrawer() : openDrawer();
        });
        closeBtn?.addEventListener('click', closeDrawer);
        overlay?.addEventListener('click', closeDrawer);

        // إغلاق بزرار Escape (Accessibility)
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && drawer.classList.contains('open')) {
                closeDrawer();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeDrawer();
            }
        });
    });
</script>

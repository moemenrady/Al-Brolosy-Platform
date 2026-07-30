<style>
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
        transition: opacity 1s ease-in-out, visibility 1s;
    }

    .brand-logo-box {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--warm-beige);
        transform: rotate(0deg);
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
    /* 3. قسم الـ Hero والفيديو              */
    /* ===================================== */
    .hero-section {
        position: relative;
        width: 100%;
        height: 100vh;
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
        transition: opacity 1.5s ease;
    }

    .hero-video.video-ready {
        opacity: 0.6;
    }

    .hero-dark-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.2) 50%, rgba(0, 0, 0, 0.8) 100%);
        z-index: 10;
    }

    .hero-content-wrapper {
        position: relative;
        z-index: 20;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        opacity: 0;
        transform: translateY(30px);
        transition: all 1.2s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .hero-content-wrapper.content-visible {
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
        padding: 2rem 5%;
        background-color: transparent;
        /* ليكون شفاف فوق الفيديو */
    }

    .brand-name {
        color: var(--warm-beige);
        font-size: 1.5rem;
        font-weight: bold;
        letter-spacing: 2px;
        text-transform: uppercase;
        text-decoration: none;
        z-index: 50;
    }

    .hero-nav {
        display: none;
        gap: 2rem;
    }

    @media (min-width: 1024px) {
        .hero-nav {
            display: flex;
        }
    }

    .nav-link {
        color: var(--off-white);
        text-decoration: none;
        font-size: 0.9rem;
        letter-spacing: 1px;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: var(--primary-red);
    }

    /* ===================================== */
    /* 5. الأزرار والأيقونات في الهيدر       */
    /* ===================================== */
    .hero-actions {
        display: flex;
        align-items: center;
        gap: 1.2rem;
    }

    .btn-consultation {
        border: 1px solid var(--primary-red);
        color: var(--warm-beige);
        padding: 0.5rem 1.5rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: none;
    }

    @media (min-width: 768px) {
        .btn-consultation {
            display: block;
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
        transition: color 0.3s;
        padding: 0;
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
        gap: 1rem;
        align-items: center;
    }

    .hero-icon {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .icon-svg {
        width: 22px;
        height: 22px;
        fill: var(--off-white);
        stroke: var(--off-white);
        transition: all 0.3s;
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
        width: 30px;
        height: 20px;
        background: transparent;
        border: none;
        cursor: pointer;
        z-index: 50;
    }

    .mobile-menu-btn span {
        display: block;
        height: 2px;
        width: 100%;
        background-color: var(--off-white);
        transition: all 0.3s ease;
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
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s ease;
    }

    .drawer-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .mobile-drawer {
        position: fixed;
        top: 0;
        right: 0;

        width: 320px;
        max-width: 85vw;
        height: 100vh;

        background: var(--bg-main);
        color: var(--text-main);

        z-index: 9999;

        display: flex;
        flex-direction: column;

        box-shadow: 0 0 25px rgba(0, 0, 0, .5);

        transform: translateX(100%);
        will-change: transform;

        transition: transform .35s ease;
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
        transform: translateY(9px) rotate(45deg);
    }

    .mobile-menu-btn.active span:nth-child(2) {
        opacity: 0;
    }

    .mobile-menu-btn.active span:nth-child(3) {
        transform: translateY(-9px) rotate(-45deg);
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
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 2rem;
        color: var(--text-main);
        cursor: pointer;
        transition: color 0.3s;
    }

    .close-btn:hover {
        color: var(--primary-red);
    }

    .drawer-body {
        padding: 1.5rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .drawer-nav {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .drawer-nav a {
        color: var(--text-main);
        text-decoration: none;
        font-size: 1.2rem;
        font-weight: 500;
        transition: color 0.3s;
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
        display: block;
        text-align: center;
        padding: 0.8rem;
        margin-bottom: 0.8rem;
        border: 1px solid var(--primary-red);
        color: var(--primary-red);
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .drawer-btn:hover {
        background: var(--primary-red);
        color: #fff;
    }

    /* ===================================== */
    /* 7. أدوات إخفاء وإظهار الميديا         */
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
</style>

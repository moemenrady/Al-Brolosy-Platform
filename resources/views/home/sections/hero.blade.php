@include('home.styles.hero')
<!-- شاشة التحميل -->
<div id="premium-loader" class="loader-overlay">
    <div class="loader-content">
        <div id="loader-logo" class="brand-logo-box">
            <img src="{{ asset('albrolosy_logo.png') }}" alt="Albrolosy Logo" class="logo-img" style="max-width: 100%;">
        </div>
    </div>
</div>

<section class="hero-section" id="main">
    <!-- خلفية الفيديو -->
    <video id="hero-video-desktop" src="{{ asset('home/base_video_desktop.mp4') }}" class="hero-video hide-mobile" muted
        loop playsinline></video>
    <video id="hero-video-mobile" src="{{ asset('home/base_video_mobile.mp4') }}" class="hero-video show-mobile" muted
        loop playsinline></video>

    <!-- طبقة التعتيم السينمائي -->
    <div class="hero-dark-overlay"></div>

    <!-- محتوى الـ Hero -->
    <div id="hero-content" class="hero-content-wrapper">

        <!-- الهيدر والناف بار -->
        <header class="hero-header">
            <a href="/" class="brand-name">Albrolosy</a>

            <!-- ناف بار الديسكتوب -->
            <nav class="hero-nav">
                <a href="#main" class="nav-link" data-en="Main" data-ar="الرئيسية">Main</a>
                <a href="#sectors" class="nav-link" data-en="Sectors" data-ar="القطاعات">Sectors</a>
                <a href="#luxury-projects-grid" class="nav-link" data-en="Projects" data-ar="المشاريع">Projects</a>
                <a href="#about-us" class="nav-link" data-en="About Us" data-ar="من نحن">About Us</a>
                <a href="#join-team" class="nav-link" data-en="Join Our Team" data-ar="انضم لفريقنا">Join Our Team</a>
            </nav>

            <div class="hero-actions">
                <a href="#consultation" class="btn-consultation">
                    <span data-en="Consultation" data-ar="طلب استشارة">Consultation</span>
                </a>

                <button id="theme-switcher" class="hero-icon hide-mobile" type="button" title="Toggle Theme"
                    style="margin-left: 10px; margin-right: 10px;">
                    <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <button id="lang-switcher" class="lang-switch-btn hide-mobile" type="button">
                    <span class="lang-en">EN</span>
                    <span class="lang-separator">/</span>
                    <span class="lang-ar">AR</span>
                </button>

                <div class="hero-icons">
                    <button class="hero-icon" id="search-toggle" title="Search">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                    <a href="{{ route('profile') }}" class="hero-icon" title="Profile">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </a>
                </div>

                <button id="mobile-menu-btn" class="mobile-menu-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </header>
    </div>
</section>

<!-- ===================================== -->
<!-- القائمة الجانبية (Mobile Drawer)      -->
<!-- ===================================== -->
<div id="drawer-overlay" class="drawer-overlay"></div>
<aside id="mobile-drawer" class="mobile-drawer">
    <div class="drawer-header-content">
        <a href="/" class="brand-name" style="color: var(--text-main);">Albrolosy</a>
        <button id="close-drawer" class="close-btn">&times;</button>
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
        <a href="#consultation" class="drawer-btn" data-en="Consultation" data-ar="طلب استشارة">Consultation</a>

        <div style="display: flex; justify-content: space-around; margin-top: 1rem;">
            <button id="lang-switcher-mobile" class="lang-switch-btn" style="color: var(--text-main);">
                <span class="lang-en active">En</span>
                <span class="lang-separator">/</span>
                <span class="lang-ar active">Ar</span>
            </button>

            <button id="theme-switcher-mobile" class="hero-icon" style="color: var(--text-main);">
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
@include('home.scripts.hero')

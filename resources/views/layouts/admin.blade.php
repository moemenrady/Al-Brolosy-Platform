<!DOCTYPE html>
<html lang="ar" data-theme="dark" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البرلسي - لوحة الإدارة</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ===================================== */
        /* 1. إعدادات المتغيرات (Theme Variables) */
        /* ===================================== */
        :root {
            /* ألوان الهوية الأساسية */
            --primary-red: #B40000;
            --gold: #d7b64a;
            --warm-beige: #E4DCC7;

            /* لون مخصص للأدمن */
            --admin-accent: #0F172A;
            --admin-hover: #1E293B;

            /* قياسات مرنة */
            --sidebar-width: 280px;
            --topbar-height: clamp(70px, 8vw, 80px);
            --transition-speed: 0.3s;
            --content-padding: clamp(1rem, 3vw, 2.5rem);
        }

        html[data-theme="dark"] {
            --bg-main: #050505;
            --bg-sidebar: #0A0A0A;
            --bg-card: #141414;
            --text-main: #F0F0F0;
            --text-muted: #8E8E93;
            --glass-border: rgba(228, 220, 199, 0.1);
        }

        html[data-theme="light"] {
            --bg-main: #F4F6F9;
            --bg-sidebar: #FFFFFF;
            --bg-card: #FFFFFF;
            --text-main: #1A1A1A;
            --text-muted: #666666;
            --glass-border: rgba(0, 0, 0, 0.1);
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
            display: flex;
            font-family: 'Cairo', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* تخصيص السكرول بار */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-main);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--glass-border);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold);
        }

        /* ===================================== */
        /* 2. القائمة الجانبية (Sidebar)         */
        /* ===================================== */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--bg-sidebar);
            border-left: 1px solid var(--glass-border);
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 1050;
            transition: transform var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--glass-border);
            padding: 0 1.5rem;
            background: linear-gradient(to left, rgba(180, 0, 0, 0.05), rgba(212, 175, 55, 0.05));
            flex-shrink: 0;
        }

        .brand-logo {
            color: var(--gold);
            font-size: clamp(1.2rem, 2vw, 1.4rem);
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-menu {
            padding: 1.5rem 1rem;
            list-style: none;
            flex: 1;
            overflow-y: auto;
        }

        .menu-item {
            margin-bottom: 0.4rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.85rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s ease;
            font-weight: 500;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .menu-link:hover,
        .menu-item.active > .menu-link {
            background-color: var(--admin-hover);
            color: var(--text-main);
        }

        .menu-item.active > .menu-link {
            border-right: 4px solid var(--primary-red);
            border-radius: 10px 0 0 10px; /* تعديل الزوايا مع البوردر */
        }

        .menu-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-icon {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
            transition: transform 0.2s;
        }

        .menu-link:hover .menu-icon {
            transform: scale(1.1);
            color: var(--gold);
        }

        .arrow-icon {
            font-size: 0.75rem;
            transition: transform 0.3s ease;
        }

        /* القوائم الفرعية */
        .submenu {
            list-style: none;
            padding-right: 2.8rem;
            padding-left: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0, 1, 0, 1);
        }

        .menu-item.open .submenu {
            max-height: 1000px;
            transition: max-height 0.6s ease-in-out;
            margin-top: 0.2rem;
            margin-bottom: 0.5rem;
        }

        .submenu-link {
            display: block;
            padding: 0.6rem 0;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
            position: relative;
        }

        .submenu-link::before {
            content: '';
            position: absolute;
            right: -18px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--glass-border);
            transition: background-color 0.3s, transform 0.3s;
        }

        .submenu-link:hover,
        .submenu-link.active {
            color: var(--gold);
        }

        .submenu-link:hover::before,
        .submenu-link.active::before {
            background-color: var(--gold);
            transform: translateY(-50%) scale(1.2);
        }

        .smart-card-feature {
            color: var(--gold) !important;
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
            font-weight: 600;
        }

        .smart-card-feature::before {
            background-color: var(--gold) !important;
            box-shadow: 0 0 8px var(--gold);
        }

        .menu-divider {
            height: 1px;
            background-color: var(--glass-border);
            margin: 1.2rem 0;
        }

        /* ===================================== */
        /* 3. الهيكل الرئيسي والبار العلوي       */
        /* ===================================== */
        .main-wrapper {
            flex: 1;
            margin-right: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin var(--transition-speed) ease;
            width: calc(100% - var(--sidebar-width));
        }

        .topbar {
            height: var(--topbar-height);
            background: rgba(var(--bg-main-rgb), 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 clamp(1rem, 3vw, 2rem);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .topbar-right,
        .topbar-left {
            display: flex;
            align-items: center;
            gap: clamp(0.8rem, 2vw, 1.5rem);
        }

        .toggle-sidebar-btn {
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 1.5rem;
            cursor: pointer;
            display: none;
            padding: 0.5rem;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .toggle-sidebar-btn:hover {
            background: var(--admin-hover);
        }

        .topbar-title {
            margin: 0;
            font-size: clamp(1.1rem, 2.5vw, 1.3rem);
            font-weight: 600;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--admin-accent);
            padding: 0.4rem 1rem;
            border-radius: 30px;
            border: 1px solid rgba(212, 175, 55, 0.2);
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s;
        }

        .admin-profile:hover {
            background: var(--admin-hover);
            border-color: var(--gold);
        }

        .admin-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .admin-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .admin-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--gold);
        }

        .admin-role {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .theme-switcher-btn {
            background: none;
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            cursor: pointer;
            font-size: 1.1rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .theme-switcher-btn:hover {
            background: var(--admin-hover);
            border-color: var(--gold);
            color: var(--gold);
        }

        /* ===================================== */
        /* 4. منطقة المحتوى (Content Area)       */
        /* ===================================== */
        .content-area {
            padding: var(--content-padding);
            flex: 1;
        }

        /* ===================================== */
        /* 5. التصميم المتجاوب (Responsive)      */
        /* ===================================== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(100%); /* إخفاء لليمين في اللغة العربية */
            }

            .sidebar.active {
                transform: translateX(0);
                box-shadow: -5px 0 25px rgba(0,0,0,0.5);
            }

            .main-wrapper {
                margin-right: 0;
                width: 100%;
            }

            .toggle-sidebar-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .admin-info {
                display: none; /* إخفاء نصوص البروفايل لتوفير مساحة */
            }
            
            .admin-profile {
                padding: 0.3rem; /* تصغير الزر ليناسب الصورة فقط */
            }
            
            .topbar-title {
                display: none; /* إخفاء العنوان في الشاشات الصغيرة جداً */
            }
        }

        /* خلفية ضبابية عند فتح القائمة في الموبايل */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: opacity var(--transition-speed), visibility var(--transition-speed);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>

<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="brand-logo">
                <i class="fa-solid fa-building-shield" style="color:var(--primary-red);"></i>
                <span>إدارة البرلسي</span>
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                    <div class="menu-title">
                        <i class="fa-solid fa-chart-pie menu-icon"></i>
                        <span>لوحة القيادة</span>
                    </div>
                </a>
            </li>

            <div class="menu-divider"></div>

            <li class="menu-item has-submenu {{ request()->routeIs('admin.projects.*', 'admin.units.*', 'admin.sectors.*', 'admin.payment-plans.*') ? 'open active' : '' }}">
                <div class="menu-link">
                    <div class="menu-title">
                        <i class="fa-solid fa-city menu-icon"></i>
                        <span>المشاريع العقارية</span>
                    </div>
                    <i class="fa-solid fa-chevron-down arrow-icon"></i>
                </div>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.projects.index') }}" class="submenu-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                            جميع المشاريع
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.units.index') }}" class="submenu-link {{ request()->routeIs('admin.units.*') ? 'active' : '' }}">
                            الوحدات العقارية
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.sectors.index') }}" class="submenu-link {{ request()->routeIs('admin.sectors.*') ? 'active' : '' }}">
                            القطاعات
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.payment-plans.index') }}" class="submenu-link {{ request()->routeIs('admin.payment-plans.*') ? 'active' : '' }}">
                            خطط السداد والدفع
                        </a>
                    </li>
                </ul>
            </li>

            <div class="menu-divider"></div>

            <li class="menu-item has-submenu {{ request()->routeIs('admin.clients.*', 'admin.leads.*', 'admin.customers.*', 'admin.consultations.*', 'admin.concierge-steps.*', 'admin.smart-cards*') ? 'open active' : '' }}">
                <div class="menu-link">
                    <div class="menu-title">
                        <i class="fa-solid fa-users-gear menu-icon"></i>
                        <span>إدارة العملاء (CRM)</span>
                    </div>
                    <i class="fa-solid fa-chevron-down arrow-icon"></i>
                </div>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.leads.index') }}" class="submenu-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
                            العملاء المحتملين (Leads)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.concierge-steps.index') }}" class="submenu-link {{ request()->routeIs('admin.concierge-steps.*') ? 'active' : '' }}">
                            المستشار الذكي (الأسئلة والتابات) ✦
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.clients.index') }}" class="submenu-link {{ request()->routeIs('admin.clients.index') ? 'active' : '' }}">
                            جميع العملاء والملفات
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.customers.index') }}" class="submenu-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                            العملاء الفعليين (المتعاقدين)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.consultations.index') }}" class="submenu-link {{ request()->routeIs('admin.consultations.*') ? 'active' : '' }}">
                            طلبات التواصل والاستشارات
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.smart-cards') }}" class="submenu-link smart-card-feature {{ request()->routeIs('admin.smart-cards*') ? 'active' : '' }}">
                            الكروت الذكية VIP ✦
                        </a>
                    </li>
                </ul>
            </li>

            <div class="menu-divider"></div>

            <li class="menu-item has-submenu {{ request()->routeIs('admin.analytics.*') ? 'open active' : '' }}">
                <div class="menu-link">
                    <div class="menu-title">
                        <i class="fa-solid fa-chart-line menu-icon"></i>
                        <span>تحليل السلوك والتقارير</span>
                    </div>
                    <i class="fa-solid fa-chevron-down arrow-icon"></i>
                </div>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.analytics.index') }}" class="submenu-link {{ request()->routeIs('admin.analytics.index') ? 'active' : '' }}">
                            لوحة تحليل سلوك الزوار
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.analytics.export') }}" class="submenu-link">
                            تصدير تقرير العملاء (Excel/CSV)
                        </a>
                    </li>
                </ul>
            </li>

            <div class="menu-divider"></div>

            <li class="menu-item has-submenu {{ request()->routeIs('admin.users.*') ? 'open active' : '' }}">
                <div class="menu-link">
                    <div class="menu-title">
                        <i class="fa-solid fa-gears menu-icon"></i>
                        <span>إدارة النظام</span>
                    </div>
                    <i class="fa-solid fa-chevron-down arrow-icon"></i>
                </div>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="submenu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            المستخدمين والصلاحيات
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}" target="_blank" class="submenu-link">
                            زيارة واجهة الموقع ↗
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>

    <main class="main-wrapper">

        <header class="topbar">
            <div class="topbar-right">
                <button class="toggle-sidebar-btn" id="toggleSidebar" aria-label="فتح القائمة الجانبية">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <h3 class="topbar-title">لوحة التحكم السريعة</h3>
            </div>

            <div class="topbar-left">
                <button id="theme-switcher" class="theme-switcher-btn" title="تبديل المظهر" aria-label="تبديل المظهر">
                    <i class="fa-solid fa-moon"></i>
                </button>

                <div class="admin-profile" title="إعدادات الحساب">
                    <div class="admin-avatar">{{ mb_substr(auth()->user()->name ?? 'م', 0, 1) }}</div>
                    <div class="admin-info">
                        <span class="admin-name">{{ auth()->user()->name ?? 'مدير النظام' }}</span>
                        <span class="admin-role">{{ auth()->user()->role ?? 'admin' }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="theme-switcher-btn" title="تسجيل الخروج" aria-label="تسجيل الخروج" onclick="return confirm('هل ترغب في تسجيل الخروج؟');">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </header>

        <div class="content-area">
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // 1. منطق القوائم المنسدلة الذكية (Accordion Menu)
            const menuItems = document.querySelectorAll('.has-submenu');

            menuItems.forEach(item => {
                const link = item.querySelector('.menu-link');
                link.addEventListener('click', (e) => {
                    e.preventDefault();

                    // إغلاق أي قائمة أخرى مفتوحة بسلاسة
                    menuItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('open')) {
                            otherItem.classList.remove('open');
                            otherItem.querySelector('.arrow-icon').style.transform = 'rotate(0deg)';
                        }
                    });

                    // تبديل القائمة الحالية
                    item.classList.toggle('open');
                    const arrow = item.querySelector('.arrow-icon');
                    arrow.style.transform = item.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
                });
            });

            // 2. إدارة فتح وإغلاق القائمة الجانبية للموبايل
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                
                // منع التمرير في الخلفية عند فتح القائمة بالموبايل
                if(sidebar.classList.contains('active')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }

            toggleBtn?.addEventListener('click', toggleSidebar);
            overlay?.addEventListener('click', toggleSidebar);

            // 3. محول الثيم الذكي مع تغيير الأيقونة
            const themeBtn = document.getElementById('theme-switcher');
            const themeIcon = themeBtn?.querySelector('i');

            themeBtn?.addEventListener('click', () => {
                if (window.preferences?.toggleTheme) {
                    window.preferences.toggleTheme();
                } else {
                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', newTheme);
                    
                    // تغيير الأيقونة بين الشمس والقمر
                    if(newTheme === 'light') {
                        themeIcon.classList.remove('fa-moon');
                        themeIcon.classList.add('fa-sun');
                    } else {
                        themeIcon.classList.remove('fa-sun');
                        themeIcon.classList.add('fa-moon');
                    }
                }
            });
        });
    </script>

</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // ==========================================
        // 1. إدارة التحميل (Loader) والفيديو
        // ==========================================
        const loader = document.getElementById("premium-loader");
        const logo = document.getElementById("loader-logo");
        const videoDesktop = document.getElementById("hero-video-desktop");
        const videoMobile = document.getElementById("hero-video-mobile");
        const heroContent = document.getElementById("hero-content");

        const isMobile = window.innerWidth < 768;
        const activeVideo = isMobile ? videoMobile : videoDesktop;

        // بدء حركة اللوجو
        setTimeout(() => {
            logo.classList.add("spin-90");
        }, 50);

        const checkVideoReady = new Promise((resolve) => {
            if (activeVideo.readyState >= 3) {
                resolve();
            } else {
                activeVideo.addEventListener("canplaythrough", resolve, {
                    once: true
                });
                // Fallback timeout in case video fails to load quickly
                setTimeout(resolve, 3000);
            }
        });

        setTimeout(() => {
            checkVideoReady.then(() => {
                logo.classList.remove("spin-90");
                logo.classList.add("spin-360");

                setTimeout(() => {
                    loader.style.opacity = "0";
                    setTimeout(() => {
                        loader.style.visibility = "hidden";
                        activeVideo.classList.add("video-ready");
                        activeVideo.play().catch(e => console.log(
                            "Autoplay prevented:", e));
                        heroContent.classList.add("content-visible");
                    }, 800);
                }, 1000);
            });
        }, 1050);

        // ==========================================
        // 2. Smooth Scrolling والتمرير السلس
        // ==========================================
        document.querySelectorAll('.nav-link, .drawer-link, .btn-consultation, .drawer-btn').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
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
                        toggleDrawer();
                    }
                }
            });
        });

        // ==========================================
        // 3. Mobile Drawer Logic (هيكل القائمة الجانبية)
        // ==========================================
        const menuBtn = document.getElementById('mobile-menu-btn');
        const closeBtn = document.getElementById('close-drawer');
        const drawer = document.getElementById('mobile-drawer');
        const overlay = document.getElementById('drawer-overlay');

        function openDrawer() {
            drawer.classList.add('open');
            overlay.classList.add('active');
            menuBtn.classList.add('active');

            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            drawer.classList.remove('open');
            overlay.classList.remove('active');
            menuBtn.classList.remove('active');

            document.body.style.overflow = '';
        }

        menuBtn?.addEventListener('click', openDrawer);
        closeBtn?.addEventListener('click', closeDrawer);
        overlay?.addEventListener('click', closeDrawer);
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeDrawer();
            }
        });


    });
</script>



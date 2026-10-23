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
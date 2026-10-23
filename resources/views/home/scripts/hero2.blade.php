<script>
    document.addEventListener("DOMContentLoaded", () => {
        // =========================================================
        // إدارة تحميل الفيديو الخاص بـ Hero 2 ديناميكياً بدون تحميل أزواج إضافية
        // =========================================================
        const videoDesktop2 = document.getElementById("d_hero2-video");
        const videoMobile2 = document.getElementById("m_hero2-video");

        if (!videoDesktop2 || !videoMobile2) return;

        const MOBILE_BREAKPOINT = 768;
        let currentHero2Mode = null; // 'mobile' | 'desktop'

        function getHero2Mode() {
            return window.innerWidth < MOBILE_BREAKPOINT ? "mobile" : "desktop";
        }

        function activateHero2Video(mode) {
            const active = mode === "mobile" ? videoMobile2 : videoDesktop2;
            const inactive = mode === "mobile" ? videoDesktop2 : videoMobile2;

            // إيقاف الفيديو غير المستخدم وسحب الـ src منه لمنع الاستهلاك
            inactive.pause();
            inactive.removeAttribute("src");
            inactive.querySelectorAll("source").forEach(s => s.removeAttribute("src"));
            inactive.load();
            inactive.classList.add("video-inactive");
            inactive.classList.remove("video-ready");

            // تعيين الـ src للفيديو النشط فقط إذا لم يكن قد تم تحميله بالفعل
            if (!active.dataset.loaded) {
                active.src = active.dataset.src;
                active.dataset.loaded = "true";
            }
            active.classList.remove("video-inactive");
            return active;
        }

        function setupHero2Video(video) {
            if (!video) return;
            video.load();

            const playPromise = () => {
                video.classList.add("video-ready");
                video.play().catch(e => console.log("Hero2 Autoplay prevented:", e));
            };

            if (video.readyState >= 3) {
                playPromise();
            } else {
                video.addEventListener("canplaythrough", playPromise, {
                    once: true
                });
                // Fallback للأمان في حالة تأخر الشبكة
                setTimeout(playPromise, 3000);
            }
        }

        // التشغيل الأولي عند تحضير الصفحة
        currentHero2Mode = getHero2Mode();
        const activeHero2Video = activateHero2Video(currentHero2Mode);
        setupHero2Video(activeHero2Video);

        // =========================================================
        // التبديل عند إمالة الشاشة أو تغيير مقاس النافذة (Resize Debounce)
        // =========================================================
        let resizeTimer2 = null;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTimer2);
            resizeTimer2 = setTimeout(() => {
                const newMode = getHero2Mode();
                if (newMode === currentHero2Mode) return;

                currentHero2Mode = newMode;
                const newActiveVideo = activateHero2Video(currentHero2Mode);

                if (newActiveVideo.dataset.loaded === "true" && newActiveVideo.readyState >=
                    3) {
                    newActiveVideo.classList.add("video-ready");
                    newActiveVideo.play().catch(() => {});
                } else {
                    setupHero2Video(newActiveVideo);
                }
            }, 300);
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // 1. تحديث السنة تلقائياً
        const yearEl = document.getElementById("footer-year");
        if (yearEl) yearEl.textContent = new Date().getFullYear();

        // 2. إعداد كانفاس الفقاعات المتموجة الحية (Live Interactive Bubbles Canvas)
        const canvas = document.getElementById("footer-bubbles-canvas");
        if (!canvas) return;

        const ctx = canvas.getContext("2d");
        let width, height;
        let bubbles = [];

        // ألوان الهوية البصرية من Moemen Team
        const paletteLight = [
            "rgba(31, 42, 36, 0.08)",
            "rgba(55, 74, 60, 0.12)",
            "rgba(80, 96, 85, 0.15)",
            "rgba(175, 128, 111, 0.1)"
        ];

        const paletteDark = [
            "rgba(175, 128, 111, 0.18)",
            "rgba(80, 96, 85, 0.25)",
            "rgba(167, 183, 167, 0.12)",
            "rgba(55, 74, 60, 0.3)"
        ];

        function getPalette() {
            const isDark = document.documentElement.classList.contains("dark") ||
                document.documentElement.dataset.theme === "dark";
            return isDark ? paletteDark : paletteLight;
        }

        function resize() {
            width = canvas.width = canvas.parentElement.offsetWidth;
            height = canvas.height = canvas.parentElement.offsetHeight;
        }

        class Bubble {
            constructor() {
                this.reset();
            }

            reset() {
                this.x = Math.random() * width;
                this.y = height + Math.random() * 100;
                this.radius = Math.random() * 25 + 8; // أحجام متدرجة
                this.speed = Math.random() * 0.6 + 0.2; // سرعة صعود مريحة للعين
                this.angle = Math.random() * Math.PI * 2;
                this.angularSpeed = (Math.random() - 0.5) * 0.015; // دوران ناعم
                this.oscillationAmplitude = Math.random() * 1.5 + 0.5;
                this.colors = getPalette();
                this.color = this.colors[Math.floor(Math.random() * this.colors.length)];
            }

            update() {
                this.y -= this.speed;
                this.angle += this.angularSpeed;
                this.x += Math.sin(this.angle) * this.oscillationAmplitude;

                // إعادة تدوير الفقاعة فور خروجها من الشاشة
                if (this.y < -this.radius * 2) {
                    this.reset();
                }
            }

            draw() {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.angle);

                ctx.beginPath();
                ctx.arc(0, 0, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = this.color;
                ctx.fill();

                // رسم حلقة دوران جمالية خفيفة داخل الفقاعة
                ctx.beginPath();
                ctx.arc(this.radius * 0.3, -this.radius * 0.3, this.radius * 0.25, 0, Math.PI * 2);
                ctx.fillStyle = "rgba(255, 255, 255, 0.15)";
                ctx.fill();

                ctx.restore();
            }
        }

        function initBubbles() {
            resize();
            bubbles = [];
            const count = Math.floor(width / 35); // كثافة متناسقة مع الشاشة
            for (let i = 0; i < count; i++) {
                const b = new Bubble();
                b.y = Math.random() * height; // توزيع متساوي في البداية
                bubbles.push(b);
            }
        }

        function animate() {
            ctx.clearRect(0, 0, width, height);
            bubbles.forEach(bubble => {
                bubble.update();
                bubble.draw();
            });
            requestAnimationFrame(animate);
        }

        window.addEventListener("resize", resize);
        initBubbles();
        animate();

        // 3. التفاعل المباشر مع الأحداث الخاصة بكلاس Preferences
        window.addEventListener("preferencesChanged", (e) => {
            // إعادة تحديث ألوان الفقاعات فور تغير الثيم (Dark/Light)
            const currentPalette = getPalette();
            bubbles.forEach(b => {
                b.color = currentPalette[Math.floor(Math.random() * currentPalette.length)];
            });
        });
    });
</script>

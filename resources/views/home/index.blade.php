@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- @if (!isset($client))
        <div class="hero-blur-overlay hidden-overlay" id="heroMicroFormOverlay">

            <div class="micro-form-card">
                <div class="micro-form-header">
                    <h3 data-ar="ابحث عن عقارك المثالي" data-en="Find Your Dream Property">ابحث عن عقارك المثالي</h3>
                    <p data-ar="أدخل بياناتك المبدئية للبدء" data-en="Enter your basic details to start">أدخل بياناتك المبدئية
                        للبدء</p>
                </div>

                <form id="leadMicroForm">
                    <div class="input-group">
                        <input type="text" id="lead_name" name="full_name" required data-placeholder-ar="الاسم بالكامل"
                            data-placeholder-en="Full Name" placeholder="الاسم بالكامل">
                    </div>

                    <div class="input-group">
                        <input type="tel" id="lead_phone" name="phone" required data-placeholder-ar="رقم الهاتف"
                            data-placeholder-en="Phone Number" placeholder="رقم الهاتف">
                    </div>

                    <button type="submit" class="cta-btn">
                        <span class="btn-text" data-ar="ابدأ الآن" data-en="Start Now">ابدأ الآن</span>
                        <span class="btn-loader" style="display: none;"></span>
                    </button>
                </form>

                <div id="successMessage" class="success-msg" style="display: none;">
                    <div class="check-icon-wrapper">
                        <span class="check-icon">✓</span>
                    </div>
                    <p id="successText"></p>
                </div>
            </div>
        </div>
    @endif --}}
{{-- 
    <style>
        /* ===================================== */
        /* Micro-Form Styles & Animations        */
        /* ===================================== */

        /* طبقة الضباب - position: fixed لتبقى متسنترة دائماً */
        .hero-blur-overlay {
            position: fixed;
            /* التعديل الأهم هنا */
            inset: 0;
            z-index: 9999;
            /* للتأكد من ظهوره فوق كل شيء */
            background: rgba(15, 23, 42, 0.6);
            /* لون أغمق وأكثر عصرية */
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.6s;
        }

        /* إخفاء الموديل في البداية */
        .hidden-overlay {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .hero-blur-overlay:not(.hidden-overlay) .micro-form-card {
            /* تشغيل الأنيميشن فقط عند ظهور الموديل */
            animation: ultraSpringPop 1s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        /* حركة الكيرف الخرافي (اهتزاز وعصرية) */
        @keyframes ultraSpringPop {
            0% {
                opacity: 0;
                transform: scale(0.6) translateY(80px) rotate(-4deg);
            }

            40% {
                opacity: 1;
                transform: scale(1.08) translateY(-15px) rotate(2deg);
            }

            70% {
                transform: scale(0.96) translateY(5px) rotate(-1deg);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0) rotate(0);
            }
        }

        /* الكارد الخاص بالفورم */
        .micro-form-card {
            width: 100%;
            max-width: 440px;
            background: var(--bg-secondary, #ffffff);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: clamp(2rem, 5vw, 3rem);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.4), 0 0 20px rgba(255, 255, 255, 0.1) inset;
            opacity: 0;
            /* يبدأ مخفياً ليظهر مع الأنيميشن */
            transform-origin: center bottom;
        }

        .micro-form-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .micro-form-header h3 {
            color: var(--text-main, #1e293b);
            font-size: clamp(1.4rem, 4vw, 1.8rem);
            margin-bottom: 0.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .micro-form-header p {
            color: var(--text-muted, #64748b);
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* تصميم الحقول الاحترافي */
        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .input-group input {
            width: 100%;
            background: #f8fafc;
            color: var(--text-main, #0f172a);
            border: 2px solid transparent;
            border-radius: 16px;
            padding: 1.2rem 1.5rem;
            font-family: inherit;
            font-size: 1.05rem;
            font-weight: 500;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-group input::placeholder {
            color: #94a3b8;
        }

        .input-group input:hover {
            background: #f1f5f9;
        }

        .input-group input:focus {
            outline: none;
            background: #ffffff;
            border-color: var(--primary-red, #e11d48);
            box-shadow: 0 0 0 5px rgba(225, 29, 72, 0.15), inset 0 2px 4px rgba(0, 0, 0, 0.02);
            transform: translateY(-3px);
        }

        /* الزر الأساسي العصري */
        .cta-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-red, #e11d48) 0%, #be123c 100%);
            color: #fff;
            border: none;
            border-radius: 16px;
            padding: 1.2rem;
            font-size: 1.15rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 20px -5px rgba(225, 29, 72, 0.4);
        }

        .cta-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: skewX(-20deg);
            transition: 0.5s;
        }

        .cta-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 15px 25px -5px rgba(225, 29, 72, 0.5);
        }

        .cta-btn:hover::after {
            left: 150%;
        }

        .cta-btn:active {
            transform: translateY(2px) scale(0.98);
            box-shadow: 0 5px 10px -5px rgba(225, 29, 72, 0.4);
        }

        /* رسالة النجاح بشكل مبهر */
        .success-msg {
            text-align: center;
            margin-top: 2rem;
            animation: successPop 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .check-icon-wrapper {
            width: 60px;
            height: 60px;
            background: #10B981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
            animation: pulseGreen 2s infinite;
        }

        .success-msg .check-icon {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .success-msg p {
            color: var(--text-main, #1e293b);
            font-weight: 700;
            font-size: 1.25rem;
        }

        @keyframes successPop {
            0% {
                opacity: 0;
                transform: scale(0.8) translateY(20px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes pulseGreen {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* لودر بسيط للزر */
        .btn-loader {
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* =========================================
       Micro Form - Light & Dark Theme Support
       ========================================= */

        /* الوضع العادي Light */
        .input-group input {
            background-color: #f8fafc !important;
            color: #0f172a !important;
            border-color: transparent;
            caret-color: #e11d48;
        }

        .input-group input::placeholder {
            color: #94a3b8 !important;
            opacity: 1;
        }

        /* التركيز */
        .input-group input:focus {
            background-color: #ffffff !important;
            color: #0f172a !important;
            border-color: var(--primary-red, #e11d48) !important;
        }

        /* =========================================
       Dark Theme
       ========================================= */

        [data-theme="dark"] .input-group input,
        .dark .input-group input,
        body.dark .input-group input {
            background-color: #1e293b !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
            caret-color: #fb7185;
        }

        [data-theme="dark"] .input-group input::placeholder,
        .dark .input-group input::placeholder,
        body.dark .input-group input::placeholder {
            color: #94a3b8 !important;
            opacity: 1;
        }

        /* عند الضغط على الحقل في Dark */
        [data-theme="dark"] .input-group input:focus,
        .dark .input-group input:focus,
        body.dark .input-group input:focus {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border-color: var(--primary-red, #e11d48) !important;
            box-shadow: 0 0 0 5px rgba(225, 29, 72, 0.15) !important;
        }

        /* Autofill - Chrome */
        [data-theme="dark"] .input-group input:-webkit-autofill,
        .dark .input-group input:-webkit-autofill,
        body.dark .input-group input:-webkit-autofill {
            -webkit-text-fill-color: #ffffff !important;
            -webkit-box-shadow: 0 0 0 1000px #1e293b inset !important;
            caret-color: #ffffff !important;
        }

        .input-group input:-webkit-autofill {
            -webkit-text-fill-color: #0f172a !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overlay = document.getElementById('heroMicroFormOverlay');
            let hasModalShown = false;

            // --- 1. كود إظهار الموديل بعد سكرول ثلث الصفحة ---
            if (overlay) {
                window.addEventListener('scroll', () => {
                    if (hasModalShown) return; // عشان ما يظهرش تاني لو ظهر مرة

                    const scrollPosition = window.scrollY;
                    // حساب ارتفاع الصفحة مطروح منه ارتفاع شاشة المستخدم
                    const documentHeight = Math.max(
                        document.body.scrollHeight, document.documentElement.scrollHeight,
                        document.body.offsetHeight, document.documentElement.offsetHeight,
                        document.body.clientHeight, document.documentElement.clientHeight
                    );
                    const viewableHeight = documentHeight - window.innerHeight;

                    // تحديد نقطة الثلث
                    const triggerPoint = viewableHeight / 3;

                    // إذا تخطى المستخدم ثلث الصفحة، أظهر الموديل
                    if (scrollPosition >= triggerPoint && triggerPoint > 0) {
                        overlay.classList.remove('hidden-overlay');
                        hasModalShown = true;
                    }
                });
            }

            // --- 2. كود التعامل مع الفورم ---
            const form = document.getElementById('leadMicroForm');
            const btn = form?.querySelector('.cta-btn');
            const btnText = btn?.querySelector('.btn-text');
            const btnLoader = btn?.querySelector('.btn-loader');
            const successMsg = document.getElementById('successMessage');
            const successText = document.getElementById('successText');

            if (form) {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    // تغيير حالة الزر أثناء التحميل
                    btn.style.pointerEvents = 'none';
                    btnText.style.display = 'none';
                    btnLoader.style.display = 'block';

                    const formData = new FormData(form);
                    const data = {
                        full_name: formData.get('full_name'),
                        phone: formData.get('phone')
                    };

                    try {
                        // استدعاء الـ API
                        const response = await fetch('/api/v1/lead/register', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')?.content
                            },
                            body: JSON.stringify(data)
                        });

                        const result = await response.json();

                        if (response.ok) {
                            // إخفاء الفورم وإظهار رسالة النجاح بتأثير مبهر
                            form.style.display = 'none';
                            document.querySelector('.micro-form-header').style.display =
                                'none'; // إخفاء الهيدر أيضاً لشكل أفضل
                            successMsg.style.display = 'block';

                            const currentLang = window.preferences?.lang || 'ar';
                            successText.textContent = currentLang === 'ar' ? result.message_ar : result
                                .message_en;

                            // إخفاء طبقة الضباب وعمل سكرول ناعم بعد 3 ثواني
                            setTimeout(() => {
                                overlay.style.opacity = '0';
                                setTimeout(() => {
                                    overlay.style.display = 'none';

                                    const interestSection = document.getElementById(
                                        'interest-section');
                                    if (interestSection) {
                                        interestSection.scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'start'
                                        });
                                    }
                                }, 600); // وقت متوافق مع الـ transition الجديد
                            }, 3000);
                        } else {
                            const currentLang = window.preferences?.lang || 'ar';
                            alert(currentLang === 'ar' ? 'يرجى التأكد من صحة البيانات' :
                                'Please verify your data');
                        }
                    } catch (error) {
                        console.error('Error saving lead:', error);
                    } finally {
                        // إعادة الزر لحالته الطبيعية
                        btn.style.pointerEvents = 'auto';
                        btnText.style.display = 'block';
                        btnLoader.style.display = 'none';
                    }
                });
            }
        });
    </script> --}}

    @include('home.sections.hero')
    @include('home.sections.hero2')
    @include('home.sections.sectors')
    @include('home.sections.interest')
    @include('home.sections.media-section')
    @include('home.sections.visionaries-section')
    @include('home.sections.join-team')
    @include('home.sections.search')

@endsection

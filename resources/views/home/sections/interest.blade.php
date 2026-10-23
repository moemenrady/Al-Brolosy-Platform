<style>
    :root {
        --interest-bg: #0b0b0c;
        --interest-panel: rgba(20, 20, 22, 0.6);
        --interest-border: rgba(180, 0, 0, 0.2);
        --interest-text: #F0F0F0;
        --interest-muted: #76767A;
        --interest-input-bg: rgba(0, 0, 0, 0.4);
        --interest-badge-active: #B40000;
        --timeline-line: rgba(180, 0, 0, 0.3);
    }

    html[data-theme="light"] {
        --interest-bg: #F9F9FA;
        --interest-panel: rgba(255, 255, 255, 0.9);
        --interest-border: rgba(180, 0, 0, 0.3);
        --interest-text: #1C1C1E;
        --interest-muted: #696969;
        --interest-input-bg: #FFFFFF;
        --interest-badge-active: #B40000;
        --timeline-line: rgba(180, 0, 0, 0.2);
    }

    .interest-section {
        background-color: var(--interest-bg);
        padding: 8rem 5% 6rem 5%;
        position: relative;
        overflow: hidden;
        transition: background-color 0.5s ease;
    }

    .interest-container {
        max-width: 950px;
        margin: 0 auto;
        background: var(--interest-panel);
        border: 1px solid var(--interest-border);
        border-radius: 12px;
        padding: 3rem;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
        position: relative;
    }

    @media (max-width: 768px) {
        .interest-container {
            padding: 2rem 1.2rem;
        }
    }

    /* العناوين */
    .section-title {
        color: var(--warm-beige, #d8c3a5);
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        letter-spacing: 1px;
    }

    html[data-theme="light"] .section-title {
        color: var(--black, #1a1a1a);
    }

    .section-subtitle {
        color: var(--interest-muted);
        font-size: 1.05rem;
        line-height: 1.6;
        max-width: 700px;
        margin: 0 auto 3rem auto;
    }

    /* شريط التقدم الفاخر */
    .form-progress-wrapper {
        margin-bottom: 3.5rem;
        position: relative;
    }

    .progress-track {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: rgba(118, 118, 122, 0.2);
        transform: translateY(-50%);
        z-index: 1;
    }

    .progress-bar {
        height: 100%;
        width: 0%;
        background: var(--primary-red, #B40000);
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        z-index: 2;
    }

    .step-indicator {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--interest-bg);
        border: 2px solid rgba(118, 118, 122, 0.3);
        color: var(--interest-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
        transition: all 0.4s ease;
    }

    .step-indicator.active {
        border-color: var(--primary-red, #B40000);
        color: #FFFFFF;
        background: var(--primary-red, #B40000);
        box-shadow: 0 0 15px rgba(180, 0, 0, 0.5);
    }

    .step-indicator.completed {
        border-color: var(--primary-red, #B40000);
        color: var(--primary-red, #B40000);
        background: var(--interest-bg);
    }

    /* تصميم الخطوات */
    .form-step {
        display: none;
        opacity: 0;
        transform: translateY(15px);
        transition: opacity 0.4s ease, transform 0.4s ease;
    }

    .form-step.active {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .step-title {
        color: var(--warm-beige, #d8c3a5);
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 2rem;
        border-right: 3px solid var(--primary-red, #B40000);
        padding: 0 12px;
    }

    html[data-theme="light"] .step-title {
        color: var(--black, #1a1a1a);
    }

    html[dir="ltr"] .step-title {
        border-right: none;
        border-left: 3px solid var(--primary-red, #B40000);
        padding: 0 12px;
    }

    /* الحقول النصية (للبيانات الشخصية فقط) */
    .inputs-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    @media(min-width: 768px) {
        .inputs-grid {
            grid-template-columns: 1fr 1fr;
        }

        .full-width {
            grid-column: span 2;
        }
    }

    .input-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .input-wrapper label,
    .badge-selection-group label.group-label {
        font-size: 0.95rem;
        color: var(--interest-text);
        font-weight: 600;
        display: flex;
        justify-content: space-between;
    }

    .label-optional {
        font-size: 0.8rem;
        color: var(--interest-muted);
        font-weight: 400;
    }

    .input-wrapper input,
    .input-wrapper textarea {
        background: var(--interest-input-bg);
        border: 1px solid rgba(118, 118, 122, 0.3);
        padding: 1rem 1.2rem;
        color: var(--interest-text);
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .input-wrapper input:focus,
    .input-wrapper textarea:focus {
        outline: none;
        border-color: var(--primary-red, #B40000);
        box-shadow: 0 0 12px rgba(180, 0, 0, 0.15);
    }

    /* نظام الـ Badges (الاختيارات المتساوية والريسبونسف) */
    .badge-selection-group {
        margin-bottom: 2rem;
    }

    .badges-grid {
        display: grid;
        gap: 0.8rem;
        margin-top: 0.8rem;
        grid-template-columns: repeat(2, 1fr);
    }

    /* تحكم ذكي في عدد الأعمدة حسب الشاشة */
    .badges-grid.cols-3 {
        grid-template-columns: repeat(2, 1fr);
    }

    .badges-grid.cols-4 {
        grid-template-columns: repeat(2, 1fr);
    }

    .badges-grid.cols-5 {
        grid-template-columns: repeat(2, 1fr);
    }

    .badges-grid.cols-auto {
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    }

    @media(min-width: 576px) {
        .badges-grid.cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .badges-grid.cols-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        .badges-grid.cols-5 {
            grid-template-columns: repeat(5, 1fr);
        }

        .badges-grid.cols-auto {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }
    }

    .badge-card {
        position: relative;
        cursor: pointer;
        display: block;
        height: 100%;
        /* لضمان التساوي */
    }

    .badge-card input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .badge-card span {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem 0.5rem;
        background: var(--interest-input-bg);
        border: 1px solid rgba(118, 118, 122, 0.2);
        color: var(--interest-text);
        border-radius: 8px;
        font-size: 0.95rem;
        text-align: center;
        transition: all 0.3s ease;
        user-select: none;
        font-weight: 500;
        height: 100%;
        min-height: 55px;
        /* ارتفاع ثابت لجميع المربعات */
    }

    .badge-card:hover span {
        border-color: rgba(180, 0, 0, 0.5);
    }

    .badge-card input:checked+span {
        background: var(--interest-badge-active);
        border-color: var(--primary-red, #B40000);
        color: #FFFFFF !important;
        box-shadow: 0 8px 20px rgba(180, 0, 0, 0.3);
    }

    /* رفع الصورة */
    .file-upload-container {
        position: relative;
        display: flex;
        align-items: center;
        gap: 15px;
        background: var(--interest-input-bg);
        border: 1px dashed rgba(118, 118, 122, 0.4);
        padding: 0.8rem 1.2rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-upload-container:hover {
        border-color: var(--primary-red, #B40000);
        background: rgba(180, 0, 0, 0.02);
    }

    .file-upload-container input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .file-upload-trigger {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--interest-text);
        font-size: 0.95rem;
    }

    .file-upload-trigger svg {
        color: var(--primary-red, #B40000);
    }

    .file-name-preview {
        font-size: 0.85rem;
        color: var(--interest-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    /* أزرار الإرسال */
    .form-navigation-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        border-top: 1px solid rgba(118, 118, 122, 0.1);
        padding-top: 2rem;
    }

    .btn-form-primary,
    .btn-form-secondary {
        padding: 1rem 2.5rem;
        font-size: 1rem;
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-form-primary {
        background: var(--primary-red, #B40000);
        border: 1px solid var(--primary-red, #B40000);
        color: #FFFFFF;
    }

    .btn-form-primary:hover {
        background: #900000;
        box-shadow: 0 10px 20px rgba(180, 0, 0, 0.2);
    }

    .btn-form-secondary {
        background: transparent;
        border: 1px solid rgba(118, 118, 122, 0.4);
        color: var(--interest-text);
    }

    .btn-form-secondary:hover {
        background: rgba(118, 118, 122, 0.1);
    }

    .hidden {
        display: none !important;
    }

    /* شاشة النجاح */
    .form-success-overlay {
        position: absolute;
        inset: 0;
        background: var(--interest-bg);
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        animation: fadeInSuccess 0.5s forwards ease;
    }

    .success-message-card {
        text-align: center;
        max-width: 450px;
        padding: 2rem;
    }

    .success-message-card h3 {
        color: var(--warm-beige, #d8c3a5);
        font-size: 2rem;
        margin: 1.5rem 0 1rem 0;
    }

    html[data-theme="light"] .success-message-card h3 {
        color: var(--black, #1a1a1a);
    }

    .success-message-card p {
        color: var(--interest-muted);
        font-size: 1.1rem;
        line-height: 1.6;
    }

    /* أنيميشن النجاح */
    .success-icon-animated svg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #ffffff;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px var(--primary-red, #B40000);
        animation: fillSuccess .4s ease-in-out .4s forwards, scaleSuccess .3s ease-in-out .9s toggle;
        margin: 0 auto;
    }

    .success-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: var(--primary-red, #B40000);
        fill: none;
        animation: strokeSuccess 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .success-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke: var(--primary-red, #B40000);
        animation: strokeSuccess 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes strokeSuccess {
        100% {
            stroke-dashoffset: 0;
        }
    }

    @keyframes fadeInSuccess {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* الشيك بوكس */
    .custom-checkbox {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        user-select: none;
    }

    .custom-checkbox input {
        display: none;
    }

    .checkmark {
        width: 22px;
        height: 22px;
        background: var(--interest-input-bg);
        border: 1px solid rgba(118, 118, 122, 0.4);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .custom-checkbox input:checked~.checkmark {
        background: var(--primary-red, #B40000);
        border-color: var(--primary-red, #B40000);
    }

    .custom-checkbox input:checked~.checkmark::after {
        content: "✓";
        color: white;
        font-size: 14px;
    }

    .checkbox-text {
        font-size: 0.95rem;
        color: var(--interest-text);
    }

    .client-profile-banner {

        margin-bottom: 40px;

        padding: 35px;

        border-radius: 18px;

        background: linear-gradient(135deg, #b40000 0%, #6d0000 100%);

        color: #fff;

        display: flex;

        justify-content: space-between;

        align-items: center;

        gap: 40px;

        flex-wrap: wrap;

        overflow: hidden;

        position: relative;

    }

    .client-profile-banner::after {

        content: "";

        position: absolute;

        width: 260px;

        height: 260px;

        border-radius: 50%;

        background: rgba(255, 255, 255, .05);

        right: -90px;

        top: -90px;

    }

    .profile-info {

        display: flex;

        align-items: center;

        gap: 25px;

        z-index: 2;

    }

    .profile-avatar img {

        width: 90px;

        height: 90px;

        border-radius: 50%;

        object-fit: cover;

        border: 4px solid rgba(255, 255, 255, .25);

    }

    .profile-badge {

        display: inline-flex;

        align-items: center;

        gap: 8px;

        background: rgba(255, 255, 255, .12);

        padding: 8px 15px;

        border-radius: 50px;

        margin-bottom: 12px;

        font-size: .9rem;

    }

    .profile-content h3 {

        font-size: 2rem;

        margin-bottom: 12px;

    }

    .profile-content p {

        max-width: 600px;

        line-height: 1.8;

        opacity: .9;

    }

    .btn-profile {

        display: inline-flex;

        align-items: center;

        gap: 12px;

        padding: 18px 32px;

        background: #fff;

        color: #b40000;

        font-weight: 700;

        border-radius: 10px;

        text-decoration: none;

        transition: .3s;

        z-index: 2;

    }

    .btn-profile:hover {

        transform: translateY(-4px);

        box-shadow: 0 20px 40px rgba(0, 0, 0, .25);

    }

    @media(max-width:768px) {

        .client-profile-banner {

            text-align: center;

            justify-content: center;

        }

        .profile-info {

            flex-direction: column;

        }

    }

    .client-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .client-avatar-placeholder {
        background: #e9e9e9;
        color: #8e8e8e;
        font-size: 28px;
    }

    .client-avatar-placeholder i {
        line-height: 1;
    }
</style>

<section id="consultation" class="interest-section">
    <div class="interest-container">

        <div class="section-header text-center">
            @if (isset($client))
                <h2 class="section-title" data-en="Your Real Estate Profile" data-ar="ملفك العقاري لدى البرلسي">ملفك
                    العقاري لدى البرلسي</h2>
                <p class="section-subtitle"
                    data-en="Review and update your preferences to get the best tailored offers easily."
                    data-ar="مرحباً بك مجدداً. حدّث تفضيلاتك العقارية بنقرات بسيطة للحصول على الفرص الأنسب لك.">مرحباً
                    بك
                    مجدداً. حدّث تفضيلاتك العقارية بنقرات بسيطة للحصول على الفرص الأنسب لك.</p>
            @else
                <h2 class="section-title" data-en="Register Your Interest" data-ar="سجل اهتماماتك العقارية">سجل
                    اهتماماتك العقارية</h2>
                <p class="section-subtitle"
                    data-en="Select your preferences effortlessly. No typing required except for your basic info."
                    data-ar="انضم لنخب عملاء البرلسي. حدد تفضيلاتك بكل سهولة دون الحاجة للكتابة باستثناء بياناتك الأساسية.">
                    انضم لنخب عملاء البرلسي. حدد تفضيلاتك بكل سهولة دون الحاجة للكتابة باستثناء بياناتك الأساسية.</p>
            @endif
        </div>

        <div class="form-progress-wrapper">
            <div class="progress-track">
                <div class="progress-bar" id="form-progress"></div>
            </div>
            <div class="progress-steps">
                <span class="step-indicator active" data-step="1">1</span>
                <span class="step-indicator" data-step="2">2</span>
                <span class="step-indicator" data-step="3">3</span>
            </div>
        </div>
        @if (isset($client) && $client)
            <div class="client-profile-banner">

                <div class="profile-info">

                    <div class="profile-avatar">

                        @if ($client->photo)
                            <img src="{{ asset($client->photo) }}" alt="{{ $client->full_name }}" class="client-avatar">
                        @else
                            <div class="client-avatar client-avatar-placeholder">
                                <img src="https://www.w3schools.com/howto/img_avatar.png"
                                    alt="{{ $client->full_name }}" class="client-avatar">
                            </div>
                        @endif

                    </div>

                    <div class="profile-content">

                        <span class="profile-badge">
                            <i class="fas fa-check-circle"></i>

                            <span data-ar="تم إنشاء ملفك الشخصي" data-en="Your profile is ready">
                                تم إنشاء ملفك الشخصي
                            </span>

                        </span>

                        <h3>

                            <span data-ar="مرحباً" data-en="Welcome">
                                مرحباً
                            </span>

                            {{ $client->full_name }}

                        </h3>

                        <p data-ar="يمكنك الآن متابعة حالة طلباتك، بطاقة العميل الذكية، سجل التعاملات، وتحديث بياناتك من خلال ملفك الشخصي."
                            data-en="Access your smart card, follow-up history, requests and update your information from your client profile.">

                            يمكنك الآن متابعة حالة طلباتك، بطاقة العميل الذكية، سجل التعاملات، وتحديث بياناتك من خلال
                            ملفك الشخصي.

                        </p>

                    </div>

                </div>

                <div class="profile-actions">

                    <a href="{{ route('client.profile') }}" class="btn-profile">

                        <i class="fas fa-user-circle"></i>

                        <span data-ar="الذهاب إلى الملف الشخصي" data-en="Open Client Profile">

                            الذهاب إلى الملف الشخصي

                        </span>

                    </a>

                </div>

            </div>
        @endif
        <form id="smart-interest-form" class="smart-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="lead_source" value="website">

            <div class="form-step active" data-step="1">
                <div class="step-title" data-en="Basic Information" data-ar="البيانات الأساسية">البيانات الأساسية</div>
                <div class="inputs-grid">
                    <div class="input-wrapper">
                        <label data-en="Full Name *" data-ar="الاسم بالكامل *">الاسم بالكامل *</label>
                        <input type="text" name="full_name" required value="{{ $client->full_name ?? '' }}"
                            placeholder="John Doe" data-placeholder-ar="الاسم ثلاثي أو ثنائي"
                            data-placeholder-en="John Doe">
                    </div>
                    <div class="input-wrapper">
                        <label data-en="Phone Number *" data-ar="رقم الهاتف *">رقم الهاتف *</label>
                        <input type="tel" name="phone" required value="{{ $client->phone ?? '' }}"
                            placeholder="+20 100..." data-placeholder-ar="+20 100..." data-placeholder-en="+20 100...">
                    </div>
                    <div class="input-wrapper">
                        <label data-en="Governorate *" data-ar="المحافظة *">المحافظة *</label>
                        <input type="text" name="governorate" required value="{{ $client->governorate ?? '' }}"
                            placeholder="Cairo" data-placeholder-ar="مثال: القاهرة، الجيزة"
                            data-placeholder-en="e.g. Cairo">
                    </div>
                    <div class="input-wrapper">
                        <label class="group-label" data-en="City (Optional)"
                            data-ar="المدينة (اختياري)"><span>المدينة</span><span
                                class="label-optional">(اختياري)</span></label>
                        <input type="text" name="city" value="{{ $client->city ?? '' }}"
                            placeholder="New Cairo" data-placeholder-ar="مثال: التجمع الخامس"
                            data-placeholder-en="e.g. New Cairo">
                    </div>
                    <div class="input-wrapper full-width">
                        <label class="group-label" data-en="Personal Photo (Optional)"
                            data-ar="الصورة الشخصية (اختياري)"><span>الصورة الشخصية</span><span
                                class="label-optional">(اختياري)</span></label>
                        <div class="file-upload-container">
                            <div class="file-upload-trigger">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                <span id="file-upload-text" data-en="Choose Photo" data-ar="اضغط لاختيار صورة">اضغط
                                    لاختيار صورة</span>
                            </div>
                            <span class="file-name-preview" id="file-name-preview"></span>
                            <input type="file" name="photo" id="photo-input" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-step" data-step="2">
                <div class="step-title" data-en="Financial Profile" data-ar="الملف المادي والشخصي">الملف المادي
                    والشخصي</div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Marital Status (Optional)"
                        data-ar="الحالة الاجتماعية (اختياري)"><span>الحالة الاجتماعية</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-4">
                        <label class="badge-card"><input type="radio" name="marital_status" value="single"
                                {{ isset($client) && $client->marital_status == 'single' ? 'checked' : '' }}><span
                                data-en="Single" data-ar="أعزب">أعزب</span></label>
                        <label class="badge-card"><input type="radio" name="marital_status" value="married"
                                {{ isset($client) && $client->marital_status == 'married' ? 'checked' : '' }}><span
                                data-en="Married" data-ar="متزوج">متزوج</span></label>
                        <label class="badge-card"><input type="radio" name="marital_status" value="divorced"
                                {{ isset($client) && $client->marital_status == 'divorced' ? 'checked' : '' }}><span
                                data-en="Divorced" data-ar="مطلق">مطلق</span></label>
                        <label class="badge-card"><input type="radio" name="marital_status" value="widowed"
                                {{ isset($client) && $client->marital_status == 'widowed' ? 'checked' : '' }}><span
                                data-en="Widowed" data-ar="أرمل">أرمل</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Family Size (Optional)"
                        data-ar="عدد أفراد الأسرة (اختياري)"><span>عدد أفراد الأسرة</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-4">
                        <label class="badge-card"><input type="radio" name="family_size" value="1"
                                {{ isset($client) && $client->family_size == '1' ? 'checked' : '' }}><span>1</span></label>
                        <label class="badge-card"><input type="radio" name="family_size" value="2-3"
                                {{ isset($client) && $client->family_size == '2-3' ? 'checked' : '' }}><span>2-3</span></label>
                        <label class="badge-card"><input type="radio" name="family_size" value="4-5"
                                {{ isset($client) && $client->family_size == '4-5' ? 'checked' : '' }}><span>4-5</span></label>
                        <label class="badge-card"><input type="radio" name="family_size" value="6+"
                                {{ isset($client) && $client->family_size == '6+' ? 'checked' : '' }}><span>+6</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Expected Budget (Optional)"
                        data-ar="الميزانية المتوقعة (اختياري)"><span>الميزانية المتوقعة</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-5">
                        <label class="badge-card"><input type="radio" name="budget" value="lt_2m"
                                {{ isset($client) && $client->budget == 'lt_2m' ? 'checked' : '' }}><span
                                data-en="< 2M" data-ar="أقل من 2 مليون">أقل من 2 مليون</span></label>
                        <label class="badge-card"><input type="radio" name="budget" value="2_4m"
                                {{ isset($client) && $client->budget == '2_4m' ? 'checked' : '' }}><span
                                data-en="2M - 4M" data-ar="2 - 4 مليون">2 - 4 مليون</span></label>
                        <label class="badge-card"><input type="radio" name="budget" value="4_6m"
                                {{ isset($client) && $client->budget == '4_6m' ? 'checked' : '' }}><span
                                data-en="4M - 6M" data-ar="4 - 6 مليون">4 - 6 مليون</span></label>
                        <label class="badge-card"><input type="radio" name="budget" value="6_10m"
                                {{ isset($client) && $client->budget == '6_10m' ? 'checked' : '' }}><span
                                data-en="6M - 10M" data-ar="6 - 10 مليون">6 - 10 مليون</span></label>
                        <label class="badge-card"><input type="radio" name="budget" value="10_20m"
                                {{ isset($client) && $client->budget == '10_20m' ? 'checked' : '' }}><span
                                data-en="10M+" data-ar="10 مليون+">10 مليون+</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Payment Method (Optional)"
                        data-ar="طريقة الدفع (اختياري)"><span>طريقة الدفع</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-3">
                        <label class="badge-card"><input type="radio" name="payment_method" value="cash"
                                {{ isset($client) && $client->payment_method == 'cash' ? 'checked' : '' }}><span
                                data-en="Cash" data-ar="كاش">كاش</span></label>
                        <label class="badge-card"><input type="radio" name="payment_method" value="installments"
                                {{ isset($client) && $client->payment_method == 'installments' ? 'checked' : '' }}><span
                                data-en="Installments" data-ar="تقسيط">تقسيط</span></label>
                        <label class="badge-card"><input type="radio" name="payment_method" value="either"
                                {{ isset($client) && $client->payment_method == 'either' ? 'checked' : '' }}><span
                                data-en="Either" data-ar="كلاهما">كلاهما</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Expected Down Payment (Optional)"
                        data-ar="المقدم المتوقع (اختياري)">
                        <span>المقدم المتوقع</span>
                        <span class="label-optional">(اختياري)</span>
                    </label>

                    <div class="badges-grid cols-5">

                        <label class="badge-card">
                            <input type="radio" name="expected_down_payment" value="1000000"
                                {{ isset($client) && $client->expected_down_payment == 1000000 ? 'checked' : '' }}>
                            <span data-en="Up to 1M" data-ar="حتى 1 مليون">
                                حتى 1 مليون
                            </span>
                        </label>

                        <label class="badge-card">
                            <input type="radio" name="expected_down_payment" value="3000000"
                                {{ isset($client) && $client->expected_down_payment == 3000000 ? 'checked' : '' }}>
                            <span data-en="Up to 3M" data-ar="حتى 3 مليون">
                                حتى 3 مليون
                            </span>
                        </label>

                        <label class="badge-card">
                            <input type="radio" name="expected_down_payment" value="5000000"
                                {{ isset($client) && $client->expected_down_payment == 5000000 ? 'checked' : '' }}>
                            <span data-en="Up to 5M" data-ar="حتى 5 مليون">
                                حتى 5 مليون
                            </span>
                        </label>

                        <label class="badge-card">
                            <input type="radio" name="expected_down_payment" value="10000000"
                                {{ isset($client) && $client->expected_down_payment == 10000000 ? 'checked' : '' }}>
                            <span data-en="Up to 10M" data-ar="حتى 10 مليون">
                                حتى 10 مليون
                            </span>
                        </label>

                        <label class="badge-card">
                            <input type="radio" name="expected_down_payment" value="15000000"
                                {{ isset($client) && $client->expected_down_payment == 15000000 ? 'checked' : '' }}>
                            <span data-en="More than 10M" data-ar="أكثر من 10 مليون">
                                أكثر من 10 مليون
                            </span>
                        </label>

                    </div>
                </div>
            </div>

            <div class="form-step" data-step="3">
                <div class="step-title" data-en="Real Estate Preferences" data-ar="التفضيلات العقارية">التفضيلات
                    العقارية</div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Purpose (Optional)"
                        data-ar="الغرض من الشراء (اختياري)"><span>الغرض</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-3">
                        <label class="badge-card"><input type="radio" name="purpose" value="residential"
                                {{ isset($client) && $client->purpose == 'residential' ? 'checked' : '' }}><span
                                data-en="Residential" data-ar="سكني">سكني</span></label>
                        <label class="badge-card"><input type="radio" name="purpose" value="investment"
                                {{ isset($client) && $client->purpose == 'investment' ? 'checked' : '' }}><span
                                data-en="Investment" data-ar="استثماري">استثماري</span></label>
                        <label class="badge-card"><input type="radio" name="purpose" value="summer"
                                {{ isset($client) && $client->purpose == 'summer' ? 'checked' : '' }}><span
                                data-en="Summer/Coastal" data-ar="ساحلي">ساحلي</span></label>
                        <label class="badge-card"><input type="radio" name="purpose" value="commercial_shop"
                                {{ isset($client) && $client->purpose == 'commercial_shop' ? 'checked' : '' }}><span
                                data-en="Commercial" data-ar="تجاري">تجاري</span></label>
                        <label class="badge-card"><input type="radio" name="purpose" value="clinic"
                                {{ isset($client) && $client->purpose == 'clinic' ? 'checked' : '' }}><span
                                data-en="Medical" data-ar="طبي (عيادة)">طبي (عيادة)</span></label>
                        <label class="badge-card"><input type="radio" name="purpose" value="office"
                                {{ isset($client) && $client->purpose == 'office' ? 'checked' : '' }}><span
                                data-en="Administrative" data-ar="إداري (مكتب)">إداري (مكتب)</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Unit Type (Optional)"
                        data-ar="نوع الوحدة (اختياري)"><span>نوع الوحدة</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-auto">
                        <label class="badge-card"><input type="radio" name="unit_type" value="apartment"
                                {{ isset($client) && $client->unit_type == 'apartment' ? 'checked' : '' }}><span
                                data-en="Apartment" data-ar="شقة">شقة</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="villa"
                                {{ isset($client) && $client->unit_type == 'villa' ? 'checked' : '' }}><span
                                data-en="Villa" data-ar="فيلا">فيلا</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="townhouse"
                                {{ isset($client) && $client->unit_type == 'townhouse' ? 'checked' : '' }}><span
                                data-en="Townhouse" data-ar="تاون هاوس">تاون هاوس</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="twinhouse"
                                {{ isset($client) && $client->unit_type == 'twinhouse' ? 'checked' : '' }}><span
                                data-en="Twinhouse" data-ar="توين هاوس">توين هاوس</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="duplex"
                                {{ isset($client) && $client->unit_type == 'duplex' ? 'checked' : '' }}><span
                                data-en="Duplex" data-ar="دوبلكس">دوبلكس</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="penthouse"
                                {{ isset($client) && $client->unit_type == 'penthouse' ? 'checked' : '' }}><span
                                data-en="Penthouse" data-ar="بنتهاوس">بنتهاوس</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="studio"
                                {{ isset($client) && $client->unit_type == 'studio' ? 'checked' : '' }}><span
                                data-en="Studio" data-ar="ستوديو">ستوديو</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="chalet"
                                {{ isset($client) && $client->unit_type == 'chalet' ? 'checked' : '' }}><span
                                data-en="Chalet" data-ar="شاليه">شاليه</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Required Area (Optional)"
                        data-ar="المساحة المفضلة (اختياري)"><span>المساحة المفضلة</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-4">
                        <label class="badge-card"><input type="radio" name="required_area" value="50"
                                {{ isset($client) && $client->required_area == 50 ? 'checked' : '' }}><span
                                data-en="Up to 90m" data-ar="حتى 90 م">حتى 90 م</span></label>
                        <label class="badge-card"><input type="radio" name="required_area" value="100"
                                {{ isset($client) && $client->required_area == 100 ? 'checked' : '' }}><span
                                data-en="100m - 150m" data-ar="100 - 150 م">100 - 150 م</span></label>
                        <label class="badge-card"><input type="radio" name="required_area" value="150"
                                {{ isset($client) && $client->required_area == 150 ? 'checked' : '' }}><span
                                data-en="150m - 200m" data-ar="150 - 200 م">150 - 200 م</span></label>
                        <label class="badge-card"><input type="radio" name="required_area" value="250"
                                {{ isset($client) && $client->required_area == 250 ? 'checked' : '' }}><span
                                data-en="200m+" data-ar="أكبر من 200 م">أكبر من 200 م</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Bedrooms (Optional)" data-ar="غرف النوم (اختياري)"><span>غرف
                            النوم</span><span class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-5">
                        <label class="badge-card"><input type="radio" name="bedrooms" value="1"
                                {{ isset($client) && $client->bedrooms == 1 ? 'checked' : '' }}><span>1</span></label>
                        <label class="badge-card"><input type="radio" name="bedrooms" value="2"
                                {{ isset($client) && $client->bedrooms == 2 ? 'checked' : '' }}><span>2</span></label>
                        <label class="badge-card"><input type="radio" name="bedrooms" value="3"
                                {{ isset($client) && $client->bedrooms == 3 ? 'checked' : '' }}><span>3</span></label>
                        <label class="badge-card"><input type="radio" name="bedrooms" value="4"
                                {{ isset($client) && $client->bedrooms == 4 ? 'checked' : '' }}><span>4</span></label>
                        <label class="badge-card"><input type="radio" name="bedrooms" value="5"
                                {{ isset($client) && $client->bedrooms == 5 ? 'checked' : '' }}><span data-en="5+"
                                data-ar="5+">5+</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Time to Purchase (Optional)"
                        data-ar="موعد الشراء المتوقع (اختياري)"><span>موعد الشراء</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-4">
                        <label class="badge-card"><input type="radio" name="purchase_time" value="immediately"
                                {{ isset($client) && $client->purchase_time == 'immediately' ? 'checked' : '' }}><span
                                data-en="Immediately" data-ar="فوراً">فوراً</span></label>
                        <label class="badge-card"><input type="radio" name="purchase_time" value="3_months"
                                {{ isset($client) && $client->purchase_time == '3_months' ? 'checked' : '' }}><span
                                data-en="3 Months" data-ar="خلال 3 أشهر">خلال 3 أشهر</span></label>
                        <label class="badge-card"><input type="radio" name="purchase_time" value="6_months"
                                {{ isset($client) && $client->purchase_time == '6_months' ? 'checked' : '' }}><span
                                data-en="6 Months" data-ar="خلال 6 أشهر">خلال 6 أشهر</span></label>
                        <label class="badge-card"><input type="radio" name="purchase_time" value="1_year"
                                {{ isset($client) && $client->purchase_time == '1_year' ? 'checked' : '' }}><span
                                data-en="1 Year+" data-ar="خلال سنة أو أكثر">خلال سنة أو أكثر</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Contact Preference (Optional)"
                        data-ar="التواصل المفضل (اختياري)"><span>التواصل المفضل</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-3">
                        <label class="badge-card"><input type="radio" name="preferred_contact" value="call"
                                {{ isset($client) && $client->preferred_contact == 'call' ? 'checked' : '' }}><span
                                data-en="Phone Call" data-ar="اتصال هاتفي">اتصال هاتفي</span></label>
                        <label class="badge-card"><input type="radio" name="preferred_contact" value="whatsapp"
                                {{ isset($client) && $client->preferred_contact == 'whatsapp' ? 'checked' : '' }}><span
                                data-en="WhatsApp" data-ar="واتساب">واتساب</span></label>
                        <label class="badge-card"><input type="radio" name="contact_time" value="anytime"
                                {{ isset($client) && $client->contact_time == 'anytime' ? 'checked' : '' }}><span
                                data-en="Anytime" data-ar="في أي وقت">في أي وقت</span></label>
                    </div>
                </div>

                <div class="marketing-checkbox mt-4">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="agree_marketing" value="1"
                            {{ !isset($client) || $client->agree_marketing ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <span class="checkbox-text" data-en="I agree to receive exclusive updates."
                            data-ar="أوافق على تلقي العروض والتحديثات الحصرية.">أوافق على تلقي العروض والتحديثات
                            الحصرية.</span>
                    </label>
                </div>
            </div>

            <div class="form-navigation-actions">
                <button type="button" id="btn-prev" class="btn-form-secondary hidden" data-en="Back"
                    data-ar="السابق">السابق</button>
                <button type="button" id="btn-next" class="btn-form-primary" data-en="Next Step"
                    data-ar="الخطوة التالية">الخطوة التالية</button>
                <button type="submit" id="btn-submit" class="btn-form-primary hidden"
                    data-en="{{ isset($client) ? 'Save Updates' : 'Submit' }}"
                    data-ar="{{ isset($client) ? 'حفظ التحديثات' : 'تأكيد وإرسال' }}">{{ isset($client) ? 'حفظ التحديثات' : 'تأكيد وإرسال' }}</button>
            </div>
        </form>

        <div id="form-success-overlay" class="form-success-overlay hidden">
            <div class="success-message-card">
                <div class="success-icon-animated">
                    <svg viewBox="0 0 52 52">
                        <circle class="success-circle" cx="26" cy="26" r="25" fill="none" />
                        <path class="success-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                    </svg>
                </div>
                <h3 data-en="Thank You!" data-ar="تم بنجاح!">تم بنجاح!</h3>
                <p data-en="Your preferences have been saved securely."
                    data-ar="تم حفظ تفضيلاتك بنجاح. سيقوم أحد مستشارينا بالتواصل معك.">تم حفظ تفضيلاتك بنجاح. سيقوم أحد
                    مستشارينا بالتواصل معك.</p>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("smart-interest-form");
        const steps = document.querySelectorAll(".form-step");
        const stepIndicators = document.querySelectorAll(".step-indicator");
        const progressBar = document.getElementById("form-progress");
        const btnNext = document.getElementById("btn-next");
        const btnPrev = document.getElementById("btn-prev");
        const btnSubmit = document.getElementById("btn-submit");
        const successOverlay = document.getElementById("form-success-overlay");
        const photoInput = document.getElementById("photo-input");
        const fileNamePreview = document.getElementById("file-name-preview");
        const isUpdate = {{ isset($client) ? 'true' : 'false' }};

        let currentStep = 1;
        const totalSteps = steps.length;

        if (photoInput) {
            photoInput.addEventListener("change", (e) => {
                fileNamePreview.textContent = e.target.files.length > 0 ? e.target.files[0].name : "";
            });
        }

        function updateFormSteps() {
            steps.forEach(step => {
                step.classList.remove("active");
                if (parseInt(step.dataset.step) === currentStep) step.classList.add("active");
            });

            stepIndicators.forEach(indicator => {
                const stepNum = parseInt(indicator.dataset.step);
                indicator.classList.remove("active", "completed");
                if (stepNum === currentStep) indicator.classList.add("active");
                else if (stepNum < currentStep) indicator.classList.add("completed");
            });

            progressBar.style.width = `${((currentStep - 1) / (totalSteps - 1)) * 100}%`;

            btnPrev.classList.toggle("hidden", currentStep === 1);
            btnNext.classList.toggle("hidden", currentStep === totalSteps);
            btnSubmit.classList.toggle("hidden", currentStep !== totalSteps);
        }

        function validateStepInputs() {
            const activeStepEl = document.querySelector(`.form-step[data-step="${currentStep}"]`);
            const requiredInputs = activeStepEl.querySelectorAll("input[required]");
            let isValid = true;

            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = "var(--primary-red, #B40000)";
                } else {
                    input.style.borderColor = "rgba(118, 118, 122, 0.3)";
                }
            });
            return isValid;
        }

        function adjustPlaceholders() {
            const lang = window.preferences?.lang || "ar";
            form.querySelectorAll("[data-placeholder-ar]").forEach(input => {
                input.placeholder = input.getAttribute(lang === "ar" ? "data-placeholder-ar" :
                    "data-placeholder-en");
            });
        }

        btnNext.addEventListener("click", () => {
            if (validateStepInputs() && currentStep < totalSteps) {
                currentStep++;
                updateFormSteps();
            }
        });

        btnPrev.addEventListener("click", () => {
            if (currentStep > 1) {
                currentStep--;
                updateFormSteps();
            }
        });

        window.addEventListener("preferencesChanged", adjustPlaceholders);
        adjustPlaceholders();

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            btnSubmit.disabled = true;

            const lang = window.preferences?.lang || "ar";
            btnSubmit.textContent = lang === "en" ? "Processing..." : "جاري الإرسال...";

            const formData = new FormData(form);
            formData.append("theme", window.preferences?.theme === "light" ? "light" : "dark");
            formData.append("lang", lang);
            formData.set("agree_marketing", form.agree_marketing.checked ? "1" : "0");

            try {
                const response = await fetch('/api/v1/client/register-interest', {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": formData.get("_token"),
                        "Accept": "application/json"
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    successOverlay.classList.remove("hidden");
                    if (!isUpdate) {
                        form.reset();
                        if (fileNamePreview) fileNamePreview.textContent = "";
                    } else {
                        setTimeout(() => {
                            successOverlay.classList.add("hidden");
                            btnSubmit.disabled = false;
                            btnSubmit.textContent = lang === "en" ? "Save Updates" :
                                "حفظ التحديثات";
                        }, 2500);
                    }
                } else {
                    alert(result.errors ? Object.values(result.errors).flat().join("\n") : (result
                        .message || "حدث خطأ."));
                    btnSubmit.disabled = false;
                    btnSubmit.textContent = lang === "en" ? "Submit" : "تأكيد وإرسال";
                }
            } catch (error) {
                alert(lang === "en" ? "Connection failed." : "فشل الاتصال بالخادم.");
                btnSubmit.disabled = false;
                btnSubmit.textContent = lang === "en" ? "Submit" : "تأكيد وإرسال";
            }
        });
    });
</script>

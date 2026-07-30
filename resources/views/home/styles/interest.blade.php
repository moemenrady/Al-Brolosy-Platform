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
</style>

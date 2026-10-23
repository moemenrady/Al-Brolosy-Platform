@extends('layouts.page')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

@section('title', app()->getLocale() == 'ar' ? $job->title_ar . ' | البرلسي' : $job->title_en . ' | Albrolosy')

@section('breadcrumb')
    <a href="{{ route('jobs.index') }}" data-ar="الوظائف" data-en="Jobs">
        {{ app()->getLocale() == 'ar' ? 'الوظائف' : 'Jobs' }}
    </a>
    <span>/</span>
    <span class="current-page" data-ar="{{ $job->title_ar }}" data-en="{{ $job->title_en }}">
        {{ $job->title }}
    </span>
@endsection

@section('page_title')
    <span data-ar="{{ $job->title_ar }}" data-en="{{ $job->title_en }}">
        {{ $job->title }}
    </span>
@endsection

@section('page_subtitle')
    <div class="hero-job-meta">
        <span class="meta-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span data-ar="{{ $job->location_ar }}" data-en="{{ $job->location_en }}">{{ $job->location }}</span>
        </span>
        <span class="meta-dot">•</span>
        <span class="meta-item job-type-highlight" data-ar="{{ __('نوع الوظيفة: ' . $job->type) }}"
            data-en="{{ ucfirst($job->type) }}">
            {{ app()->getLocale() == 'ar' ? 'نوع الوظيفة: ' . $job->type : ucfirst($job->type) }}
        </span>
    </div>
@endsection

@push('styles')
    <style>
        /* ===================================== */
        /* 1. Job Show Grid Layout               */
        /* ===================================== */
        .job-show-wrapper {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
            position: relative;
        }

        @media (min-width: 1024px) {
            .job-show-wrapper {
                grid-template-columns: 1.8fr 1fr;
            }
        }

        /* ===================================== */
        /* 2. Job Details Column                 */
        /* ===================================== */
        .job-details-col {
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }

        .detail-section {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUpLux 0.6s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        .detail-section:nth-child(2) {
            animation-delay: 0.1s;
        }

        .detail-section:nth-child(3) {
            animation-delay: 0.2s;
        }

        .section-heading {
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .section-heading svg {
            width: 24px;
            height: 24px;
            stroke: var(--text);
        }

        .detail-text {
            color: var(--text);
            font-size: 1.1rem;
            line-height: 1.8;
            white-space: pre-line;
            /* للحفاظ على تنسيق الأسطر من الداتابيز */
        }

        .lux-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .lux-list li {
            position: relative;
            padding: 0.5rem 0 0.5rem 2rem;
            color: var(--text);
            font-size: 1.05rem;
            line-height: 1.6;
            border-bottom: 1px dashed var(--border);
        }

        html[dir="rtl"] .lux-list li {
            padding: 0.5rem 2rem 0.5rem 0;
        }

        .lux-list li:last-child {
            border-bottom: none;
        }

        .lux-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            top: 0.6rem;
            color: var(--primary);
            font-weight: bold;
        }

        html[dir="rtl"] .lux-list li::before {
            left: auto;
            right: 0;
        }

        /* ===================================== */
        /* 3. Application Form (Sticky Sidebar)  */
        /* ===================================== */
        .job-apply-col {
            position: relative;
        }

        .apply-sticky-card {
            position: sticky;
            top: calc(var(--header-h) + 20px);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2.5rem;
            box-shadow: var(--shadow-lux);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUpLux 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
            animation-delay: 0.3s;
        }

        .apply-title {
            font-size: 1.4rem;
            color: var(--text);
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: var(--muted);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            background: var(--surface-2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 1rem;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            transition: all var(--transition);
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(180, 0, 0, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* تصميم مخصص لرفع الملف (CV) */
        .file-upload-wrapper {
            position: relative;
            border: 2px dashed var(--border);
            border-radius: var(--radius-sm);
            padding: 2rem 1rem;
            text-align: center;
            background: var(--surface-2);
            transition: all var(--transition);
            cursor: pointer;
        }

        .file-upload-wrapper:hover {
            border-color: var(--primary);
            background: rgba(180, 0, 0, 0.02);
        }

        .file-upload-input {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }

        .file-upload-text {
            color: var(--text);
            font-size: 0.95rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .file-upload-text svg {
            width: 32px;
            height: 32px;
            color: var(--primary);
        }

        .btn-submit {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 1rem;
            border-radius: var(--radius-sm);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-submit:hover {
            background: #900000;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(180, 0, 0, 0.2);
        }

        /* حالة النجاح / التقديم المسبق */
        .status-alert {
            padding: 2rem;
            border-radius: var(--radius-sm);
            text-align: center;
            border: 1px solid;
        }

        .status-success {
            background: rgba(40, 167, 69, 0.1);
            border-color: var(--success);
            color: var(--success);
        }

        .status-warning {
            background: rgba(220, 53, 69, 0.1);
            border-color: var(--danger);
            color: var(--text);
        }

        .status-alert svg {
            width: 48px;
            height: 48px;
            margin-bottom: 1rem;
        }

        /* Alert messages */
        .invalid-feedback {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.4rem;
            display: block;
        }

        .hero-job-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--muted);
            font-size: 1rem;
        }

        .meta-item svg {
            width: 18px;
            height: 18px;
        }

        .job-type-highlight {
            color: var(--primary);
            font-weight: 600;
        }

        @keyframes fadeInUpLux {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="job-show-wrapper">
        <div class="job-details-col">

            <div class="detail-section">
                <h2 class="section-heading">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <polyline points="14 2 14 8 20 8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <line x1="16" y1="13" x2="8" y2="13" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <line x1="16" y1="17" x2="8" y2="17" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <polyline points="10 9 9 9 8 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span data-ar="وصف الوظيفة"
                        data-en="Job Description">{{ app()->getLocale() == 'ar' ? 'وصف الوظيفة' : 'Job Description' }}</span>
                </h2>
                <div class="detail-text" data-ar="{{ $job->description_ar }}" data-en="{{ $job->description_en }}">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </div>

            @if ($job->main_tasks_ar || $job->main_tasks_en)
                <div class="detail-section">
                    <h2 class="section-heading">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <span data-ar="المهام الرئيسية"
                            data-en="Main Tasks">{{ app()->getLocale() == 'ar' ? 'المهام الرئيسية' : 'Main Tasks' }}</span>
                    </h2>
                    <div class="detail-text" data-ar="{{ $job->main_tasks_ar }}" data-en="{{ $job->main_tasks_en }}">
                        {!! nl2br(e($job->main_tasks)) !!}
                    </div>
                </div>
            @endif

            @if ($job->required_skills_ar || $job->required_skills_en)
                <div class="detail-section">
                    <h2 class="section-heading">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                            </polygon>
                        </svg>
                        <span data-ar="المهارات المطلوبة"
                            data-en="Required Skills">{{ app()->getLocale() == 'ar' ? 'المهارات المطلوبة' : 'Required Skills' }}</span>
                    </h2>
                    <div class="detail-text" data-ar="{{ $job->required_skills_ar }}"
                        data-en="{{ $job->required_skills_en }}">
                        {!! nl2br(e($job->required_skills)) !!}
                    </div>
                </div>
            @endif

        </div>

        <div class="job-apply-col">
            <div class="apply-sticky-card">

                @if (session('success'))
                    <div class="status-alert status-success">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <h3 data-ar="تم التقديم بنجاح!" data-en="Applied Successfully!">
                            {{ app()->getLocale() == 'ar' ? 'تم التقديم بنجاح!' : 'Applied Successfully!' }}
                        </h3>
                        <p data-ar="تم إرسال طلبك، يمكنك متابعته من لوحة التحكم الخاصة بك."
                            data-en="Your application has been submitted, you can track it from your dashboard.">
                            {{ app()->getLocale() == 'ar' ? 'تم إرسال طلبك، يمكنك متابعته من لوحة التحكم الخاصة بك.' : 'Your application has been submitted, you can track it from your dashboard.' }}
                        </p>
                    </div>
                @elseif($alreadyApplied)
                    <div class="status-alert status-warning">
                        <svg viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <h3 data-ar="لقد قمت بالتقديم مسبقاً" data-en="You have already applied">
                            {{ app()->getLocale() == 'ar' ? 'لقد قمت بالتقديم مسبقاً' : 'You have already applied' }}
                        </h3>
                        <p data-ar="جاري مراجعة طلبك من قبل فريق الموارد البشرية. تابع الحالة من حسابك."
                            data-en="Your application is being reviewed by the HR team. Check the status in your account.">
                            {{ app()->getLocale() == 'ar' ? 'جاري مراجعة طلبك من قبل فريق الموارد البشرية. تابع الحالة من حسابك.' : 'Your application is being reviewed by the HR team. Check the status in your account.' }}
                        </p>
                        <a href="{{ route('jobs.applications') }}" class="btn-submit"
                            style="display:inline-block; text-align:center; margin-top:1rem; text-decoration:none;">
                            <span data-ar="متابعة طلباتي" data-en="Track My Applications">
                                {{ app()->getLocale() == 'ar' ? 'متابعة طلباتي' : 'Track My Applications' }}
                            </span>
                        </a>
                    </div>
                @elseif(!auth()->check())
                    <div class="status-alert" style="border-color: var(--border);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <h3 data-ar="يرجى تسجيل الدخول للتقديم" data-en="Please login to apply">
                            {{ app()->getLocale() == 'ar' ? 'يرجى تسجيل الدخول للتقديم' : 'Please login to apply' }}
                        </h3>
                        <div style="display:flex; gap:1rem; justify-content:center; margin-top:1.5rem;">
                            <a href="{{ route('login') }}" class="btn-submit"
                                style="text-decoration:none; padding: 0.8rem 1.5rem;">
                                <span data-ar="تسجيل الدخول"
                                    data-en="Login">{{ app()->getLocale() == 'ar' ? 'تسجيل الدخول' : 'Login' }}</span>
                            </a>
                         
                        </div>
                    </div>
                @else
                    <h3 class="apply-title" data-ar="قدم على هذه الوظيفة" data-en="Apply for this job">
                        {{ app()->getLocale() == 'ar' ? 'قدم على هذه الوظيفة' : 'Apply for this job' }}
                    </h3>
                    <form action="{{ route('jobs.apply', $job->id) }}" method="POST" enctype="multipart/form-data"
                        id="jobApplyForm">
                        @csrf

                        <div class="form-group">
                            <label class="form-label" data-ar="الاسم الرباعي"
                                data-en="Full Name">{{ app()->getLocale() == 'ar' ? 'الاسم الرباعي' : 'Full Name' }}</label>
                            <input type="text" name="full_name" class="form-control"
                                value="{{ old('full_name', auth()->user()->name ?? '') }}" required>
                            @error('full_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" data-ar="البريد الإلكتروني"
                                data-en="Email Address">{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" data-ar="رقم الهاتف (واتساب)"
                                data-en="Phone Number (WhatsApp)">{{ app()->getLocale() == 'ar' ? 'رقم الهاتف (واتساب)' : 'Phone Number (WhatsApp)' }}</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                                required dir="ltr">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" data-ar="السيرة الذاتية (PDF, DOCX)"
                                data-en="Resume/CV (PDF, DOCX)">{{ app()->getLocale() == 'ar' ? 'السيرة الذاتية (PDF, DOCX)' : 'Resume/CV (PDF, DOCX)' }}</label>
                            <div class="file-upload-wrapper" id="fileDropArea">
                                <input type="file" name="cv" id="cvInput" class="file-upload-input"
                                    accept=".pdf,.doc,.docx" required>
                                <div class="file-upload-text">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                    </svg>
                                    <span id="fileNameDisplay" data-ar="اضغط أو اسحب الملف هنا للرفع"
                                        data-en="Click or drag file here to upload">
                                        {{ app()->getLocale() == 'ar' ? 'اضغط أو اسحب الملف هنا للرفع' : 'Click or drag file here to upload' }}
                                    </span>
                                </div>
                            </div>
                            @error('cv')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" data-ar="رسالة توضيحية (اختياري)"
                                data-en="Cover Letter (Optional)">{{ app()->getLocale() == 'ar' ? 'رسالة توضيحية (اختياري)' : 'Cover Letter (Optional)' }}</label>
                            <textarea name="message" class="form-control" rows="4">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit" id="submitBtn">
                            <span data-ar="إرسال الطلب"
                                data-en="Submit Application">{{ app()->getLocale() == 'ar' ? 'إرسال الطلب' : 'Submit Application' }}</span>
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('related_content')
    @if (isset($relatedJobs) && $relatedJobs->count() > 0)
        <div style="margin-bottom: 2rem; text-align: center;">
            <h2 style="font-size: 2rem; color: var(--text);" data-ar="وظائف مشابهة قد تهمك"
                data-en="Similar Jobs You Might Like">
                {{ app()->getLocale() == 'ar' ? 'وظائف مشابهة قد تهمك' : 'Similar Jobs You Might Like' }}
            </h2>
            <div style="width: 60px; height: 3px; background: var(--primary); margin: 1rem auto;"></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            @foreach ($relatedJobs as $rJob)
                <a href="{{ route('jobs.show', $rJob->id) }}" class="card-component js-scroll-animate"
                    style="text-decoration: none; display: flex; flex-direction: column; opacity:0;">

                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <span
                            style="background: rgba(180, 0, 0, 0.1); color: var(--primary); padding: 0.3rem 0.8rem; border-radius: 50px; font-size: 0.8rem; font-weight: bold;"
                            data-ar="{{ __('نوع الوظيفة: ' . $rJob->type) }}" data-en="{{ ucfirst($rJob->type) }}">
                            {{ $rJob->type }}
                        </span>
                    </div>

                    <h3 style="font-size: 1.3rem; color: var(--text); margin-bottom: 0.8rem;"
                        data-ar="{{ $rJob->title_ar }}" data-en="{{ $rJob->title_en }}">
                        {{ $rJob->title }}
                    </h3>

                    <div
                        style="display: flex; align-items: center; gap: 0.5rem; color: var(--muted); font-size: 0.9rem; margin-bottom: 1.5rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span data-ar="{{ $rJob->location_ar }}"
                            data-en="{{ $rJob->location_en }}">{{ $rJob->location }}</span>
                    </div>

                    <div
                        style="margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--border); color: var(--primary); font-size: 0.9rem; display: flex; justify-content: space-between; align-items: center;">
                        <span data-ar="عرض التفاصيل"
                            data-en="View Details">{{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // 1. ترجمة المحتوى الأولي عبر الجلوبل كلاس إذا لزم الأمر
            if (window.preferences && typeof window.preferences.translate === 'function') {
                window.preferences.translate();
            }

            // 2. سكريبت واجهة رفع الملفات (UX)
            const cvInput = document.getElementById('cvInput');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const dropArea = document.getElementById('fileDropArea');
            const submitBtn = document.getElementById('submitBtn');

            if (cvInput && fileNameDisplay) {
                // تحديث اسم الملف عند الاختيار
                cvInput.addEventListener('change', function(e) {
                    if (this.files && this.files.length > 0) {
                        const fileName = this.files[0].name;
                        fileNameDisplay.textContent = fileName;
                        fileNameDisplay.style.color = "var(--primary)";
                        fileNameDisplay.style.fontWeight = "bold";
                    } else {
                        // إعادة النص الافتراضي
                        const isAr = document.documentElement.lang === 'ar';
                        fileNameDisplay.textContent = isAr ? 'اضغط أو اسحب الملف هنا للرفع' :
                            'Click or drag file here to upload';
                        fileNameDisplay.style.color = "";
                        fileNameDisplay.style.fontWeight = "normal";
                    }
                });

                // تأثيرات السحب والإفلات (Drag & Drop UX)
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropArea.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, unhighlight, false);
                });

                function highlight(e) {
                    dropArea.style.borderColor = 'var(--primary)';
                    dropArea.style.background = 'rgba(180, 0, 0, 0.05)';
                }

                function unhighlight(e) {
                    dropArea.style.borderColor = 'var(--border)';
                    dropArea.style.background = 'var(--surface-2)';
                }

                dropArea.addEventListener('drop', handleDrop, false);

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    if (files.length > 0) {
                        cvInput.files = files; // تعيين الملف للإدخال
                        cvInput.dispatchEvent(new Event('change')); // إطلاق الحدث لتغيير النص
                    }
                }
            }

            // حماية النموذج من الضغط المزدوج
            const form = document.getElementById('jobApplyForm');
            if (form && submitBtn) {
                form.addEventListener('submit', function() {
                    submitBtn.style.opacity = '0.7';
                    submitBtn.style.pointerEvents = 'none';
                    const isAr = document.documentElement.lang === 'ar';
                    submitBtn.innerHTML =
                        `<span style="display:inline-block; animation: spin 1s linear infinite;">↻</span> ${isAr ? 'جاري الإرسال...' : 'Submitting...'}`;
                });
            }

            // 3. حركة ظهور العناصر عند التمرير (Scroll Animation) للوظائف المشابهة
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.animation =
                                "fadeInUpLux 0.6s cubic-bezier(0.25, 1, 0.5, 1) forwards";
                        }, index * 100);
                        obs.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.js-scroll-animate').forEach(card => {
                observer.observe(card);
            });
        });
    </script>
@endpush

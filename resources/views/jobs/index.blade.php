@extends('layouts.page')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

@section('title', app()->getLocale() == 'ar' ? 'الوظائف | البرلسي' : 'Jobs | Albrolosy')

@section('breadcrumb')
    <span data-ar="الوظائف" data-en="Jobs">{{ app()->getLocale() == 'ar' ? 'الوظائف' : 'Jobs' }}</span>
@endsection

@section('page_title')
    <span data-ar="انضم إلى فريقنا" data-en="Join Our Team">
        {{ app()->getLocale() == 'ar' ? 'انضم إلى فريقنا' : 'Join Our Team' }}
    </span>
@endsection

@section('page_subtitle')
    <span data-ar="اكتشف أحدث فرص العمل وكن جزءاً من نجاحنا في البرلسي للتطوير العقاري."
        data-en="Discover the latest job opportunities and be part of our success at Albrolosy Real Estate.">
        {{ app()->getLocale() == 'ar' ? 'اكتشف أحدث فرص العمل وكن جزءاً من نجاحنا في البرلسي للتطوير العقاري.' : 'Discover the latest job opportunities and be part of our success at Albrolosy Real Estate.' }}
    </span>
@endsection

@section('content')
    <style>
        /* ===================================== */
        /* 1. إعدادات الفلاتر (Filters & Search) */
        /* ===================================== */
        .jobs-filters-wrapper {
            margin-bottom: 3rem;
            position: relative;
            z-index: 10;
        }

        .filter-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            background: var(--surface);
            padding: 1rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lux);
            transition: all var(--transition);
        }

        @media (min-width: 768px) {
            .filter-form {
                flex-direction: row;
                align-items: center;
                padding: 1.5rem;
            }
        }

        .filter-input-group {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
        }

        .filter-input-group svg {
            position: absolute;
            left: 1rem;
            color: var(--muted);
            width: 20px;
            height: 20px;
            pointer-events: none;
        }

        html[dir="rtl"] .filter-input-group svg {
            left: auto;
            right: 1rem;
        }

        .filter-input,
        .filter-select {
            width: 100%;
            background: var(--surface-2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 1rem 1rem 1rem 3rem;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            transition: all var(--transition);
            outline: none;
            appearance: none;
        }

        html[dir="rtl"] .filter-input,
        html[dir="rtl"] .filter-select {
            padding: 1rem 3rem 1rem 1rem;
        }

        .filter-input:focus,
        .filter-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(180, 0, 0, 0.1);
        }

        /* Loading Spinner for Auto-submit */
        .search-loader {
            position: absolute;
            right: 1rem;
            width: 20px;
            height: 20px;
            border: 2px solid var(--border);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s;
        }

        html[dir="rtl"] .search-loader {
            right: auto;
            left: 1rem;
        }

        .search-loader.active {
            opacity: 1;
            visibility: visible;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ===================================== */
        /* 2. شبكة الوظائف (Jobs Grid & Cards)   */
        /* ===================================== */
        .jobs-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .jobs-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .jobs-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .job-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all var(--transition);
            text-decoration: none;
            opacity: 0;
            transform: translateY(20px);
            will-change: transform, opacity;
        }

        .job-card.show-card {
            animation: fadeInUpLux 0.6s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        .job-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary);
            box-shadow: var(--shadow-lux);
        }

        .job-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            transform: scaleX(0);
            transition: transform 0.5s ease;
        }

        .job-card:hover::before {
            transform: scaleX(1);
        }

        .job-meta-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .job-type-badge {
            background: rgba(180, 0, 0, 0.1);
            color: var(--primary);
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .job-title {
            font-size: 1.4rem;
            color: var(--text);
            margin-bottom: 1rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .job-location {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--muted);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        .job-desc-preview {
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }

        .btn-discover {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
            color: var(--text);
            font-size: 0.95rem;
            font-weight: 600;
            transition: color 0.3s;
        }

        .btn-discover svg {
            width: 20px;
            height: 20px;
            transition: transform 0.3s;
        }

        .job-card:hover .btn-discover {
            color: var(--primary);
        }

        .job-card:hover .btn-discover svg {
            transform: translateX(5px);
            stroke: var(--primary);
        }

        html[dir="rtl"] .job-card:hover .btn-discover svg {
            transform: translateX(-5px);
        }

        @keyframes fadeInUpLux {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===================================== */
        /* 3. Empty State (حالة عدم وجود نتائج)  */
        /* ===================================== */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            background: var(--surface-2);
            border: 1px dashed var(--border);
            border-radius: var(--radius);
        }

        .empty-state svg {
            width: 64px;
            height: 64px;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .empty-state h3 {
            color: var(--text);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--muted);
            margin-bottom: 2rem;
        }

        .btn-reset {
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            padding: 0.8rem 2rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            transition: opacity 0.3s;
            display: inline-block;
        }

        .btn-reset:hover {
            opacity: 0.9;
        }

        /* Pagination */
        .custom-pagination {
            margin-top: 4rem;
            display: flex;
            justify-content: center;
        }
    </style>

    <!-- شريط البحث السريع والذكي -->
    <div class="jobs-filters-wrapper">
        <form action="{{ route('jobs.index') }}" method="GET" class="filter-form" id="jobsSearchForm">

            <div class="filter-input-group">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="search" class="filter-input" value="{{ request('search') }}"
                    data-placeholder-ar="ابحث عن مسمى وظيفي أو مدينة..."
                    data-placeholder-en="Search by job title or city..."
                    placeholder="{{ app()->getLocale() == 'ar' ? 'ابحث عن مسمى وظيفي أو مدينة...' : 'Search by job title or city...' }}">
                <div class="search-loader" id="searchLoader"></div>
            </div>

            <div class="filter-input-group" style="flex: 0.5;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <select name="type" class="filter-select">
                    <option value="" data-ar="جميع الأنواع" data-en="All Types">
                        {{ app()->getLocale() == 'ar' ? 'جميع الأنواع' : 'All Types' }}</option>
                    <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }} data-ar="دوام كامل"
                        data-en="Full Time">Full Time</option>
                    <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }} data-ar="دوام جزئي"
                        data-en="Part Time">Part Time</option>
                    <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }} data-ar="عقد"
                        data-en="Contract">Contract</option>
                </select>
            </div>

            <!-- زر البحث تم إزالته بالكامل ليحل محله البحث التلقائي -->
        </form>
    </div>

    <!-- شبكة عرض الوظائف -->
    @if ($jobs->count() > 0)
        <div class="jobs-grid" id="jobsGrid">
            @foreach ($jobs as $job)
                <a href="{{ url('/jobs/' . $job->id) }}" class="job-card js-scroll-animate">
                    <div class="job-meta-top">
                        <span class="job-type-badge" data-ar="{{ __('نوع الوظيفة: ' . $job->type) }}"
                            data-en="{{ ucfirst($job->type) }}">
                            {{ app()->getLocale() == 'ar' ? 'نوع الوظيفة: ' . $job->type : ucfirst($job->type) }}
                        </span>

                        @if ($job->featured)
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="var(--primary)"
                                stroke="var(--primary)" stroke-width="2">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                </polygon>
                            </svg>
                        @endif
                    </div>

                    <h3 class="job-title" data-ar="{{ $job->title_ar }}" data-en="{{ $job->title_en }}">
                        {{ $job->title }}
                    </h3>

                    <div class="job-location">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span data-ar="{{ $job->location_ar }}" data-en="{{ $job->location_en }}">
                            {{ $job->location }}
                        </span>
                    </div>

                    <p class="job-desc-preview" data-ar="{{ Str::limit($job->description_ar, 120) }}"
                        data-en="{{ Str::limit($job->description_en, 120) }}">
                        {{ Str::limit($job->description, 120) }}
                    </p>

                    <div class="btn-discover">
                        <span data-ar="التفاصيل والتقديم" data-en="View & Apply">
                            {{ app()->getLocale() == 'ar' ? 'التفاصيل والتقديم' : 'View & Apply' }}
                        </span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="custom-pagination">
            {{ $jobs->links() }}
        </div>
    @else
        <div class="empty-state show-card js-scroll-animate">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <h3 data-ar="لا توجد وظائف مطابقة" data-en="No matching jobs found">
                {{ app()->getLocale() == 'ar' ? 'لا توجد وظائف مطابقة' : 'No matching jobs found' }}
            </h3>
            <p data-ar="يرجى تعديل الفلاتر أو المحاولة لاحقاً." data-en="Please adjust your filters or try again later.">
                {{ app()->getLocale() == 'ar' ? 'يرجى تعديل الفلاتر أو المحاولة لاحقاً.' : 'Please adjust your filters or try again later.' }}
            </p>
            <a href="{{ route('jobs.index') }}" class="btn-reset">
                <span data-ar="إعادة ضبط البحث" data-en="Reset Search">
                    {{ app()->getLocale() == 'ar' ? 'إعادة ضبط البحث' : 'Reset Search' }}
                </span>
            </a>
        </div>
    @endif

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // 1. منطق البحث التلقائي (Auto-Submit with Debounce)
                const form = document.getElementById('jobsSearchForm');
                const inputs = form.querySelectorAll('input, select');
                const loader = document.getElementById('searchLoader');
                let typingTimer;
                const doneTypingInterval = 600; // الإنتظار 0.6 ثانية بعد التوقف عن الكتابة

                inputs.forEach(input => {
                    // للتعامل مع حقل النص
                    if (input.type === 'text') {
                        input.addEventListener('keyup', () => {
                            clearTimeout(typingTimer);
                            loader.classList.add('active');
                            typingTimer = setTimeout(() => {
                                form.submit();
                            }, doneTypingInterval);
                        });
                        input.addEventListener('keydown', () => {
                            clearTimeout(typingTimer);
                        });
                    }
                    // للتعامل مع الـ Dropdown (select)
                    else if (input.tagName === 'SELECT') {
                        input.addEventListener('change', () => {
                            loader.classList.add('active');
                            form.submit();
                        });
                    }
                });

                // منع إرسال النموذج عند الضغط على Enter لمنع الـ Reload المزدوج
                form.addEventListener('submit', (e) => {
                    if (loader.classList.contains('active') === false) {
                        loader.classList.add('active');
                    }
                });

                // 2. حركة ظهور الكروت باحترافية (Scroll Stagger Animation)
                const observerOptions = {
                    root: null,
                    rootMargin: '0px',
                    threshold: 0.1
                };

                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach((entry, index) => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                entry.target.classList.add('show-card');
                            }, index * 100);
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                document.querySelectorAll('.js-scroll-animate').forEach(card => {
                    observer.observe(card);
                });

                // 3. تحديث الترجمة فورا في حال كان الـ Preferences Class جاهزاً
                // (لمعالجة أي محتوى تم إضافته أو تحديثه للتو)
                if (window.preferences && typeof window.preferences.translate === 'function') {
                    window.preferences.translate();
                }
            });
        </script>
    @endpush
@endsection

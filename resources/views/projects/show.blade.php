@extends('layouts.page')

@section('title', $project->name . ' | Albrolosy Real Estate')

@section('breadcrumb')
    <a href="/projects">{{ app()->getLocale() == 'ar' ? 'المشاريع' : 'Projects' }}</a>
    <span>/</span>
    <span>{{ $project->name }}</span>
@endsection

@section('page_title', $project->name)
@section('page_subtitle', $project->sector->name ?? '')

@push('styles')
    <style>
        /* ===================================== */
        /* Animations & Utilities                */
        /* ===================================== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-marker {
            0% {
                box-shadow: 0 0 0 0 rgba(180, 0, 0, 0.7);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(180, 0, 0, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(180, 0, 0, 0);
            }
        }

        @keyframes spin-slow {
            100% {
                transform: rotate(360deg);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
            opacity: 0;
        }

        /* ===================================== */
        /* Layout Grids                          */
        /* ===================================== */
        .project-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }

        @media (min-width: 1024px) {
            .project-grid {
                grid-template-columns: 2fr 1fr;
            }
        }

        .section-title {
            font-size: 1.5rem;
            color: var(--text);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 0.8rem;
        }

        .section-title svg {
            width: 24px;
            height: 24px;
            color: var(--primary);
        }

        /* ===================================== */
        /* Sticky Sidebar Summary                */
        /* ===================================== */
        .summary-card {
            position: sticky;
            top: calc(var(--header-h) + 20px);
            background: var(--surface-2);
            padding: 2rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lux);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px dashed var(--border);
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-label {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .summary-value {
            font-weight: 600;
            color: var(--text);
            font-size: 1rem;
            text-align: end;
        }

        .summary-value.highlight {
            color: var(--primary);
            font-size: 1.2rem;
        }

        /* ===================================== */
        /* Features Grid                         */
        /* ===================================== */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .feature-item {
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 1.5rem 1rem;
            border-radius: var(--radius-sm);
            text-align: center;
            transition: transform var(--transition);
        }

        .feature-item:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
        }

        .feature-item .val {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .feature-item .lbl {
            font-size: 0.85rem;
            color: var(--muted);
        }

        /* ===================================== */
        /* Location Animation Map                */
        /* ===================================== */
        .location-wrapper {
            position: relative;
            width: 100%;
            height: 300px;
            background: url('{{ $project->image ? asset('images/projects/' . $project->image) : '' }}') center/cover;
            border-radius: var(--radius);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            margin-top: 1rem;
        }

        .location-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(3px);
        }

        .location-marker-btn {
            position: relative;
            z-index: 10;
            background: var(--primary);
            color: #fff;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            animation: pulse-marker 2s infinite;
            transition: transform var(--transition);
        }

        .location-marker-btn:hover {
            transform: scale(1.1);
        }

        .location-marker-btn svg {
            width: 30px;
            height: 30px;
            fill: currentColor;
        }

        .location-text-overlay {
            position: absolute;
            bottom: 20px;
            z-index: 10;
            color: #fff;
            text-align: center;
            font-weight: 600;
            font-size: 1.1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* ===================================== */
        /* Units Cards Showcase                  */
        /* ===================================== */
        .units-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .unit-card {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }

        .unit-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
            box-shadow: var(--shadow-lux);
        }

        .unit-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary);
            opacity: 0;
            transition: opacity var(--transition);
        }

        .unit-card:hover::before {
            opacity: 1;
        }

        .unit-type-badge {
            display: inline-block;
            background: rgba(180, 0, 0, 0.1);
            color: var(--primary);
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .unit-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 1rem;
        }

        .unit-specs {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .unit-spec-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: var(--muted);
            border-bottom: 1px solid rgba(128, 128, 128, 0.1);
            padding-bottom: 0.5rem;
        }

        .unit-spec-row:last-child {
            border: none;
            padding: 0;
        }

        .unit-spec-row span:last-child {
            color: var(--text);
            font-weight: 600;
        }

        /* ===================================== */
        /* Gallery with Pagination               */
        /* ===================================== */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .gallery-item {
            border-radius: var(--radius-sm);
            overflow: hidden;
            aspect-ratio: 4/3;
            display: none;
            /* مخفي افتراضياً للباجينيشن */
            animation: fadeInUp 0.5s ease forwards;
        }

        .gallery-item.active {
            display: block;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .load-more-container {
            text-align: center;
            margin-top: 2rem;
        }

        .btn-load-more {
            background: var(--surface-2);
            color: var(--text);
            border: 1px solid var(--primary);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .btn-load-more:hover {
            background: var(--primary);
            color: #fff;
        }

        .gallery-loader {
            display: none;
            justify-content: center;
            align-items: center;
            margin-top: 1rem;
        }

        .gallery-loader img {
            width: 50px;
            height: 50px;
            animation: spin-slow 2s linear infinite;
        }

        /* ===================================== */
        /* Posts / Updates                       */
        /* ===================================== */
        .post-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .post-card-title {
            font-size: 1.2rem;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .post-date {
            font-size: 0.8rem;
            color: var(--primary);
            margin-bottom: 1rem;
            display: block;
        }

        .post-content {
            color: var(--muted);
            line-height: 1.6;
        }

        /* ===================================== */
        /* Project Page Background               */
        /* ===================================== */

        .project-page {
            position: relative;
            isolation: isolate;
        }

        .project-page::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -2;

            background-image: url('{{ $project->image ? asset('images/projects/' . $project->image) : '' }}');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;

            opacity: .18;

            transform: scale(1.05);
            transition: .4s ease;
        }

        .project-page::after {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            transition: .3s;
        }

        /* Light Theme */
        html:not(.dark) .project-page::after {
            background: transparent;
        }

        /* Dark Theme */
        html.dark .project-page::after {
            background: rgba(0, 0, 0, .28);
        }

        /* للموبايل لأن background-attachment: fixed يسبب مشاكل */
        @media (max-width: 992px) {
            .project-page::before {
                background-attachment: scroll;
            }
        }
        .summary-card,
.unit-card,
.post-card,
.feature-item,
.card-component{
    background: color-mix(in srgb, var(--surface) 88%, transparent);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border:1px solid var(--border);
}
    </style>
@endpush

@section('content')

    <div class="project-page">

        <div class="project-grid">

            <!-- الجانب الأيمن / الأيسر حسب اللغة (تفاصيل المشروع) -->
            <div class="project-main-content">

                <!-- About Project -->
                <div class="card-component fade-in-up" style="animation-delay: 0.1s; margin-bottom: 2rem;">
                    <h2 class="section-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'عن المشروع' : 'About Project' }}
                    </h2>
                    <div style="line-height: 1.8; color: var(--muted); font-size: 1.05rem;">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                </div>

                <!-- Features -->
                @if ($project->features->count() > 0)
                    <div class="fade-in-up" style="animation-delay: 0.2s;">
                        <h2 class="section-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                </path>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'المواصفات والمميزات' : 'Features & Amenities' }}
                        </h2>
                        <div class="features-grid">
                            @foreach ($project->features as $feature)
                                <div class="feature-item">
                                    <div class="val">{{ $feature->value }}</div>
                                    <div class="lbl">
                                        {{ app()->getLocale() == 'ar' ? $feature->title_ar : $feature->title_en }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Location (Interactive) -->
                @if ($project->latitude && $project->longitude)
                    <div class="card-component fade-in-up" style="animation-delay: 0.3s; margin-bottom: 2rem;">
                        <h2 class="section-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'موقع المشروع' : 'Project Location' }}
                        </h2>
                        <p style="color: var(--muted); margin-bottom: 1rem;">{{ $project->location }}</p>
                        <div class="location-wrapper">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $project->latitude }},{{ $project->longitude }}"
                                target="_blank" class="location-marker-btn" title="Open in Google Maps">
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                </svg>
                            </a>
                            <div class="location-text-overlay">
                                {{ app()->getLocale() == 'ar' ? 'اضغط لفتح الخريطة' : 'Click to open map' }}</div>
                        </div>
                    </div>
                @endif

                <!-- Units Section -->
                @if ($project->units->count() > 0)
                    <div class="fade-in-up" style="animation-delay: 0.4s; margin-bottom: 3rem;">
                        <h2 class="section-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'الوحدات المتاحة' : 'Available Units' }}
                        </h2>

                        <div class="units-grid">
                            @foreach ($project->units as $unit)
                                <div class="unit-card">
                                    <div class="unit-type-badge">
                                        {{ $unit->unit_type }}
                                    </div>
                                    <div class="unit-price">
                                        {{ $unit->unit_price ?? ($unit->price_per_meter ? $unit->price_per_meter . (app()->getLocale() == 'ar' ? '/متر' : '/sqm') : (app()->getLocale() == 'ar' ? 'تواصل لمعرفة السعر' : 'Contact for Price')) }}
                                    </div>
                                    <div class="unit-specs">
                                        @if ($unit->start_area)
                                            <div class="unit-spec-row">
                                                <span>{{ app()->getLocale() == 'ar' ? 'المساحة تبدأ من' : 'Starting Area' }}</span>
                                                <span>{{ $unit->start_area }}
                                                    {{ app()->getLocale() == 'ar' ? 'م²' : 'm²' }}</span>
                                            </div>
                                        @endif
                                        @if ($unit->floor)
                                            <div class="unit-spec-row">
                                                <span>{{ app()->getLocale() == 'ar' ? 'الطابق' : 'Floor' }}</span>
                                                <span>{{ $unit->floor }}</span>
                                            </div>
                                        @endif
                                        @if ($unit->finishing_type)
                                            <div class="unit-spec-row">
                                                <span>{{ app()->getLocale() == 'ar' ? 'نوع التشطيب' : 'Finishing' }}</span>
                                                <span>{{ $unit->finishing_type }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Gallery -->
                @if ($project->images->count() > 0)
                    <div class="fade-in-up" style="animation-delay: 0.5s; margin-bottom: 3rem;">
                        <h2 class="section-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'معرض الصور' : 'Gallery' }}
                        </h2>
                        <div class="gallery-grid" id="project-gallery">
                            @foreach ($project->images as $img)
                                <div class="gallery-item">
                                    <img src="{{ asset('images/projects/' . $img->image) }}" loading="lazy"
                                        alt="Project Image">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-loader" id="gallery-loader">
                            <!-- استخدام لوجو الشركة كأيقونة تحميل -->
                            <img src="{{ $project->logo ? asset('images/projects_logo/' . $project->logo) : asset('albrolosy_logo.png') }}"
                                alt="Loading">
                        </div>

                        <div class="load-more-container">
                            <button class="btn-load-more" id="btn-load-more" style="display: none;">
                                {{ app()->getLocale() == 'ar' ? 'عرض المزيد' : 'Load More' }}
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Posts / Updates -->
                @if ($project->posts->count() > 0)
                    <div class="fade-in-up" style="animation-delay: 0.6s;">
                        <h2 class="section-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                </path>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'تحديثات المشروع' : 'Project Updates' }}
                        </h2>
                        <div class="posts-list">
                            @foreach ($project->posts as $post)
                                <div class="post-card">
                                    <h3 class="post-card-title">{{ $post->title }}</h3>
                                    <span class="post-date">{{ $post->created_at->format('M d, Y') }}</span>
                                    <p class="post-content">{{ $post->description }}</p>

                                    @if ($post->contents->count() > 0)
                                        <div
                                            style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                                            @foreach ($post->contents as $content)
                                                @if ($content->type == 'text')
                                                    <p style="margin-bottom: 0.5rem; color: var(--text);">
                                                        {{ $content->content }}</p>
                                                @elseif($content->type == 'image')
                                                    <img src="{{ asset('images/posts/' . $content->content) }}"
                                                        style="max-width: 100%; border-radius: var(--radius-sm); margin-bottom: 0.5rem;">
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <!-- الشريط الجانبي (ملخص فخم يظل ظاهراً عند النزول) -->
            <aside class="project-sidebar fade-in-up" style="animation-delay: 0.3s;">
                <div class="summary-card">
                    @if ($project->logo)
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <img src="{{ asset('images/projects_logo/' . $project->logo) }}" alt="Logo"
                                style="max-width: 150px; max-height: 80px; object-fit: contain;">
                        </div>
                    @endif

                    <h3
                        style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--primary); padding-bottom: 0.5rem; color: var(--primary);">
                        {{ app()->getLocale() == 'ar' ? 'نظرة عامة' : 'Quick Summary' }}
                    </h3>

                    <div class="summary-item">
                        <span class="summary-label">{{ app()->getLocale() == 'ar' ? 'حالة المشروع' : 'Status' }}</span>
                        <span class="summary-value">
                            {{ app()->getLocale() == 'ar'
                                ? ($project->status == 'launched'
                                    ? 'تم الإطلاق'
                                    : ($project->status == 'coming_soon'
                                        ? 'قريباً'
                                        : ($project->status == 'under_construction'
                                            ? 'تحت الإنشاء'
                                            : 'تسليم فوري')))
                                : ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </div>

                    <div class="summary-item">
                        <span
                            class="summary-label">{{ app()->getLocale() == 'ar' ? 'السعر يبدأ من' : 'Starting Price' }}</span>
                        <span class="summary-value highlight">{{ $project->price_budget ?? 'N/A' }}</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">{{ app()->getLocale() == 'ar' ? 'موعد التسليم' : 'Delivery' }}</span>
                        <span class="summary-value">{{ $project->delivery_time ?? 'N/A' }}</span>
                    </div>

                    @if ($project->paymentPlans->count() > 0)
                        <h3 style="font-size: 1.1rem; margin-top: 2rem; margin-bottom: 1rem; color: var(--text);">
                            {{ app()->getLocale() == 'ar' ? 'خطط الدفع' : 'Payment Plans' }}
                        </h3>
                        @foreach ($project->paymentPlans as $plan)
                            <div
                                style="background: rgba(180, 0, 0, 0.05); border: 1px solid rgba(180, 0, 0, 0.2); padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 0.5rem;">
                                <div class="summary-item" style="border:none; padding: 0.2rem 0;">
                                    <span
                                        class="summary-label">{{ app()->getLocale() == 'ar' ? 'المقدم' : 'Down Payment' }}</span>
                                    <span class="summary-value">{{ $plan->down_payment }}</span>
                                </div>
                                <div class="summary-item" style="border:none; padding: 0.2rem 0;">
                                    <span
                                        class="summary-label">{{ app()->getLocale() == 'ar' ? 'سنوات التقسيط' : 'Installments' }}</span>
                                    <span class="summary-value">{{ $plan->installment_years }}
                                        {{ app()->getLocale() == 'ar' ? 'سنوات' : 'Years' }}</span>
                                </div>
                                @if ($plan->maintenance)
                                    <div class="summary-item" style="border:none; padding: 0.2rem 0;">
                                        <span
                                            class="summary-label">{{ app()->getLocale() == 'ar' ? 'الصيانة' : 'Maintenance' }}</span>
                                        <span class="summary-value">{{ $plan->maintenance }}</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </aside>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ==========================================
            // 1. Gallery Pagination (7 by 7)
            // ==========================================
            const items = document.querySelectorAll('.gallery-item');
            const btnLoadMore = document.getElementById('btn-load-more');
            const loader = document.getElementById('gallery-loader');

            const itemsPerPage = 7;
            let currentIndex = 0;

            function showNextItems() {
                // Show Loader
                if (btnLoadMore) btnLoadMore.style.display = 'none';
                if (loader) loader.style.display = 'flex';

                // Simulate network loading time for the professional effect
                setTimeout(() => {
                    if (loader) loader.style.display = 'none';

                    let limit = currentIndex + itemsPerPage;
                    for (let i = currentIndex; i < limit && i < items.length; i++) {
                        items[i].classList.add('active');
                    }
                    currentIndex = limit;

                    // Toggle Load More Button
                    if (currentIndex < items.length) {
                        if (btnLoadMore) btnLoadMore.style.display = 'inline-block';
                    }
                }, 800); // 800ms loading animation delay
            }

            if (items.length > 0) {
                showNextItems(); // Load first batch instantly (or with loader)

                if (btnLoadMore) {
                    btnLoadMore.addEventListener('click', () => {
                        showNextItems();
                    });
                }
            }

        });
    </script>
@endpush

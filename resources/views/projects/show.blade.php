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
        /* UI/UX Enhancements & Scoped CSS       */
        /* ===================================== */
        .project-page {
            position: relative;
            isolation: isolate;
        }

        /* 1. Light/Dark Theme Background Adjustments */
        .project-page::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -2;
            background-image: url('{{ $project->image_url }}');
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            opacity: 0.04;
            /* Very soft for light theme to avoid white glare */
            transform: scale(1.05);
            transition: .4s ease;
            filter: grayscale(80%);
        }

        html.dark .project-page::before {
            opacity: 0.15;
            filter: none;
        }

        html.dark .project-page::after {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -1;
            background: rgba(0, 0, 0, .4);
            /* Deeper shadow for dark mode */
        }

        /* 2. Glass Card Adjustments (Comfortable for the eye) */
        .glass-card {
            /* Light theme solid and soft */
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            transition: background 0.3s ease;
        }

        /* Dark theme glassmorphism */
        html.dark .glass-card {
            background: color-mix(in srgb, var(--surface) 80%, transparent);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Hero Section */
        .project-hero {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            padding: 3rem 2rem;
            text-align: center;
            align-items: center;
        }

        .hero-logo {
            max-width: 180px;
            height: auto;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text);
        }

        .hero-badges {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .badge {
            background: var(--surface-2);
            border: 1px solid var(--border);
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .badge-primary {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .btn-outline {
            background: transparent;
            color: var(--text);
            border: 2px solid var(--border);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-outline:hover {
            background: var(--surface-2);
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Availability Overview */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-box {
            text-align: center;
            padding: 1.2rem;
            background: var(--surface-2);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            transition: transform 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-3px);
        }

        .stat-box .num {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
            display: block;
        }

        .stat-box .label {
            font-size: 0.85rem;
            color: var(--muted);
            font-weight: 600;
            margin-top: 5px;
            display: block;
        }

        .progress-bar-container {
            width: 100%;
            background: var(--surface-2);
            border-radius: 50px;
            height: 12px;
            overflow: hidden;
            display: flex;
            border: 1px solid var(--border);
        }

        .progress-available {
            background: #10b981;
            height: 100%;
            transition: 1s ease-out;
        }

        .progress-reserved {
            background: #f59e0b;
            height: 100%;
            transition: 1s ease-out;
        }

        .progress-sold {
            background: #ef4444;
            height: 100%;
            transition: 1s ease-out;
        }

        /* Project Layout Grid */
        .project-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem;
            margin-top: 2rem;
        }

        @media (min-width: 1024px) {
            .project-grid {
                grid-template-columns: 2fr 1fr;
            }
        }

        /* Section Titles */
        .section-title {
            font-size: 1.5rem;
            color: var(--text);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 0.8rem;
            font-weight: 800;
        }

        .section-title svg {
            width: 24px;
            height: 24px;
            color: var(--primary);
        }

        /* Units Filter & Cards */
        .filter-container {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .filter-btn {
            background: var(--surface-2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            cursor: pointer;
            transition: 0.3s;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .filter-btn.active,
        .filter-btn:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .units-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .unit-card {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 1.5rem;
            transition: 0.3s;
            position: relative;
        }

        .unit-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .status-badge {
            position: absolute;
            top: 1rem;
            inset-inline-end: 1rem;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
        }

        .status-available {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-reserved {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .status-sold {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .unit-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .unit-price {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary);
            margin: 1rem 0;
        }

        .unit-specs {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            font-size: 0.95rem;
            color: var(--muted);
        }

        .unit-specs div {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed var(--border);
            padding-bottom: 0.4rem;
        }

        .unit-specs div span:last-child {
            color: var(--text);
            font-weight: 700;
        }

        /* Sidebar Summary */
        .summary-card {
            position: sticky;
            top: calc(var(--header-h, 80px) + 20px);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px dashed var(--border);
            font-size: 1.05rem;
        }

        .summary-item:last-child {
            border: none;
        }

        /* Helpers */
        .hidden {
            display: none !important;
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <style>
        /* ===================================== */
        /* Booking & Micro-Form Enhanced Styles  */
        /* ===================================== */
        .hero-blur-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            transition: opacity 0.4s ease, visibility 0.4s;
        }

        .hidden-overlay {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .hero-blur-overlay:not(.hidden-overlay) .micro-form-card {
            animation: ultraSpringPop 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        @keyframes ultraSpringPop {
            0% {
                opacity: 0;
                transform: scale(0.6) translateY(80px);
            }

            50% {
                opacity: 1;
                transform: scale(1.05) translateY(-10px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .micro-form-card {
            width: 100%;
            max-width: 440px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: clamp(2rem, 5vw, 3rem);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transform-origin: center bottom;
            position: relative;
        }

        .close-modal-btn {
            position: absolute;
            top: 15px;
            inset-inline-end: 15px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 1.2rem;
            cursor: pointer;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .close-modal-btn:hover {
            background: #fee2e2;
            color: #e11d48;
            border-color: #fecdd3;
            transform: rotate(90deg);
        }

        .micro-form-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .micro-form-header h3 {
            color: var(--text);
            font-size: clamp(1.4rem, 4vw, 1.8rem);
            margin-bottom: 0.5rem;
            font-weight: 800;
        }

        .micro-form-header p {
            color: var(--muted);
            font-size: 1rem;
            margin-bottom: 0;
        }

        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .input-group input,
        .styled-select {
            width: 100%;
            background: var(--surface-2);
            color: var(--text);
            border: 2px solid transparent;
            border-radius: 16px;
            padding: 1.2rem 1.5rem;
            font-family: inherit;
            font-size: 1.05rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .styled-select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1.2rem center;
            background-size: 1em;
            cursor: pointer;
        }

        html[dir="rtl"] .styled-select {
            background-position: left 1.2rem center;
        }

        .input-group input:focus,
        .styled-select:focus {
            outline: none;
            background: var(--surface);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            /* Primary color shadow */
        }

        .cta-btn {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 16px;
            padding: 1.2rem;
            font-size: 1.15rem;
            font-weight: 800;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            opacity: 0.95;
            box-shadow: 0 15px 25px -5px rgba(0, 0, 0, 0.3);
        }

        /* ========================================================= */
        /* Al-Brolosy Luxury Light Theme Styling                     */
        /* ========================================================= */
        html:not(.dark) {
            --brolosy-gold: #c5a059;
            --brolosy-red: #B40000;
            --brolosy-bg: #F8F9FA;
            --brolosy-border: rgba(197, 160, 89, 0.28);
        }

        html:not(.dark) .project-page {
            background-color: var(--brolosy-bg);
            color: #111827;
        }

        html:not(.dark) .glass-card {
            background: #FFFFFF !important;
            border: 1px solid var(--brolosy-border) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;
            border-radius: 20px !important;
        }

        html:not(.dark) .hero-title {
            color: #111827 !important;
            font-weight: 800 !important;
        }

        html:not(.dark) .badge {
            background: #FFFFFF !important;
            border: 1px solid rgba(197, 160, 89, 0.35) !important;
            color: #1F2937 !important;
            font-weight: 700 !important;
        }

        html:not(.dark) .badge-primary {
            background: #B40000 !important;
            color: #ffffff !important;
            border-color: #B40000 !important;
        }

        html:not(.dark) .actual-unit-item {
            background: #FFFFFF !important;
            border: 1px solid rgba(197, 160, 89, 0.25) !important;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03) !important;
        }

        html:not(.dark) .unit-price-tag {
            color: #B40000 !important;
            font-weight: 800 !important;
        }

        html:not(.dark) .plan-card {
            background: #FFFFFF !important;
            border: 1px solid rgba(197, 160, 89, 0.28) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04) !important;
        }

        html:not(.dark) .plan-card .down-payment {
            color: #B40000 !important;
            font-size: 1.8rem !important;
            font-weight: 800 !important;
        }

        html:not(.dark) .feature-box {
            background: #FFFFFF !important;
            border: 1px solid rgba(197, 160, 89, 0.22) !important;
        }

        html:not(.dark) .input-group input,
        html:not(.dark) .styled-select {
            background: #F9FAFB !important;
            color: #111827 !important;
            border: 1.5px solid rgba(197, 160, 89, 0.35) !important;
        }

        /* ===================================== */
        /* Responsive Floating Booking Bar       */
        /* ===================================== */
        .sticky-booking-bar {
            position: fixed;
            bottom: 25px;
            inset-inline-start: 50%;
            transform: translateX(-50%);
            z-index: 9990;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(17, 24, 39, 0.94);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 8px 14px;
            border-radius: 50px;
            border: 1px solid rgba(215, 182, 74, 0.45);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.45);
            max-width: 95%;
            width: auto;
        }

        html:not(.dark) .sticky-booking-bar {
            background: rgba(255, 255, 255, 0.96);
            border-color: rgba(197, 160, 89, 0.55);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        }

        .sticky-btn-primary {
            background: #B40000;
            color: #ffffff !important;
            border: none;
            border-radius: 50px;
            padding: 0.85rem 1.8rem;
            font-size: 1.05rem;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(180, 0, 0, 0.3);
            font-family: inherit;
        }

        .sticky-btn-primary:hover {
            transform: translateY(-2px);
            background: #d80000;
            box-shadow: 0 6px 20px rgba(180, 0, 0, 0.4);
        }

        .sticky-btn-call {
            background: rgba(215, 182, 74, 0.16);
            color: #d7b64a !important;
            border: 1px solid rgba(215, 182, 74, 0.4);
            border-radius: 50px;
            padding: 0.85rem 1.4rem;
            font-size: 0.95rem;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        html:not(.dark) .sticky-btn-call {
            background: rgba(197, 160, 89, 0.15);
            color: #92400e !important;
            border-color: rgba(197, 160, 89, 0.45);
        }

        .sticky-btn-call:hover {
            background: #d7b64a;
            color: #000000 !important;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            body {
                padding-bottom: 85px;
            }
            .sticky-booking-bar {
                bottom: 12px;
                width: 95%;
                padding: 6px 10px;
                justify-content: space-between;
                gap: 8px;
            }
            .sticky-btn-primary {
                flex: 1.3;
                justify-content: center;
                padding: 0.75rem 0.9rem;
                font-size: 0.9rem;
            }
            .sticky-btn-call {
                flex: 1;
                justify-content: center;
                padding: 0.75rem 0.7rem;
                font-size: 0.85rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="project-page">

        <!-- 1. Hero Section -->
        <div class="glass-card project-hero fade-in">
            @if ($project->logo_url)
                <img src="{{ $project->logo_url }}" alt="{{ $project->name }}"
                    class="hero-logo">
            @endif
            <h1 class="hero-title">{{ $project->name }}</h1>

            <div class="hero-badges">
                <span class="badge">{{ $project->sector->name ?? '' }}</span>
                <span class="badge badge-primary">
                    {{ app()->getLocale() == 'ar' ? 'السعر يبدأ من: ' : 'Starts at: ' }}
                    {{ $project->price_budget ?? 'N/A' }}
                </span>
                <span class="badge">{{ $project->location }}</span>
            </div>

            <div class="hero-actions" style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center;">
                <button type="button" onclick="openBookingModal()" class="btn-primary" style="display:inline-flex; align-items:center; gap:8px; cursor:pointer; border:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'احجز وحدتك عبر واتساب' : 'Book on WhatsApp' }}</span>
                </button>
                <a href="tel:{{ $project->effective_booking_phone }}" class="btn-outline" style="display:inline-flex; align-items:center; gap:8px;" dir="ltr">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>{{ $project->effective_booking_phone }}</span>
                </a>
                <a href="#units"
                    class="btn-outline">{{ app()->getLocale() == 'ar' ? 'استعرض الوحدات' : 'Explore Units' }}</a>
            </div>
        </div>

        <!-- 2. Main Content Grid -->
        <div class="project-grid">

            <!-- Left Side: Main Details -->
            <div class="main-content">

                <!-- 3. Availability Overview -->
                @if ($stats['total'] > 0)
                    <div class="glass-card fade-in">
                        <h2 class="section-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'حالة توافر الوحدات' : 'Availability Overview' }}
                        </h2>

                        <div class="stats-grid">
                            <div class="stat-box">
                                <span class="num">{{ $stats['total'] }}</span>
                                <span
                                    class="label">{{ app()->getLocale() == 'ar' ? 'إجمالي الوحدات' : 'Total Units' }}</span>
                            </div>
                            <div class="stat-box">
                                <span class="num" style="color: #10b981;">{{ $stats['available'] }}</span>
                                <span class="label">{{ app()->getLocale() == 'ar' ? 'متاحة' : 'Available' }}</span>
                            </div>
                            <div class="stat-box">
                                <span class="num" style="color: #f59e0b;">{{ $stats['reserved'] }}</span>
                                <span class="label">{{ app()->getLocale() == 'ar' ? 'محجوزة' : 'Reserved' }}</span>
                            </div>
                            <div class="stat-box">
                                <span class="num" style="color: #ef4444;">{{ $stats['sold'] }}</span>
                                <span class="label">{{ app()->getLocale() == 'ar' ? 'مباعة' : 'Sold' }}</span>
                            </div>
                        </div>

                        <div class="progress-bar-container">
                            <div class="progress-available"
                                style="width: {{ $stats['total'] ? ($stats['available'] / $stats['total']) * 100 : 0 }}%;"
                                title="Available"></div>
                            <div class="progress-reserved"
                                style="width: {{ $stats['total'] ? ($stats['reserved'] / $stats['total']) * 100 : 0 }}%;"
                                title="Reserved"></div>
                            <div class="progress-sold"
                                style="width: {{ $stats['total'] ? ($stats['sold'] / $stats['total']) * 100 : 0 }}%;"
                                title="Sold"></div>
                        </div>

                        @if ($stats['availability_percentage'] < 40)
                            <p style="text-align: center; margin-top: 1rem; font-weight: bold; color: #f59e0b;">
                                {{ app()->getLocale() == 'ar' ? 'الوحدات المتاحة تتغير باستمرار، احجز وحدتك قبل نفاد الخيارات المناسبة.' : 'Available units are changing rapidly. Reserve yours before options run out.' }}
                            </p>
                        @endif
                    </div>
                @endif

                <!-- 4. About Project -->
                <div class="glass-card fade-in">
                    <h2 class="section-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'عن المشروع' : 'About Project' }}
                    </h2>
                    <div style="line-height: 1.8; color: var(--muted); font-size: 1.05rem;">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                </div>

                <!-- 5. Unit Types Summary -->
                @if ($project->unitTypes->count() > 0)
                    <div class="glass-card fade-in" id="unit-types">
                        <h2 class="section-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                                </path>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'أنواع الوحدات في المشروع' : 'Project Unit Types' }}
                        </h2>
                        <div class="units-grid">
                            @foreach ($project->unitTypes as $type)
                                <div class="unit-card">
                                    <h3 class="unit-title">
                                        {{ app()->getLocale() == 'ar' ? $type->name_ar : $type->name_en }}</h3>
                                    <div
                                        style="margin-bottom: 1rem; display:inline-block; background: var(--surface); padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.85rem; font-weight: bold; border: 1px solid var(--border);">
                                        {{ $type->unit_type }}
                                    </div>

                                    <div class="unit-specs">
                                        <div><span>{{ app()->getLocale() == 'ar' ? 'المساحة' : 'Area' }}</span>
                                            <span>{{ $type->area }} م²</span>
                                        </div>
                                        <div><span>{{ app()->getLocale() == 'ar' ? 'السعر/متر' : 'Price/m²' }}</span>
                                            <span>{{ number_format($type->price_per_meter) }} EGP</span>
                                        </div>
                                        @if ($type->finishing_type)
                                            <div><span>{{ app()->getLocale() == 'ar' ? 'التشطيب' : 'Finishing' }}</span>
                                                <span>{{ $type->finishing_type }}</span>
                                            </div>
                                        @endif
                                        <div
                                            style="margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px solid var(--border);">
                                            <span>{{ app()->getLocale() == 'ar' ? 'إجمالي الوحدات' : 'Total Units' }}</span>
                                            <span>{{ $type->total_units }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 6. Actual Units Finder (Filtering System) -->
                @if ($actualUnits->count() > 0)
                    <div class="glass-card fade-in" id="units">
                        <h2 class="section-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'البحث في الوحدات الفعلية' : 'Actual Units Finder' }}
                        </h2>

                        <!-- Filters -->
                        <div class="filter-container">
                            <button class="filter-btn active" data-filter="status"
                                data-value="all">{{ app()->getLocale() == 'ar' ? 'الكل' : 'All' }}</button>
                            <button class="filter-btn" data-filter="status"
                                data-value="available">{{ app()->getLocale() == 'ar' ? 'متاحة' : 'Available' }}</button>
                            <button class="filter-btn" data-filter="status"
                                data-value="reserved">{{ app()->getLocale() == 'ar' ? 'محجوزة' : 'Reserved' }}</button>
                            <button class="filter-btn" data-filter="status"
                                data-value="sold">{{ app()->getLocale() == 'ar' ? 'مباعة' : 'Sold' }}</button>
                        </div>

                        <!-- Units Grid -->
                        <div class="units-grid" id="actual-units-container">
                            @foreach ($actualUnits->take(12) as $unit)
                                <div class="unit-card actual-unit-item" data-status="{{ $unit->status }}"
                                    data-type="{{ strtolower($unit->unitType->unit_type ?? '') }}">

                                    @php
                                        $statusClass =
                                            $unit->status == 'available'
                                                ? 'status-available'
                                                : ($unit->status == 'reserved'
                                                    ? 'status-reserved'
                                                    : 'status-sold');
                                        $statusText =
                                            app()->getLocale() == 'ar'
                                                ? ($unit->status == 'available'
                                                    ? 'متاحة'
                                                    : ($unit->status == 'reserved'
                                                        ? 'محجوزة'
                                                        : 'مباعة'))
                                                : ucfirst($unit->status);
                                    @endphp

                                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>

                                    <h3 class="unit-title">{{ $unit->unit_number }}</h3>
                                    <div class="unit-price">{{ number_format($unit->unit_price) }} EGP</div>

                                    <div class="unit-specs">
                                        <div><span>{{ app()->getLocale() == 'ar' ? 'النوع' : 'Type' }}</span>
                                            <span>{{ $unit->unitType->unit_type ?? '-' }}</span>
                                        </div>
                                        <div><span>{{ app()->getLocale() == 'ar' ? 'الطابق' : 'Floor' }}</span>
                                            <span>{{ $unit->floor ?? '-' }}</span>
                                        </div>
                                        <div><span>{{ app()->getLocale() == 'ar' ? 'المساحة' : 'Area' }}</span>
                                            <span>{{ $unit->area ?? $unit->start_area }} م²</span>
                                        </div>
                                        <div><span>{{ app()->getLocale() == 'ar' ? 'سعر المتر' : 'Price/m²' }}</span>
                                            <span>{{ number_format($unit->price_per_meter) }}</span>
                                        </div>
                                    </div>

                                    {{-- @if ($unit->status == 'available')
                                        <button class="btn-outline"
                                            style="width: 100%; text-align: center; margin-top: 1.5rem; padding: 0.6rem;"
                                            onclick="scrollToCalculator({{ $unit->unit_price }})">
                                            {{ app()->getLocale() == 'ar' ? 'احسب القسط' : 'Calculate Installment' }}
                                        </button>
                                    @endif --}}
                                </div>
                            @endforeach
                        </div>

                        @if ($actualUnits->count() > 12)
                            <div style="text-align: center; margin-top: 2rem;">
                                <button class="btn-outline"
                                    id="load-more-units">{{ app()->getLocale() == 'ar' ? 'عرض المزيد من الوحدات' : 'Load More Units' }}</button>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- 8. Features (Only if exist) -->
                @if ($project->features->count() > 0)
                    <div class="glass-card fade-in">
                        <h2 class="section-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                </path>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'المواصفات والمميزات' : 'Features & Amenities' }}
                        </h2>
                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                            @foreach ($project->features as $feature)
                                <div
                                    style="background: var(--surface-2); border: 1px solid var(--border); padding: 1.5rem 1rem; border-radius: var(--radius-sm); text-align: center;">
                                    <div
                                        style="font-size: 1.2rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">
                                        {{ $feature->value }}</div>
                                    <div style="font-size: 0.9rem; color: var(--muted); font-weight: 600;">
                                        {{ app()->getLocale() == 'ar' ? $feature->title_ar : $feature->title_en }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 9. Location -->
                @if (($project->latitude && $project->longitude) || $project->location)
                    <div class="glass-card fade-in">
                        <h2 class="section-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'موقع المشروع' : 'Project Location' }}
                        </h2>
                        <p style="color: var(--muted); margin-bottom: 1rem; font-size: 1.05rem;">{{ $project->location }}
                        </p>
                        @if ($project->latitude && $project->longitude)
                            <div
                                style="position: relative; width: 100%; height: 300px; background: url('{{ $project->image_url }}') center/cover; border-radius: var(--radius); display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: inset 0 0 50px rgba(0,0,0,0.5);">
                                <div
                                    style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(2px);">
                                </div>
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $project->latitude }},{{ $project->longitude }}"
                                    target="_blank" class="btn-primary" style="position: relative; z-index: 10;">
                                    {{ app()->getLocale() == 'ar' ? 'فتح الموقع على Google Maps' : 'Open in Google Maps' }}
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- 10. Gallery -->
                @if ($project->images->count() > 0)
                    <div class="glass-card fade-in" id="gallery-section">
                        <h2 class="section-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'معرض الصور' : 'Gallery' }}
                        </h2>
                        <div class="gallery-grid"
                            style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                            @foreach ($project->images as $img)
                                <img src="{{ $img->image_url }}" loading="lazy"
                                    alt="Project Image"
                                    style="width: 100%; height: 200px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Side: Sticky Summary Sidebar -->
            <aside class="project-sidebar">
                <div class="glass-card summary-card fade-in">
                    <h3
                        style="font-size: 1.3rem; margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 0.8rem; font-weight: 800;">
                        {{ app()->getLocale() == 'ar' ? 'ملخص المشروع' : 'Project Summary' }}
                    </h3>

                    <div class="summary-item">
                        <span class="summary-label">{{ app()->getLocale() == 'ar' ? 'حالة المشروع' : 'Status' }}</span>
                        <span style="font-weight: 700; color: var(--text);">
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
                        <span class="summary-label">{{ app()->getLocale() == 'ar' ? 'موعد التسليم' : 'Delivery' }}</span>
                        <span style="font-weight: 700; color: var(--text);">{{ $project->delivery_time ?? 'N/A' }}</span>
                    </div>

                    <div class="summary-item">
                        <span
                            class="summary-label">{{ app()->getLocale() == 'ar' ? 'السعر يبدأ من' : 'Starting Price' }}</span>
                        <span
                            style="font-weight: 800; color: var(--primary); font-size: 1.2rem;">{{ $project->price_budget ?? 'N/A' }}</span>
                    </div>
                </div>
            </aside>

        </div>
    </div>

    <!-- Floating Global Booking Bar (Responsive on Mobile & Desktop) -->
    <div class="sticky-booking-bar">
        <button type="button" class="sticky-btn-primary" onclick="openBookingModal()">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
            </svg>
            <span data-ar="احجز وحدتك الآن عبر واتساب" data-en="Book on WhatsApp">{{ app()->getLocale() == 'ar' ? 'احجز وحدتك عبر واتساب' : 'Book on WhatsApp' }}</span>
        </button>

        <a href="tel:{{ $project->effective_booking_phone }}" class="sticky-btn-call" title="اتصال مبيعات مباشر">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            <span data-ar="اتصال هاتفي" data-en="Direct Call">{{ app()->getLocale() == 'ar' ? 'اتصال هاتفي' : 'Call Sales' }}</span>
        </a>
    </div>

    <!-- ===================================== -->
    <!-- Booking Modal (Frontend WhatsApp Logic) -->
    <!-- ===================================== -->
    <div class="hero-blur-overlay hidden-overlay" id="bookingModalOverlay">
        <div class="micro-form-card">

            <button class="close-modal-btn" onclick="closeBookingModal(event)">✕</button>

            <div class="micro-form-header">
                <h3 data-ar="احجز وحدتك الآن" data-en="Book Your Unit Now">احجز وحدتك الآن</h3>
                <p data-ar="سيتم تحويلك مباشرة لإتمام الحجز عبر واتساب"
                    data-en="You will be redirected to WhatsApp to complete your booking">
                    سيتم تحويلك مباشرة لإتمام الحجز عبر واتساب
                </p>
            </div>

            <form id="bookingMicroForm">
                <input type="hidden" id="booking_project_ar" value="{{ $project->name_ar }}">
                <input type="hidden" id="booking_project_en" value="{{ $project->name_en }}">

                <div class="input-group">
                    <select id="booking_unit_type" required class="styled-select">
                        <option value="" disabled selected data-ar="اختر نوع الوحدة المطلوبة"
                            data-en="Select Required Unit Type">اختر نوع الوحدة المطلوبة</option>
                        @if (isset($project->unitTypes) && $project->unitTypes->count() > 0)
                            @foreach ($project->unitTypes as $type)
                                <option value="{{ $type->name_ar }}|{{ $type->name_en }}">
                                    {{ app()->getLocale() == 'ar' ? $type->name_ar : $type->name_en }}
                                    ({{ $type->unit_type }})
                                </option>
                            @endforeach
                        @else
                            <option value="General Booking|حجز عام" data-ar="حجز عام (لم يتم تحديد وحدة)"
                                data-en="General Booking (Unit not specified)">حجز عام (لم يتم تحديد وحدة)</option>
                        @endif
                    </select>
                </div>

                <div class="input-group">
                    <input type="text" id="booking_name" name="full_name" required
                        value="{{ $client->full_name ?? (auth()->user()->name ?? '') }}"
                        data-placeholder-ar="الاسم بالكامل" data-placeholder-en="Full Name" placeholder="الاسم بالكامل">
                </div>

                <div class="input-group">
                    <input type="tel" id="booking_phone" name="phone" required
                        value="{{ $client->phone ?? (auth()->user()->phone ?? '') }}" data-placeholder-ar="رقم الهاتف"
                        data-placeholder-en="Phone Number" placeholder="رقم الهاتف">
                </div>

                <button type="submit" class="cta-btn" id="submitBookingBtn">
                    <span class="btn-text" data-ar="تأكيد والذهاب للواتساب" data-en="Confirm & Go to WhatsApp">تأكيد
                        والذهاب للواتساب</span>
                    <svg class="whatsapp-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                    </svg>
                </button>

                <div style="margin-top: 1.2rem; text-align: center; font-size: 0.92rem; color: var(--muted); border-top: 1px dashed var(--border); padding-top: 0.9rem;">
                    <span>{{ app()->getLocale() == 'ar' ? 'أو تواصل مباشرة مع فريق مبيعات المشروع:' : 'Or call the project sales team directly:' }}</span>
                    <a href="tel:{{ $project->effective_booking_phone }}" style="color: var(--primary); font-weight: 800; text-decoration: none; display: inline-block; margin-inline-start: 6px;" dir="ltr">
                        <i class="fa-solid fa-phone" style="font-size:0.8rem;"></i> {{ $project->effective_booking_phone }}
                    </a>
                </div>
            </form>

            <div id="bookingSuccessMessage" class="success-msg" style="display: none;">
                <div class="check-icon-wrapper">
                    <span class="check-icon">✓</span>
                </div>
                <p id="successText" data-ar="جاري تحويلك للواتساب بنجاح!"
                    data-en="Redirecting to WhatsApp successfully!">جاري تحويلك للواتساب بنجاح!</p>
                <button onclick="closeBookingModal(event)" class="cta-btn"
                    style="margin-top: 15px; width: 100%; background: var(--surface-2); color: var(--text); box-shadow: none; border: 1px solid var(--border);">
                    <span data-ar="إغلاق" data-en="Close">إغلاق</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        // =====================================
        // WhatsApp Booking Logic & Dynamic Data
        // =====================================
        const bookingModal = document.getElementById('bookingModalOverlay');
        const bookingForm = document.getElementById('bookingMicroForm');
        const bookingSuccessMsg = document.getElementById('bookingSuccessMessage');
        const WHATSAPP_NUMBER = "{{ $project->effective_booking_phone }}";

        // إغلاق المودال عند الضغط خارجه
        bookingModal.addEventListener('click', function(e) {
            if (e.target === bookingModal) closeBookingModal();
        });

        function openBookingModal() {
            bookingForm.style.display = 'block';
            bookingSuccessMsg.style.display = 'none';
            bookingModal.classList.remove('hidden-overlay');

            if (window.preferences && typeof window.preferences.translate === 'function') {
                window.preferences.translate();
            }
        }

        function closeBookingModal(e) {
            if (e) e.preventDefault();
            bookingModal.classList.add('hidden-overlay');
        }

        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('booking_name').value.trim();
            const phone = document.getElementById('booking_phone').value.trim();

            const unitSelect = document.getElementById('booking_unit_type');
            const unitValues = unitSelect.value.split('|');
            const unitAr = unitValues[0];
            const unitEn = unitValues[1] || unitValues[0];

            const projectAr = document.getElementById('booking_project_ar').value;
            const projectEn = document.getElementById('booking_project_en').value;

            const currentLang = document.documentElement.lang || 'en';

            let message = "";
            if (currentLang === 'ar') {
                message = `مرحباً،\nأنا مهتم بحجز وحدة في مشروع: *${projectAr}*\n\n` +
                    `📌 *نوع الوحدة المطلوبة:* ${unitAr}\n` +
                    `👤 *الاسم:* ${name}\n` +
                    `📱 *رقم الهاتف:* ${phone}\n\n` +
                    `برجاء التواصل معي لإتمام التفاصيل.`;
            } else {
                message = `Hello,\nI am interested in booking a unit in: *${projectEn}*\n\n` +
                    `📌 *Requested Unit:* ${unitEn}\n` +
                    `👤 *Name:* ${name}\n` +
                    `📱 *Phone:* ${phone}\n\n` +
                    `Please contact me to proceed.`;
            }

            // حفظ العميل وتدوين الحدث السلوكي فورياً في الـ CRM والخلفية البرمجية
            try {
                fetch('/api/v1/lead/quick-inquiry', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({
                        full_name: name,
                        phone: phone,
                        project_id: {{ $project->id }},
                        unit_type: unitAr,
                        inquiry_type: 'whatsapp'
                    })
                }).catch(() => {});
            } catch(err) {}

            const encodedMessage = encodeURIComponent(message);
            const whatsappUrl = `https://wa.me/${WHATSAPP_NUMBER}?text=${encodedMessage}`;

            window.open(whatsappUrl, '_blank');

            bookingForm.style.display = 'none';
            bookingSuccessMsg.style.display = 'block';
        });

        window.addEventListener("preferencesChanged", function(e) {
            const lang = e.detail.lang;
            const select = document.getElementById('booking_unit_type');

            Array.from(select.options).forEach(option => {
                if (option.value === "") return;
                const vals = option.value.split('|');
                if (vals.length > 1) {
                    const unitTypeText = option.text.match(/\(.*\)/);
                    option.text = (lang === 'ar' ? vals[0] : vals[1]) + (unitTypeText ?
                        ` ${unitTypeText[0]}` : '');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // 1. Format Currency Helper
            const formatCurrency = (number) => {
                return new Intl.NumberFormat('en-US').format(number) + ' EGP';
            };

            // 2. Units Filtering System
            const filterBtns = document.querySelectorAll('.filter-btn');
            const unitItems = document.querySelectorAll('.actual-unit-item');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    const filterValue = btn.getAttribute('data-value');

                    unitItems.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-status') ===
                            filterValue) {
                            item.classList.remove('hidden');
                            item.style.animation = 'none';
                            item.offsetHeight; /* trigger reflow */
                            item.style.animation = null;
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                });
            });

            // 3. Calculator Logic
            const priceInput = document.getElementById('calc-price');
            const planSelect = document.getElementById('calc-plan');
            const resultBox = document.getElementById('calc-result-box');

            // تم تصحيح الخطأ الإملائي هنا (do > cument -> document)
            const resTotal = document.getElementById('res-total-price');
            const resDownPayment = document.getElementById('res-down-payment');
            const resRemaining = document.getElementById('res-remaining');
            const resInstallment = document.getElementById('res-installment');

            function calculateInstallments() {
                if (!priceInput || !planSelect) return;

                const price = parseFloat(priceInput.value);
                const selectedOption = planSelect.options[planSelect.selectedIndex];
                const downPaymentStr = selectedOption.value;
                const yearsStr = selectedOption.getAttribute('data-years');

                if (price > 0 && downPaymentStr) {
                    if (resultBox) resultBox.style.display = 'block';

                    const downPaymentPercent = parseFloat(downPaymentStr.replace(/[^\d.]/g, '')) || 0;
                    const years = parseFloat(yearsStr.replace(/[^\d.]/g, '')) || 1;

                    const downPaymentValue = (price * downPaymentPercent) / 100;
                    const remainingValue = price - downPaymentValue;
                    const yearlyInstallment = remainingValue / years;

                    if (resTotal) resTotal.textContent = formatCurrency(price);
                    if (resDownPayment) resDownPayment.textContent = formatCurrency(downPaymentValue) +
                        ` (${downPaymentPercent}%)`;
                    if (resRemaining) resRemaining.textContent = formatCurrency(remainingValue);
                    if (resInstallment) resInstallment.textContent = formatCurrency(yearlyInstallment) +
                        ` / {{ app()->getLocale() == 'ar' ? 'سنة' : 'Year' }}`;
                } else {
                    if (resultBox) resultBox.style.display = 'none';
                }
            }

            if (priceInput) priceInput.addEventListener('input', calculateInstallments);
            if (planSelect) planSelect.addEventListener('change', calculateInstallments);
        });

        function scrollToCalculator(price) {
            const calcInput = document.getElementById('calc-price');
            if (calcInput) {
                calcInput.value = price;
                const resSection = document.getElementById('reservation');
                if (resSection) {
                    resSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
                calcInput.dispatchEvent(new Event('input'));
            }
        }

        // تسجيل مشاهدة المشروع سلوكياً
        document.addEventListener('DOMContentLoaded', () => {
            try {
                fetch('/api/v1/behavior/track', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({
                        event_type: 'project_view',
                        project_id: {{ $project->id }},
                        page_title: '{{ addslashes($project->name_ar) }}',
                        page_url: window.location.pathname
                    })
                }).catch(() => {});
            } catch(e) {}
        });
    </script>
@endsection

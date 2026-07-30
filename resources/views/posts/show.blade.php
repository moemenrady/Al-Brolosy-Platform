@extends('layouts.page')

@section('title', app()->getLocale() == 'ar' ? $post->title_ar . ' | المركز الإعلامي' : $post->title_en . ' | Media Center')

@section('breadcrumb')
    <a href="{{ route('media.index') }}" data-ar="المركز الإعلامي" data-en="Media Center">
        {{ app()->getLocale() == 'ar' ? 'المركز الإعلامي' : 'Media Center' }}
    </a>
    <span>/</span>
    <span class="current-page" data-ar="{{ $post->title_ar }}" data-en="{{ $post->title_en }}">
        {{ $post->title }}
    </span>
@endsection

@section('page_title')
    <span data-ar="{{ $post->title_ar }}" data-en="{{ $post->title_en }}">
        {{ $post->title }}
    </span>
@endsection

@section('page_subtitle')
    <div class="hero-post-meta">
        <span class="meta-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span>{{ \Carbon\Carbon::parse($post->published_at)->format('d M, Y') }}</span>
        </span>
        <span class="meta-dot">•</span>
        <span class="meta-item category-highlight" data-ar="{{ $post->category?->name_ar ?? 'غير مصنف' }}" data-en="{{ $post->category?->name_en ?? 'Uncategorized' }}">
            {{ $post->category?->name ?? 'Uncategorized' }}
        </span>
    </div>
@endsection

@push('styles')
<style>
    /* ===================================== */
    /* 1. Media Show Grid Layout             */
    /* ===================================== */
    .media-show-wrapper {
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
        position: relative;
    }

    @media (min-width: 1024px) {
        .media-show-wrapper {
            grid-template-columns: 2fr 1fr;
        }
    }

    /* ===================================== */
    /* 2. Main Content Column                */
    /* ===================================== */
    .media-content-col {
        display: flex;
        flex-direction: column;
        gap: 2.5rem;
    }

    /* Cinematic Cover Image */
    .media-cover-wrapper {
        position: relative;
        width: 100%;
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-lux);
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUpLux 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    .media-cover-wrapper img {
        width: 100%;
        height: auto;
        max-height: 600px;
        object-fit: cover;
        display: block;
        transition: transform 0.7s ease;
    }

    .media-cover-wrapper:hover img {
        transform: scale(1.03);
    }

    /* Viewfinder Elements */
    .viewfinder {
        position: absolute;
        width: 40px;
        height: 40px;
        border-color: var(--primary);
        border-style: solid;
        z-index: 6;
        opacity: 0.7;
        transition: all 0.4s ease;
        pointer-events: none;
    }
    .viewfinder.top-left { top: 20px; left: 20px; border-width: 3px 0 0 3px; }
    .viewfinder.top-right { top: 20px; right: 20px; border-width: 3px 3px 0 0; }
    .viewfinder.bottom-left { bottom: 20px; left: 20px; border-width: 0 0 3px 3px; }
    .viewfinder.bottom-right { bottom: 20px; right: 20px; border-width: 0 3px 3px 0; }

    .media-cover-wrapper:hover .viewfinder {
        opacity: 1;
    }
    .media-cover-wrapper:hover .viewfinder.top-left { top: 15px; left: 15px; }
    .media-cover-wrapper:hover .viewfinder.top-right { top: 15px; right: 15px; }
    .media-cover-wrapper:hover .viewfinder.bottom-left { bottom: 15px; left: 15px; }
    .media-cover-wrapper:hover .viewfinder.bottom-right { bottom: 15px; right: 15px; }

    /* Cinematic Flash */
    .camera-flash {
        position: absolute;
        inset: 0;
        background-color: white;
        opacity: 0;
        z-index: 10;
        pointer-events: none;
        animation: cinematicFlashStart 1s ease-out forwards;
    }

    @keyframes cinematicFlashStart {
        0% { opacity: 0; }
        10% { opacity: 0.9; }
        100% { opacity: 0; }
    }

    /* Content Typography */
    .post-lead {
        font-size: 1.25rem;
        color: var(--accent);
        line-height: 1.8;
        font-weight: 600;
        border-left: 4px solid var(--primary);
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    html[dir="rtl"] .post-lead {
        border-left: none;
        border-right: 4px solid var(--primary);
        padding-left: 0;
        padding-right: 1.5rem;
    }

    .rich-text-content {
        color: var(--text);
        font-size: 1.1rem;
        line-height: 1.9;
    }

    .rich-text-content p {
        margin-bottom: 1.5rem;
    }

    /* Dynamic Content Blocks */
    .dynamic-media-block {
        margin: 2rem 0;
        border-radius: var(--radius-sm);
        overflow: hidden;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-lux);
    }
    
    .dynamic-media-block img, .dynamic-media-block video {
        width: 100%;
        display: block;
    }

    /* ===================================== */
    /* 3. Sticky Sidebar                     */
    /* ===================================== */
    .media-sidebar-col {
        position: relative;
    }

    .sidebar-sticky-box {
        position: sticky;
        top: calc(var(--header-h) + 20px);
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .sidebar-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 2rem;
        box-shadow: var(--shadow-lux);
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUpLux 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        animation-delay: 0.2s;
    }

    /* Share Buttons */
    .share-title {
        font-size: 1.1rem;
        color: var(--text);
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .share-buttons {
        display: flex;
        gap: 1rem;
    }

    .share-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--surface-2);
        color: var(--text);
        border: 1px solid var(--border);
        transition: all var(--transition);
        text-decoration: none;
    }

    .share-btn:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(180, 0, 0, 0.2);
    }

    .share-btn svg {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }

    /* Previous / Next Navigation */
    .nav-post-link {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        padding-top: 1.5rem;
        border-top: 1px dashed var(--border);
        text-decoration: none;
        transition: all var(--transition);
        margin-top: 1.5rem;
    }
    
    .nav-post-link:first-child {
        padding-top: 0;
        border-top: none;
        margin-top: 0;
    }

    .nav-label {
        font-size: 0.85rem;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .nav-title {
        font-size: 1.1rem;
        color: var(--text);
        font-weight: 600;
        line-height: 1.4;
        transition: color 0.3s;
    }

    .nav-post-link:hover .nav-title {
        color: var(--primary);
    }
    .nav-post-link:hover .nav-label {
        color: var(--accent);
    }

    html[dir="rtl"] .nav-icon-arrow {
        transform: rotate(180deg);
    }

    /* Meta details */
    .hero-post-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--muted);
        font-size: 1.05rem;
    }

    .meta-item svg {
        width: 18px;
        height: 18px;
    }

    .category-highlight {
        color: var(--primary);
        font-weight: 600;
    }
    
    .meta-dot {
        color: var(--border);
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
<div class="media-show-wrapper">
    
    <!-- 1. Main Article Content -->
    <div class="media-content-col">
        
        <!-- Cover Image -->
        @if($post->cover_image)
        <div class="media-cover-wrapper">
            <div class="camera-flash"></div>
            <div class="viewfinder top-left"></div>
            <div class="viewfinder top-right"></div>
            <div class="viewfinder bottom-left"></div>
            <div class="viewfinder bottom-right"></div>
            <img src="{{ asset('images/media/' . $post->cover_image) }}" alt="{{ $post->title }}">
        </div>
        @endif

        <!-- Short Description (Lead) -->
        @if($post->short_description_ar || $post->short_description_en)
        <div class="post-lead js-scroll-animate" data-ar="{{ $post->short_description_ar }}" data-en="{{ $post->short_description_en }}">
            {{ $post->short_description }}
        </div>
        @endif

        <!-- Main Content -->
        @if($post->content_ar || $post->content_en)
        <div class="rich-text-content js-scroll-animate" data-ar="{{ $post->content_ar }}" data-en="{{ $post->content_en }}">
            {!! nl2br(e($post->content)) !!}
        </div>
        @endif

        <!-- Dynamic Content Builder Loop -->
        @if($post->contents && $post->contents->count() > 0)
            @foreach($post->contents as $contentBlock)
                <div class="js-scroll-animate">
                    @if($contentBlock->type === 'text')
                        <div class="rich-text-content mt-4" data-ar="{{ $contentBlock->content_ar }}" data-en="{{ $contentBlock->content_en }}">
                            {!! nl2br(e($contentBlock->content)) !!}
                        </div>
                    
                    @elseif($contentBlock->type === 'image' && $contentBlock->media_url)
                        <div class="dynamic-media-block">
                            <img src="{{ asset('storage/' . $contentBlock->media_url) }}" alt="Article Image">
                        </div>
                    
                    @elseif($contentBlock->type === 'video' && $contentBlock->media_url)
                        <div class="dynamic-media-block">
                            <video controls preload="metadata">
                                <source src="{{ asset('storage/' . $contentBlock->media_url) }}" type="video/mp4">
                                <span data-ar="متصفحك لا يدعم تشغيل الفيديو." data-en="Your browser does not support the video tag.">
                                    {{ app()->getLocale() == 'ar' ? 'متصفحك لا يدعم تشغيل الفيديو.' : 'Your browser does not support the video tag.' }}
                                </span>
                            </video>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <!-- 2. Sticky Sidebar -->
    <div class="media-sidebar-col">
        <div class="sidebar-sticky-box">
            
            <!-- Share Widget -->
            <div class="sidebar-card">
                <h3 class="share-title" data-ar="شارك هذا الخبر" data-en="Share this post">
                    {{ app()->getLocale() == 'ar' ? 'شارك هذا الخبر' : 'Share this post' }}
                </h3>
                <div class="share-buttons">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-btn" title="Facebook">
                        <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    </a>
                    <!-- Twitter / X -->
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank" class="share-btn" title="Twitter">
                        <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                    </a>
                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}&title={{ urlencode($post->title) }}" target="_blank" class="share-btn" title="LinkedIn">
                        <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                    </a>
                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . request()->fullUrl()) }}" target="_blank" class="share-btn" title="WhatsApp">
                        <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Next & Previous Navigation -->
            @if($previous || $next)
            <div class="sidebar-card">
                
                @if($next)
                <a href="{{ route('media.show', $next->id) }}" class="nav-post-link">
                    <span class="nav-label">
                        <span data-ar="المقال التالي" data-en="Next Article">{{ app()->getLocale() == 'ar' ? 'المقال التالي' : 'Next Article' }}</span>
                        <svg class="nav-icon-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                    <span class="nav-title" data-ar="{{ $next->title_ar }}" data-en="{{ $next->title_en }}">
                        {{ Str::limit($next->title, 50) }}
                    </span>
                </a>
                @endif

                @if($previous)
                <a href="{{ route('media.show', $previous->id) }}" class="nav-post-link">
                    <span class="nav-label">
                        <svg class="nav-icon-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="transform: rotate(180deg);"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        <span data-ar="المقال السابق" data-en="Previous Article">{{ app()->getLocale() == 'ar' ? 'المقال السابق' : 'Previous Article' }}</span>
                    </span>
                    <span class="nav-title" data-ar="{{ $previous->title_ar }}" data-en="{{ $previous->title_en }}">
                        {{ Str::limit($previous->title, 50) }}
                    </span>
                </a>
                @endif
                
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // 1. ترجمة المحتوى الأولي عبر الجلوبل كلاس إذا لزم الأمر
        if (window.preferences && typeof window.preferences.translate === 'function') {
            window.preferences.translate();
        }

        // 2. حركة ظهور المحتوى الديناميكي بسلاسة عند التمرير (Intersection Observer)
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    // تأثير التتابع البصري (Staggered animation)
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        entry.target.style.transition = 'all 0.8s cubic-bezier(0.25, 1, 0.5, 1)';
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.js-scroll-animate').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            observer.observe(el);
        });
    });
</script>
@endpush
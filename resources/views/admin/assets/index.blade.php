@extends('layouts.admin')

@section('content')
<div class="assets-dashboard-wrapper">
    <!-- Top Action Bar -->
    <div class="lux-page-header">
        <div class="header-titles">
            <div class="breadcrumb-tag">
                <i class="fa-solid fa-photo-film"></i>
                <span>الهوية والوسائط الرقمية</span>
            </div>
            <h1 class="page-title">إدارة الفيديوهات والوسائط (Media & Assets Manager)</h1>
            <p class="page-subtitle">التحكم المركزي في جميع الفيديوهات، البوسترات، الشعارات وهوية الواجهة الرئيسية لمنصة البرلسي.</p>
        </div>
        <div class="header-actions">
            <a href="{{ url('/') }}" target="_blank" class="btn-lux btn-lux-outline">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>معاينة الموقع الحي</span>
            </a>
            <button type="submit" form="assetsForm" class="btn-lux btn-lux-gold">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>حفظ جميع التعديلات</span>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="lux-alert lux-alert-success">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="lux-alert lux-alert-danger">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <div>
            <strong>حدثت بعض الأخطاء أثناء الحفظ:</strong>
            <ul style="margin-top: 5px; padding-right: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form id="assetsForm" action="{{ route('admin.assets.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="sections-accordion-grid">
            @foreach($sections as $secKey => $section)
            <div class="lux-card section-card">
                <div class="section-card-header">
                    <div class="sec-title-icon">
                        <i class="{{ $section['icon'] }}"></i>
                    </div>
                    <div>
                        <h2 class="sec-title">{{ $section['title'] }}</h2>
                        <p class="sec-desc">{{ $section['description'] }}</p>
                    </div>
                </div>

                <div class="items-grid">
                    @foreach($section['items'] as $item)
                    <div class="asset-item-box">
                        <div class="item-header">
                            <div class="item-title-meta">
                                <span class="item-label">{{ $item['label'] }}</span>
                                @if($item['is_custom'])
                                    <span class="badge-custom"><i class="fa-solid fa-check"></i> مخصص</span>
                                @else
                                    <span class="badge-default"><i class="fa-solid fa-cube"></i> أصل افتراضي</span>
                                @endif
                            </div>

                            @if($item['is_custom'])
                            <form action="{{ route('admin.assets.reset', $item['key']) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من استعادة هذا الأصل الافتراضي؟');" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-reset-item" title="استعادة الأصل الافتراضي">
                                    <i class="fa-solid fa-rotate-left"></i> استعادة الافتراضي
                                </button>
                            </form>
                            @endif
                        </div>

                        <!-- Asset Preview Box -->
                        <div class="asset-preview-container">
                            @if($item['type'] === 'video')
                                <div class="video-preview-wrapper">
                                    <video src="{{ $item['effective_url'] }}" controls muted preload="metadata" class="preview-video-element"></video>
                                    <div class="preview-overlay-info">
                                        <i class="fa-solid fa-video"></i>
                                        <span>معاينة الفيديو الحالي</span>
                                    </div>
                                </div>
                            @elseif($item['type'] === 'image')
                                <div class="image-preview-wrapper">
                                    <img src="{{ $item['effective_url'] }}" alt="{{ $item['label'] }}" class="preview-image-element" onerror="this.src='{{ asset('albrolosy_logo.png') }}';">
                                </div>
                            @else
                                <div class="text-preview-wrapper">
                                    <i class="fa-solid fa-phone-volume"></i>
                                    <span class="text-val">{{ $item['effective_url'] }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Controls: File Upload or Direct URL -->
                        <div class="item-controls">
                            @if($item['type'] === 'video' || $item['type'] === 'image')
                                <div class="control-group">
                                    <label class="control-label">
                                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                        <span>رفع ملف جديد من جهازك:</span>
                                    </label>
                                    <div class="file-drop-zone">
                                        <input type="file" name="file_{{ $item['key'] }}" class="file-input-field" accept="{{ $item['type'] === 'video' ? 'video/mp4,video/webm' : 'image/*' }}">
                                    </div>
                                </div>

                                <div class="control-group" style="margin-top: 10px;">
                                    <label class="control-label">
                                        <i class="fa-solid fa-link"></i>
                                        <span>أو رابط خارجي / مسار مباشر:</span>
                                    </label>
                                    <input type="text" name="url_{{ $item['key'] }}" value="{{ $item['is_custom'] && !str_starts_with($item['current_raw'], 'storage/') ? $item['current_raw'] : '' }}" class="lux-input-text" placeholder="https://example.com/asset.{{ $item['type'] === 'video' ? 'mp4' : 'jpg' }}">
                                </div>
                            @else
                                <div class="control-group">
                                    <label class="control-label">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>القيمة الحالية:</span>
                                    </label>
                                    <input type="text" name="url_{{ $item['key'] }}" value="{{ $item['current_raw'] ?? $item['default'] }}" class="lux-input-text" placeholder="{{ $item['default'] }}">
                                </div>
                            @endif

                            <p class="item-help-text">{{ $item['help'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Sticky Bottom Bar -->
        <div class="lux-sticky-save-bar">
            <div class="save-bar-info">
                <i class="fa-solid fa-circle-info"></i>
                <span>عند حفظ التعديلات، سيتم تحديث ملفات العرض والكاش فورياً في كافة أجهزة الزوار.</span>
            </div>
            <button type="submit" class="btn-lux btn-lux-gold">
                <i class="fa-solid fa-check-double"></i>
                <span>حفظ وتحديث المنصة الآن</span>
            </button>
        </div>
    </form>
</div>

<style>
/* ======================================================== */
/* LUXURY ASSETS DASHBOARD STYLES                           */
/* ======================================================== */
.assets-dashboard-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding-bottom: 90px;
}

.lux-page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 25px;
    padding: 24px;
    background: var(--bg-card);
    border: 1px solid var(--glass-border);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.breadcrumb-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--gold);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.page-title {
    font-size: clamp(1.4rem, 2.5vw, 1.85rem);
    font-weight: 800;
    color: var(--text-main);
    line-height: 1.25;
}

.page-subtitle {
    font-size: 0.95rem;
    color: var(--text-muted);
    margin-top: 5px;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.btn-lux {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 22px;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s ease;
    text-decoration: none;
    border: none;
}

.btn-lux-gold {
    background: linear-gradient(135deg, #d7b64a 0%, #b8972e 100%);
    color: #050505 !important;
    box-shadow: 0 6px 20px rgba(215, 182, 74, 0.3);
}

.btn-lux-gold:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(215, 182, 74, 0.45);
}

.btn-lux-outline {
    background: transparent;
    color: var(--text-main);
    border: 1px solid var(--glass-border);
}

.btn-lux-outline:hover {
    border-color: var(--gold);
    color: var(--gold);
    transform: translateY(-2px);
}

.lux-alert {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    font-size: 0.95rem;
}

.lux-alert-success {
    background: rgba(34, 197, 94, 0.12);
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: #22c55e;
}

.lux-alert-danger {
    background: rgba(239, 68, 68, 0.12);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #ef4444;
}

.sections-accordion-grid {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.lux-card {
    background: var(--bg-card);
    border: 1px solid var(--glass-border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.section-card-header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px 24px;
    background: rgba(215, 182, 74, 0.05);
    border-bottom: 1px solid var(--glass-border);
}

.sec-title-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: rgba(215, 182, 74, 0.15);
    color: var(--gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.sec-title {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--text-main);
}

.sec-desc {
    font-size: 0.88rem;
    color: var(--text-muted);
    margin-top: 2px;
}

.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 22px;
    padding: 24px;
}

.asset-item-box {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid var(--glass-border);
    border-radius: 14px;
    padding: 18px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    transition: all 0.25s ease;
}

.asset-item-box:hover {
    border-color: rgba(215, 182, 74, 0.35);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
}

.item-title-meta {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.item-label {
    font-size: 0.98rem;
    font-weight: 700;
    color: var(--text-main);
}

.badge-custom {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.72rem;
    font-weight: 700;
    color: #22c55e;
    background: rgba(34, 197, 94, 0.12);
    padding: 3px 8px;
    border-radius: 6px;
    width: fit-content;
}

.badge-default {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--text-muted);
    background: rgba(255, 255, 255, 0.05);
    padding: 3px 8px;
    border-radius: 6px;
    width: fit-content;
}

.btn-reset-item {
    background: transparent;
    border: none;
    color: #f87171;
    font-size: 0.75rem;
    cursor: pointer;
    font-weight: 600;
    padding: 4px 6px;
    border-radius: 6px;
    transition: all 0.2s;
}

.btn-reset-item:hover {
    background: rgba(239, 68, 68, 0.15);
}

.asset-preview-container {
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
    background: #000;
    border: 1px solid var(--glass-border);
}

.video-preview-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;
    background: #000;
}

.preview-video-element {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.preview-overlay-info {
    position: absolute;
    bottom: 6px;
    right: 8px;
    background: rgba(0,0,0,0.7);
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 0.72rem;
    color: #fff;
    pointer-events: none;
    display: flex;
    align-items: center;
    gap: 5px;
}

.image-preview-wrapper {
    width: 100%;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, rgba(0,0,0,0.5) 100%);
    padding: 10px;
}

.preview-image-element {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 6px;
}

.text-preview-wrapper {
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--gold);
    font-weight: 700;
    font-size: 1.1rem;
}

.item-controls {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.control-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--text-muted);
    margin-bottom: 5px;
}

.file-drop-zone {
    border: 1px dashed var(--glass-border);
    border-radius: 8px;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.02);
    transition: all 0.2s;
}

.file-drop-zone:hover {
    border-color: var(--gold);
}

.file-input-field {
    width: 100%;
    font-size: 0.82rem;
    color: var(--text-main);
    cursor: pointer;
}

.lux-input-text {
    width: 100%;
    background: var(--bg-main);
    border: 1px solid var(--glass-border);
    border-radius: 8px;
    padding: 8px 12px;
    color: var(--text-main);
    font-size: 0.85rem;
    outline: none;
    transition: all 0.2s;
    direction: ltr;
    text-align: right;
}

.lux-input-text:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 2px rgba(215, 182, 74, 0.2);
}

.item-help-text {
    font-size: 0.75rem;
    color: var(--text-muted);
    line-height: 1.4;
}

.lux-sticky-save-bar {
    position: sticky;
    bottom: 20px;
    margin-top: 30px;
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(12px);
    border: 1px solid var(--glass-border);
    border-radius: 16px;
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.4);
    z-index: 99;
}

.save-bar-info {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
    color: var(--text-main);
}

.save-bar-info i {
    color: var(--gold);
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .lux-page-header {
        flex-direction: column;
        align-items: stretch;
    }
    .header-actions {
        flex-direction: column;
    }
    .btn-lux {
        width: 100%;
        justify-content: center;
    }
    .lux-sticky-save-bar {
        flex-direction: column;
        gap: 12px;
        text-align: center;
    }
}
</style>
@endsection

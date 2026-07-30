<style>
    /* ==========================================================================
   Luxury Cinematic Search Interface (Responsive & Highly Fluid)
   ========================================================================== */
    :root {
        --transition-cinematic: all 0.45s cubic-bezier(0.16, 1, 0.3, 1);
        --transition-micro: all 0.2s ease;

        /* Light Theme (Default, overriden on dark preference dynamically) */
        --search-glass-bg: rgba(255, 255, 255, 0.75);
        --search-glass-border: rgba(0, 0, 0, 0.08);
        --search-container-bg: #ffffff;
        --search-input-bg: #f5f5f7;
        --search-text-primary: #1d1d1f;
        --search-text-secondary: #6e6e73;
        --search-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
        --search-card-bg: #ffffff;
        --search-card-hover-bg: #f5f5f7;
        --search-kbd-bg: #e8e8ed;
    }

    /* Dark Theme Support via window.preferences preference class mapping */
    .dark-theme :root,
    [data-theme="dark"] :root {
        --search-glass-bg: rgba(10, 10, 12, 0.85);
        --search-glass-border: rgba(255, 255, 255, 0.06);
        --search-container-bg: #121214;
        --search-input-bg: #1c1c1e;
        --search-text-primary: #f5f5f7;
        --search-text-secondary: #a1a1a6;
        --search-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
        --search-card-bg: #1c1c1e;
        --search-card-hover-bg: #2c2c2e;
        --search-kbd-bg: #2c2c2e;
    }

    /* OVERLAY CONTAINER */
    .search-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        z-index: 100000;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: var(--transition-cinematic);
        padding: 3.5rem 1.5rem;
        overflow-y: auto;
    }

    .search-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* MAIN MODAL WRAPPER */
    .search-modal-container {
        position: relative;
        width: 100%;
        max-width: 860px;
        background: var(--search-container-bg);
        border: 1px solid var(--search-glass-border);
        border-radius: 20px;
        box-shadow: var(--search-shadow);
        transform: scale(0.96) translateY(-10px);
        opacity: 0;
        transition: var(--transition-cinematic);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .search-overlay.active .search-modal-container {
        transform: scale(1) translateY(0);
        opacity: 1;
    }

    /* LUXURY AMBIENT GLOW */
    .search-modal-glow {
        position: absolute;
        top: 0;
        left: 15%;
        right: 15%;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--primary-red, #dc2626), #ff6b6b, var(--primary-red, #dc2626), transparent);
        z-index: 10;
    }

    /* BUTTONS */
    .close-search-btn {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        background: var(--search-input-bg);
        border: none;
        color: var(--search-text-secondary);
        cursor: pointer;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        transition: var(--transition-micro);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        z-index: 100;
    }

    html[dir="rtl"] .close-search-btn {
        right: auto;
        left: 1.5rem;
    }

    .close-search-btn:hover {
        color: #ffffff;
        background: var(--primary-red, #dc2626);
        transform: rotate(90deg);
    }

    /* MODAL HEADER */
    .search-modal-header {
        padding: 2.5rem 2.5rem 1.5rem 2.5rem;
        text-align: left;
    }

    html[dir="rtl"] .search-modal-header {
        text-align: right;
    }

    .search-modal-header h2 {
        color: var(--search-text-primary);
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .search-modal-header p {
        color: var(--search-text-secondary);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    /* FORM STYLING */
    .search-modal-form {
        padding: 0 2.5rem 1.5rem 2.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        border-bottom: 1px solid var(--search-glass-border);
    }

    .search-form-group.full-width {
        width: 100%;
    }

    .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 1.25rem;
        font-size: 1.15rem;
        color: var(--search-text-secondary);
        transition: var(--transition-micro);
    }

    html[dir="rtl"] .input-icon {
        left: auto;
        right: 1.25rem;
    }

    /* MODERN SEARCH INPUT */
    .search-input {
        width: 100%;
        padding: 1.1rem 3.5rem;
        background: var(--search-input-bg);
        border: 1.5px solid transparent;
        border-radius: 12px;
        color: var(--search-text-primary);
        font-size: 1.1rem;
        outline: none;
        transition: var(--transition-cinematic);
        font-family: inherit;
    }

    html[dir="rtl"] .search-input {
        padding: 1.1rem 3.5rem;
    }

    .search-input:focus {
        background: var(--search-container-bg);
        border-color: var(--primary-red, #dc2626);
        box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12);
    }

    .search-input:focus~.input-icon {
        color: var(--primary-red, #dc2626);
        transform: scale(1.1);
    }

    /* CLEAR INPUT BUTTON */
    .clear-input-btn {
        position: absolute;
        right: 3.5rem;
        background: none;
        border: none;
        color: var(--search-text-secondary);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.2rem;
        transition: var(--transition-micro);
        display: flex;
        align-items: center;
    }

    html[dir="rtl"] .clear-input-btn {
        right: auto;
        left: 3.5rem;
    }

    .clear-input-btn:hover {
        color: var(--primary-red, #dc2626);
    }

    /* KEYBOARD SHORTCUT BADGE */
    .keyboard-shortcut-hint {
        position: absolute;
        right: 1.25rem;
        background: var(--search-kbd-bg);
        color: var(--search-text-secondary);
        border-radius: 6px;
        padding: 2px 6px;
        font-size: 0.75rem;
        font-family: monospace, sans-serif;
        font-weight: bold;
        pointer-events: none;
        border: 1px solid var(--search-glass-border);
    }

    html[dir="rtl"] .keyboard-shortcut-hint {
        right: auto;
        left: 1.25rem;
    }

    /* FILTERS GRID */
    .search-filters-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }

    .search-form-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .search-form-group label {
        color: var(--search-text-primary);
        font-size: 0.82rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.8;
    }

    /* SELECT WRAPPERS */
    .custom-select-wrapper {
        position: relative;
    }

    .custom-select-wrapper::after {
        content: "\f078";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--search-text-secondary);
        font-size: 0.8rem;
        pointer-events: none;
    }

    html[dir="rtl"] .custom-select-wrapper::after {
        right: auto;
        left: 1rem;
    }

    .search-select {
        width: 100%;
        padding: 0.75rem 2rem 0.75rem 1rem;
        background: var(--search-input-bg);
        border: 1px solid var(--search-glass-border);
        border-radius: 8px;
        color: var(--search-text-primary);
        font-size: 0.9rem;
        font-weight: 500;
        outline: none;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        transition: var(--transition-micro);
    }

    html[dir="rtl"] .search-select {
        padding: 0.75rem 1rem 0.75rem 2rem;
    }

    .search-select:focus {
        border-color: var(--primary-red, #dc2626);
        background: var(--search-container-bg);
    }

    /* RESULTS VIEWPORT */
    .search-results-viewport {
        max-height: 400px;
        overflow-y: auto;
        padding: 1.5rem 2.5rem;
        background: rgba(0, 0, 0, 0.01);
        scrollbar-width: thin;
        scrollbar-color: var(--search-glass-border) transparent;
    }

    /* FEEDBACK STATES (Initial, Empty, Error) */
    .search-feedback-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 3rem 1rem;
    }

    .search-feedback-state.hidden {
        display: none !important;
    }

    .feedback-icon {
        font-size: 2.5rem;
        color: var(--search-text-secondary);
        opacity: 0.4;
        margin-bottom: 1.25rem;
        transition: var(--transition-cinematic);
    }

    .search-feedback-state:hover .feedback-icon {
        transform: translateY(-5px) scale(1.05);
        opacity: 0.8;
        color: var(--primary-red, #dc2626);
    }

    .search-feedback-state h4 {
        color: var(--search-text-primary);
        font-size: 1.15rem;
        font-weight: 600;
        margin-bottom: 0.4rem;
    }

    .search-feedback-state p {
        color: var(--search-text-secondary);
        font-size: 0.9rem;
        max-width: 440px;
        line-height: 1.5;
    }

    /* RETRY BUTTON */
    .btn-retry-search {
        margin-top: 1.25rem;
        background: var(--primary-red, #dc2626);
        color: #ffffff;
        border: none;
        padding: 0.65rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-micro);
    }

    .btn-retry-search:hover {
        background: #b91c1c;
    }

    /* SKELETAL LOADER STYLES */
    .search-loading-skeleton {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .skeleton-card {
        display: flex;
        gap: 1.25rem;
        padding: 1rem;
        border-radius: 12px;
        background: var(--search-card-bg);
        border: 1px solid var(--search-glass-border);
    }

    .skeleton-image-placeholder {
        width: 90px;
        height: 90px;
        border-radius: 8px;
        background: var(--search-input-bg);
        position: relative;
        overflow: hidden;
    }

    .skeleton-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        justify-content: center;
    }

    .skeleton-line {
        background: var(--search-input-bg);
        border-radius: 4px;
        position: relative;
        overflow: hidden;
    }

    .skeleton-badge {
        width: 60px;
        height: 16px;
    }

    .skeleton-title {
        width: 180px;
        height: 18px;
    }

    .skeleton-subtitle {
        width: 120px;
        height: 14px;
    }

    .skeleton-description {
        width: 100%;
        height: 14px;
    }

    /* Shimmer Keyframe Effects */
    .skeleton-image-placeholder::after,
    .skeleton-line::after {
        content: "";
        position: absolute;
        inset: 0;
        transform: translateX(-100%);
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.08), transparent);
        animation: shimmer-load 1.6s infinite;
    }

    @keyframes shimmer-load {
        100% {
            transform: translateX(100%);
        }
    }

    /* LIVE SEARCH RESULT LIST */
    .search-results-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    /* PREMIUM RESULT CARD */
    .search-result-card {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 0.9rem 1.25rem;
        background: var(--search-card-bg);
        border: 1px solid var(--search-glass-border);
        border-radius: 14px;
        text-decoration: none !important;
        transition: var(--transition-cinematic);
        cursor: pointer;
        outline: none;
        position: relative;
    }

    .search-result-card:hover,
    .search-result-card.focused-item {
        background: var(--search-card-hover-bg);
        border-color: var(--primary-red, #dc2626);
        transform: translateX(6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    html[dir="rtl"] .search-result-card:hover,
    html[dir="rtl"] .search-result-card.focused-item {
        transform: translateX(-6px);
    }

    /* RESULT MEDIA IMAGE & PLACEHOLDERS */
    .result-media-wrapper {
        position: relative;
        width: 84px;
        height: 84px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        border: 1px solid var(--search-glass-border);
    }

    .result-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-cinematic);
    }

    .search-result-card:hover .result-image {
        transform: scale(1.08);
    }

    .result-placeholder-gradient {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #4f46e5, #ec4899);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.5rem;
    }

    /* TYPE ICON FLOATER */
    .type-icon-wrapper {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: var(--search-container-bg);
        border: 1px solid var(--search-glass-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        color: var(--primary-red, #dc2626);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    /* CARD DETAILS */
    .result-card-details {
        flex-grow: 1;
        min-width: 0;
        /* Prevents overflow with CSS Clamping */
    }

    .result-header-row {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin-bottom: 0.35rem;
    }

    .result-type-badge {
        padding: 2px 8px;
        font-size: 0.7rem;
        font-weight: 700;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Dynamically Generated Colors mapped inside JavaScript based on type */
    .badge-project {
        background: rgba(220, 38, 38, 0.1);
        color: #dc2626;
    }

    .badge-sector {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .badge-unit {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .badge-post {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .badge-default {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
    }

    .result-title {
        color: var(--search-text-primary);
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .result-subtitle {
        font-size: 0.8rem;
        color: var(--search-text-secondary);
        margin-bottom: 0.3rem;
        font-weight: 500;
    }

    .result-description {
        font-size: 0.85rem;
        color: var(--search-text-secondary);
        margin: 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* CARD TRAILING ARROW */
    .result-arrow-indicator {
        color: var(--search-text-secondary);
        opacity: 0;
        transform: translateX(-5px);
        transition: var(--transition-micro);
        font-size: 1rem;
        padding: 0 0.5rem;
    }

    html[dir="rtl"] .result-arrow-indicator {
        transform: translateX(5px);
    }

    .search-result-card:hover .result-arrow-indicator,
    .search-result-card.focused-item .result-arrow-indicator {
        opacity: 1;
        transform: translateX(0);
        color: var(--primary-red, #dc2626);
    }

    /* LUXURY FOOTER */
    .search-modal-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 2.5rem;
        background: var(--search-input-bg);
        border-top: 1px solid var(--search-glass-border);
    }

    .shortcut-tags {
        display: flex;
        gap: 1.25rem;
        font-size: 0.8rem;
        color: var(--search-text-secondary);
    }

    .shortcut-tags kbd {
        background: var(--search-container-bg);
        border: 1px solid var(--search-glass-border);
        padding: 2px 5px;
        border-radius: 4px;
        font-family: inherit;
        font-weight: 600;
    }

    .results-meta-counter {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--search-text-secondary);
    }

    /* ==========================================================================
   RESPONSIVE LAYOUT MEDIA QUERIES
   ========================================================================== */

    /* Tablet Optimization */
    @media (max-width: 868px) {
        .search-filters-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Mobile Screens (Becomes a full screen premium viewport) */
    @media (max-width: 576px) {
        .search-overlay {
            padding: 0;
        }

        .search-modal-container {
            max-width: 100%;
            height: 100dvh;
            border-radius: 0;
            border: none;
        }

        .search-modal-header {
            padding: 1.5rem 1.5rem 1rem 1.5rem;
        }

        .search-modal-header h2 {
            font-size: 1.4rem;
        }

        .search-modal-form {
            padding: 0 1.5rem 1.25rem 1.5rem;
            gap: 0.75rem;
        }

        .search-input {
            padding: 0.9rem 2.75rem;
            font-size: 1rem;
        }

        .search-filters-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .search-results-viewport {
            flex-grow: 1;
            max-height: none;
            padding: 1rem 1.5rem;
        }

        .keyboard-shortcut-hint {
            display: none;
        }

        .search-modal-footer {
            padding: 1rem 1.5rem;
            padding-bottom: calc(1rem + env(safe-area-inset-bottom));
        }

        .shortcut-tags {
            display: none;
            /* Shortcuts redundant on pure touchscreens */
        }
    }
</style>

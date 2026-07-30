<style>
    :root {
        --card-bg-dark: #0d0d0f;
        --card-bg-light: #ffffff;
        --text-dark: #f0f0f0;
        --text-light: #111111;
        --border-dark: rgba(228, 220, 199, 0.15);
        --border-light: rgba(0, 0, 0, 0.1);
        --card-shadow-lux: 0 20px 40px rgba(0, 0, 0, 0.4);
        --card-shadow-light: 0 15px 35px rgba(0, 0, 0, 0.08);
        --primary-red: #B40000;
        --accent-gold: #D4AF37;
        --transition-smooth: 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    }

    /* Light Theme Integration */
    html[data-theme="light"] .portfolio-section {
        background-color: #f8f9fa;
        color: var(--text-light);
    }

    html[data-theme="light"] .project-card-item {
        background: var(--card-bg-light);
        border-color: var(--border-light);
    }

    html[data-theme="light"] .project-title-name {
        color: var(--text-light);
    }

    html[data-theme="light"] .project-card-info {
        background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.98) 15%, #ffffff);
    }

    html[data-theme="light"] .unit-block {
        background: #f8f9fa;
        border-color: var(--border-light);
    }

    html[data-theme="light"] .unit-block:hover {
        background: #fff;
        border-color: var(--primary-red);
    }

    html[data-theme="light"] .unit-type {
        color: #555;
    }

    html[data-theme="light"] .unit-val {
        color: var(--primary-red);
    }

    /* Base Styling */
    .portfolio-section {
        background-color: var(--black);
        padding: 6rem 5%;
        position: relative;
        z-index: 25;
        transition: background-color 0.5s ease;
    }

    .portfolio-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .portfolio-header {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        margin-bottom: 4rem;
    }

    @media (min-width: 1024px) {
        .portfolio-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-end;
        }
    }

    .section-subtitle {
        color: var(--primary-red);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 3px;
        display: block;
        margin-bottom: 0.5rem;
    }

    .section-main-title {
        font-size: 2rem;
        font-weight: 300;
        letter-spacing: 1px;
        color: var(--cream-beige);
    }

    @media (min-width: 768px) {
        .section-main-title {
            font-size: 2.8rem;
        }
    }

    /* Controls & Filters */
    .portfolio-controls {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 100%;
    }

    @media (min-width: 1200px) {
        .portfolio-controls {
            width: auto;
            flex-direction: row;
            align-items: center;
        }
    }

    .filter-tabs-wrapper {
        display: flex;
        gap: 0.8rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        scrollbar-width: none;
    }

    .filter-tabs-wrapper::-webkit-scrollbar {
        display: none;
    }

    .filter-tab {
        background: transparent;
        border: 1px solid var(--border-dark);
        color: var(--light-gray);
        padding: 0.6rem 1.5rem;
        cursor: pointer;
        white-space: nowrap;
        border-radius: 4px;
        transition: var(--transition-smooth);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-tab:hover,
    .filter-tab.active {
        border-color: var(--primary-red);
        color: var(--primary-red);
        background-color: rgba(180, 0, 0, 0.05);
    }

    .filter-tab.action-btn {
        border-color: var(--primary-red);
        color: var(--primary-red);
    }

    .filter-tab.action-btn:hover {
        background-color: var(--primary-red);
        color: #fff;
    }

    .sorting-dropdowns {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .premium-select {
        background: var(--card-bg-dark);
        color: var(--warm-beige);
        border: 1px solid var(--border-dark);
        padding: 0.65rem 2.2rem 0.65rem 1rem;
        font-size: 0.85rem;
        cursor: pointer;
        appearance: none;
        outline: none;
        border-radius: 4px;
        transition: all 0.3s;
    }

    html[data-theme="light"] .premium-select {
        background: #fff;
        color: #333;
        border-color: var(--border-light);
    }

    .select-custom-wrapper {
        position: relative;
    }

    .select-custom-wrapper::after {
        content: '▼';
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-red);
        font-size: 0.7rem;
        pointer-events: none;
    }

    html[dir="rtl"] .select-custom-wrapper::after {
        right: auto;
        left: 12px;
    }

    html[dir="rtl"] .premium-select {
        padding: 0.65rem 1rem 0.65rem 2.2rem;
    }

    /* Grid & Cards */
    .projects-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2.5rem;
        will-change: transform, opacity;
    }

    @media (min-width: 768px) {
        .projects-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1200px) {
        .projects-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .project-card-item {
        background: var(--card-bg-dark);
        border: 1px solid var(--border-dark);
        overflow: hidden;
        position: relative;
        border-radius: 12px;
        transition: all var(--transition-smooth);
        will-change: transform, opacity;
        opacity: 1;
        transform: translateY(0) scale(1);
        display: flex;
        flex-direction: column;
    }

    .project-card-item.hidden-card {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
        pointer-events: none;
        position: absolute;
        visibility: hidden;
    }

    .project-card-link-wrapper {
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .project-card-media {
        position: relative;
        height: 260px;
        overflow: hidden;
        background: #000;
        flex-shrink: 0;
    }

    .base-project-img,
    .hover-project-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.6s ease;
    }

    .hover-project-img {
        position: absolute;
        inset: 0;
        opacity: 0;
    }

    .project-status-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(0, 0, 0, 0.75);
        border: 1px solid var(--primary-red);
        padding: 0.4rem 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 1px;
        z-index: 5;
        border-radius: 4px;
        color: #fff;
        backdrop-filter: blur(4px);
    }

    html[dir="rtl"] .project-status-badge {
        left: auto;
        right: 15px;
    }

    /* Hover CTA Message */
    .hover-cta-message {
        position: absolute;
        inset: 0;
        background: rgba(13, 13, 15, 0.85);
        backdrop-filter: blur(5px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.4s ease;
        z-index: 15;
        border: 2px solid var(--primary-red);
        border-radius: 12px 12px 0 0;
        text-align: center;
        padding: 2rem;
    }

    .hover-cta-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-red);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .hover-cta-icon svg {
        width: 20px;
        height: 20px;
        fill: #fff;
    }

    .hover-cta-text {
        color: #fff;
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .hover-cta-subtext {
        color: var(--light-gray);
        font-size: 0.9rem;
    }

    .project-card-info {
        padding: 1.5rem;
        position: relative;
        background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.98) 15%, var(--card-bg-dark));
        margin-top: -40px;
        z-index: 20;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .project-meta-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .project-mini-logo {
        height: 35px;
        max-width: 100px;
        object-fit: contain;
        background: rgba(255, 255, 255, 0.9);
        padding: 4px;
        border-radius: 6px;
    }

    .sector-tag-name {
        font-size: 0.75rem;
        color: var(--primary-red);
        text-transform: uppercase;
        font-weight: bold;
    }

    .project-title-name {
        font-size: 1.4rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 1rem;
    }

    /* Prominent Location Button */
    .location-btn-prominent {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-dark);
        padding: 0.8rem 1rem;
        border-radius: 6px;
        color: var(--light-gray);
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .location-btn-prominent .loc-icon {
        background: rgba(180, 0, 0, 0.1);
        padding: 8px;
        border-radius: 4px;
        display: flex;
    }

    .location-btn-prominent .loc-icon svg {
        width: 16px;
        height: 16px;
        fill: var(--primary-red);
    }

    .location-btn-prominent .loc-text {
        font-size: 0.85rem;
        flex-grow: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .location-btn-prominent .loc-arrow {
        color: var(--primary-red);
        opacity: 0.5;
        transition: opacity 0.3s;
    }

    .location-btn-prominent:hover {
        background: rgba(180, 0, 0, 0.05);
        border-color: var(--primary-red);
        color: #fff;
    }

    .location-btn-prominent:hover .loc-arrow {
        opacity: 1;
        transform: translateX(3px);
    }

    html[dir="rtl"] .location-btn-prominent:hover .loc-arrow {
        transform: translateX(-3px);
    }

    html[data-theme="light"] .location-btn-prominent {
        background: #f8f9fa;
        border-color: var(--border-light);
        color: #555;
    }

    html[data-theme="light"] .location-btn-prominent:hover {
        color: #000;
        border-color: var(--primary-red);
    }

    /* Units Showcase (The Blocks) */
    .units-showcase-title {
        font-size: 0.8rem;
        color: var(--light-gray);
        text-transform: uppercase;
        margin-bottom: 0.8rem;
        letter-spacing: 1px;
    }

    .units-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .unit-block {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-dark);
        border-radius: 6px;
        padding: 0.8rem;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .unit-block:hover {
        background: rgba(180, 0, 0, 0.08);
        border-color: var(--primary-red);
        transform: translateY(-3px);
    }

    .unit-type {
        display: block;
        font-size: 0.75rem;
        color: var(--light-gray);
        margin-bottom: 0.4rem;
        font-weight: 600;
    }

    .unit-val {
        display: block;
        font-size: 0.9rem;
        color: var(--warm-beige);
        font-weight: bold;
        line-height: 1.3;
    }

    .unit-val.highlight {
        color: var(--primary-red);
    }

    /* Footer Specs */
    .project-specs-footer {
        margin-top: auto;
        border-top: 1px dashed var(--border-dark);
        padding-top: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .spec-item small {
        display: block;
        color: var(--light-gray);
        font-size: 0.7rem;
        margin-bottom: 0.2rem;
    }

    .spec-item strong {
        color: #fff;
        font-size: 0.9rem;
    }

    html[data-theme="light"] .spec-item strong {
        color: #111;
    }

    /* Main Hover Animations */
    .project-card-item:hover {
        transform: translateY(-8px);
        box-shadow: var(--card-shadow-lux);
        border-color: rgba(180, 0, 0, 0.5);
    }

    .project-card-item:hover .base-project-img {
        transform: scale(1.08);
    }

    .project-card-item:hover .hover-project-img {
        opacity: 1;
        transform: scale(1.08);
    }

    .project-card-item:hover .hover-cta-message {
        opacity: 1;
        transform: translateY(0);
    }
    
</style>


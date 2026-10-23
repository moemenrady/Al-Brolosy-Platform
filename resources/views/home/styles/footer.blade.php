<style>
    /* ==========================================
   Moemen Team Visual Identity & Colors
   ========================================== */
    :root {
        --mt-deep-forest: #1F2A24;
        --mt-dark-olive: #374A3C;
        --mt-moemen-green: #50605500;
        --mt-sage-green: #af806f1e;
        --mt-light-gray: #A7B7A7;

        /* Light Mode Dynamic Mapping */
        --footer-bg-start: #f4f7f5;
        --footer-bg-end: #e2e9e4;
        --footer-card-bg: rgba(255, 255, 255, 0.75);
        --footer-card-border: rgba(80, 96, 85, 0.2);
        --footer-text-primary: #1F2A24;
        --footer-text-secondary: #374A3C;
        --footer-accent-glow: rgba(80, 96, 85, 0.15);
        --footer-shadow: 0 20px 40px rgba(31, 42, 36, 0.08);
    }

    [data-theme="dark"],
    html.dark {
        /* Dark Mode Dynamic Mapping */
        --footer-bg-start: #0f1612;
        --footer-bg-end: #1F2A24;
        --footer-card-bg: rgba(31, 42, 36, 0.65);
        --footer-card-border: rgba(167, 183, 167, 0.2);
        --footer-text-primary: #ffffff;
        --footer-text-secondary: #A7B7A7;
        --footer-accent-glow: rgba(175, 128, 111, 0.25);
        --footer-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
    }

    /* ==========================================
   Footer Base Layout
   ========================================== */
    .moemen-footer {
        position: relative;
        width: 100%;
        background: linear-gradient(135deg, var(--footer-bg-start) 0%, var(--footer-bg-end) 100%);
        color: var(--footer-text-primary);
        padding: 80px 20px 30px;
        overflow: hidden;
        transition: background 0.5s ease, color 0.5s ease;
        font-family: 'Cairo', 'Inter', sans-serif;
    }

    .footer-canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .footer-glow-effect {
        position: absolute;
        top: 7%;
        left: 7%;
        transform: translate(-50%, -50%);
        width: 600px;
        height: 100px;
        background: radial-gradient(circle, var(--footer-accent-glow) 0%, rgba(0, 0, 0, 0) 70%);
        filter: blur(80px);
        z-index: 1;
        pointer-events: none;
    }

    .footer-container {
        position: relative;
        z-index: 2;
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* ==========================================
   Hero Interactive Glass Card
   ========================================== */
    .footer-hero-card {
        width: 100%;
        background: var(--footer-card-bg);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid var(--footer-card-border);
        border-radius: 28px;
        padding: 50px 30px;
        box-shadow: var(--footer-shadow);
        text-align: center;
        position: relative;
        transition: transform 0.4s ease, border-color 0.4s ease;
    }

    .footer-hero-card:hover {
        transform: translateY(-5px);
        border-color: var(--mt-moemen-green);
    }

    .hero-card-content {
        max-width: 680px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    /* Status Badge */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 50px;
        background: rgba(80, 96, 85, 0.12);
        border: 1px solid var(--footer-card-border);
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--footer-text-secondary);
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        background-color: #22c55e;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        animation: pulse-ring 1.8s infinite;
    }

    @keyframes pulse-ring {
        0% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
        }
    }

    /* Title & Description */
    .platform-title {
        font-size: 1.8rem;
        font-weight: 800;
        line-height: 1.3;
        margin: 0;
        color: var(--footer-text-primary);
    }

    .footer-description {
        font-size: 1rem;
        line-height: 1.7;
        color: var(--footer-text-secondary);
        margin: 0;
    }

    /* Team Branding */
    .team-brand-wrapper {
        margin: 10px 0;
    }

    .team-brand-link {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
        padding: 10px 22px;
        border-radius: 16px;
        background: rgba(31, 42, 36, 0.05);
        border: 1px solid var(--footer-card-border);
        transition: all 0.3s ease;
    }

    [data-theme="dark"] .team-brand-link,
    html.dark .team-brand-link {
        background: rgba(255, 255, 255, 0.05);
    }

    .team-brand-link:hover {
        transform: scale(1.03);
        border-color: var(--mt-sage-green);
        background: rgba(80, 96, 85, 0.15);
    }

    .logo-box {
        width: 38px;
        height: 38px;
        color: var(--mt-sage-green);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .team-brand-text {
        display: flex;
        flex-direction: column;
        text-align: right;
    }

    [dir="ltr"] .team-brand-text {
        text-align: left;
    }

    .team-name {
        font-size: 1.2rem;
        font-weight: 900;
        letter-spacing: 1.5px;
        color: var(--footer-text-primary);
    }

    .team-slogan {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--mt-sage-green);
        font-weight: 700;
    }

    /* Glow CTA Button */
    .btn-portfolio-glow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        border-radius: 50px;
        background: linear-gradient(135deg, var(--mt-dark-olive), var(--mt-deep-forest));
        color: #ffffff;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        box-shadow: 0 10px 25px rgba(31, 42, 36, 0.3);
        transition: all 0.3s ease;
    }

    .btn-portfolio-glow:hover {
        background: linear-gradient(135deg, var(--mt-moemen-green), var(--mt-dark-olive));
        box-shadow: 0 15px 30px rgba(175, 128, 111, 0.35);
        transform: translateY(-2px);
    }

    .arrow-icon {
        width: 18px;
        height: 18px;
        transition: transform 0.3s ease;
    }

    [dir="rtl"] .arrow-icon {
        transform: rotate(180deg);
    }

    .btn-portfolio-glow:hover .arrow-icon {
        transform: translateX(4px);
    }

    [dir="rtl"] .btn-portfolio-glow:hover .arrow-icon {
        transform: rotate(180deg) translateX(4px);
    }

    /* ==========================================
   Footer Bottom Bar
   ========================================== */
    .footer-bottom-bar {
        margin-top: 40px;
        text-align: center;
        font-size: 0.88rem;
        color: var(--footer-text-secondary);
    }

    .team-inline-link {
        color: var(--mt-sage-green);
        text-decoration: none;
        font-weight: 700;
        transition: color 0.2s;
    }

    .team-inline-link:hover {
        text-decoration: underline;
    }

    /* ==========================================
   Responsive Adaptations
   ========================================== */
    @media (max-width: 768px) {
        .moemen-footer {
            padding: 50px 15px 25px;
        }

        .footer-hero-card {
            padding: 35px 20px;
            border-radius: 20px;
        }

        .platform-title {
            font-size: 1.4rem;
        }

        .footer-description {
            font-size: 0.9rem;
        }
    }
</style>

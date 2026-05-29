<?php
/**
 * index.php — Solo Parent Profiling System Institutional Portal Landing Page
 * Architectural Guidelines: High Trust, Deep Accessibility, Zero Lag.
 */
require_once __DIR__ . '/includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solo Parent Profiling System | Barangay Sankanan Portal</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* ============================================================
           INSTITUTIONAL THEME PALETTE & BRAND VARIABLES
           ============================================================ */
        :root {
            /* Core Theme - Exact Match to Split Screen Login UI Blue */
            --sp-primary:        #0052cc;       /* Vibrant Core Royal Blue */
            --sp-primary-dk:     #003d99;       /* Deep Interactive Blue */
            --sp-primary-lg:     #e6f0ff;       /* Soft Light Accent Blue Tints */
            --sp-midnight:       #0f172a;       /* High-Contrast Off-Black Slate Header */
            --sp-success:        #198754;       /* Welfare Emerald Green */
            
            /* Blended Base Canvas */
            --sp-bg:             #f8fafc;       /* Muted Off-White Screen Canvas */
            --sp-card-bg:        #ffffff;
            --font-system: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            
            /* Structural Animation Speed Matrix (Premium SaaS Feel) */
            --transition-premium: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.03);
            --shadow-md: 0 12px 34px -10px rgba(0, 82, 204, 0.08);
            --shadow-lg: 0 24px 48px -15px rgba(15, 23, 42, 0.09);
        }

        /* ----- Base Blending Engine ----- */
        body {
            font-family: var(--font-system);
            background-color: var(--sp-bg);
            /* Rich micro-mesh backdrop pattern to maximize color tone alignment */
            background-image: 
                radial-gradient(at 85% 20%, rgba(0, 82, 204, 0.06) 0px, transparent 50%),
                radial-gradient(at 15% 85%, rgba(25, 135, 84, 0.04) 0px, transparent 50%),
                linear-gradient(rgba(226, 232, 240, 0.5) 1px, transparent 1px),
                linear-gradient(90deg, rgba(226, 232, 240, 0.5) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 44px 44px, 44px 44px;
            color: #334155;
            overflow-x: hidden;
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
        }
 /* ----- Hardware-Accelerated Scroll Reveal Framework ----- */
        .reveal-element {
            opacity: 0;
            transform: translateY(35px) scale(0.99);
            will-change: transform, opacity;
            transition: var(--transition-premium);
        }
        .reveal-element.active {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* ----- Text and Color Overrides ----- */
        .text-primary { color: var(--sp-primary) !important; }
        .bg-primary { background-color: var(--sp-primary) !important; }

        /* ----- Sections Spacing ----- */
        .section-padding {
            padding: 8.5rem 0;
            position: relative;
        }
        .section-tag {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--sp-primary);
            margin-bottom: 0.75rem;
            display: inline-block;
        }
        .section-title {
            font-weight: 800;
            letter-spacing: -1.2px;
            color: var(--sp-midnight);
            line-height: 1.2;
        }

        /* Glassmorphic Top Navigation Bar */
        .custom-navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            padding: 1.25rem 0;
            transition: var(--transition-premium);
            z-index: 1050;
        }
        .custom-navbar.scrolled {
            padding: 0.8rem 0;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow-sm);
            border-bottom-color: #e2e8f0;
        }
        .nav-link {
            color: var(--sp-midnight);
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s ease, transform 0.2s ease;
        }
        .nav-link:hover {
            color: var(--sp-primary);
            transform: translateY(-1px);
        }

        /* Hero Container Components */
        .hero-section {
            padding: 14rem 0 10rem 0;
            position: relative;
        }
        .hero-showcase {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .hero-showcase::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 2rem;
            background: linear-gradient(135deg, rgba(0, 82, 204, 0.12), transparent 50%, rgba(25, 135, 84, 0.05));
            z-index: 2;
            pointer-events: none;
        }

        /* Premium Adaptive Grid Cards */
        .interactive-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            padding: 2.75rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-premium);
            height: 100%;
        }
        .interactive-card:hover {
            transform: translateY(-6px);
            border-color: rgba(0, 82, 204, 0.3);
            box-shadow: var(--shadow-md);
        }
        .card-icon-box {
            width: 54px;
            height: 54px;
            border-radius: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.75rem;
            font-size: 1.4rem;
        }

        /* Interactive Process Nodes */
        .process-node {
            position: relative;
            padding: 2.75rem;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-premium);
        }
        .process-node:hover {
            box-shadow: var(--shadow-md);
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }
        .process-badge {
            position: absolute;
            top: -14px;
            left: 28px;
            background: var(--sp-midnight);
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.35rem 0.95rem;
            border-radius: 2rem;
            letter-spacing: 0.75px;
        }

        /* Production Grade Premium Accent Buttons */
        .btn-gov-primary {
            background-color: var(--sp-primary);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.9rem 2.5rem;
            border-radius: 0.75rem;
            border: 1px solid var(--sp-primary);
            transition: var(--transition-premium);
        }
        .btn-gov-primary:hover {
            background-color: var(--sp-primary-dk);
            border-color: var(--sp-primary-dk);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -5px rgba(0, 82, 204, 0.3);
        }
        .btn-gov-outline {
            background-color: transparent;
            color: var(--sp-midnight);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.9rem 2.5rem;
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            transition: var(--transition-premium);
        }
        .btn-gov-outline:hover {
            background-color: rgba(0, 82, 204, 0.05);
            border-color: var(--sp-primary);
            color: var(--sp-primary);
            transform: translateY(-2px);
        }

        /* Accessible Form Accordion Extensions */
        .accordion-item {
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem !important;
            margin-bottom: 1.2rem;
            overflow: hidden;
            background: #ffffff;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-premium);
        }
        .accordion-button {
            padding: 1.75rem;
            font-weight: 600;
            color: var(--sp-midnight);
            box-shadow: none !important;
            background: #ffffff;
        }
        .accordion-button:not(.collapsed) {
            background: #f1f5f9;
            color: var(--sp-primary);
        }

        /* Institutional High-Visibility Analytics Dashboard Strip */
        .stats-strip {
            background-color: var(--sp-midnight);
            background-image: 
                radial-gradient(at 100% 0%, rgba(0, 82, 204, 0.2) 0px, transparent 60%),
                radial-gradient(at 0% 100%, rgba(25, 135, 84, 0.08) 0px, transparent 60%);
            padding: 7.5rem 0;
            position: relative;
        }
        .stats-divider-line {
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }
        .stats-number {
            font-size: 3.75rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -1.5px;
        }
        .stats-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.75);
        }
        @media (max-width: 767.98px) {
            .stats-divider-line { 
                border-right: none; 
                border-bottom: 1px solid rgba(255, 255, 255, 0.08); 
                padding-bottom: 2.5rem; 
                margin-bottom: 2.5rem; 
            }
        }

        /* Clean Corporate Footer Platform Layer */
        .premium-footer {
            background-color: #070b12;
            color: #ffffff;
            padding: 6.5rem 0 3.5rem 0;
            position: relative;
            border-top: 1px solid rgba(255, 255, 255, 0.03);
        }
        .footer-header-text {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #38bdf8;
        }
        .footer-detail-link {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .footer-detail-link:hover {
            color: #38bdf8 !important;
            transform: translateX(2px);
        }
        .footer-copyright-strip {
            margin-top: 5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.45);
        }
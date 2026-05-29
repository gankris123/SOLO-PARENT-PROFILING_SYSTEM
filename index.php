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
          </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top custom-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-uppercase" href="#" style="color: var(--sp-midnight); font-size: 1rem; letter-spacing: 0.5px;">
            <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-3" style="width: 34px; height: 34px;">
                <i class="bi bi-people-fill fs-6"></i>
            </div>
            <span>SPPS Portal</span>
        </a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <i class="bi bi-list fs-2"></i>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav ms-auto gap-4 align-items-center mt-3 mt-lg-0">
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#benefits">Benefits</a></li>
                <li class="nav-item"><a class="nav-link" href="#process">Workflow</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                <li class="nav-item ms-lg-2">
                    <a class="btn-gov-primary py-2 px-4 text-decoration-none d-inline-block" href="<?= BASE_URL ?>/login.php" style="font-size: 0.85rem; padding: 0.65rem 1.6rem !important;">
                        <i class="bi bi-shield-lock-fill me-2"></i>Admin Console
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5">
                <div class="d-inline-flex align-items-center gap-2 bg-white border border-slate-200 px-3 py-1.5 rounded-pill mb-4 shadow-sm">
                    <span class="d-inline-block bg-success rounded-circle" style="width: 6px; height: 6px;"></span>
                    <span class="fw-bold text-dark" style="font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">Official Barangay Sankanan Public Portal</span>
                </div>
                <h1 class="display-5 fw-extrabold mb-3" style="font-weight: 800; line-height: 1.15; letter-spacing: -1.8px;">
                    Empowering Solo Parents Through Clean Digital Records
                </h1>
                <p class="text-muted fs-6 mb-4" style="line-height: 1.65; max-width: 520px;">
                    An advanced, institutional welfare architecture built explicitly to process applications, track dynamic sector dependencies, and manage resource allocations with integrity.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#about" class="btn-gov-primary d-flex align-items-center gap-2">Explore Portal <i class="bi bi-arrow-down small"></i></a>
                    <a href="<?= BASE_URL ?>/login.php" class="btn-gov-outline">Access Registry</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-showcase p-4 p-md-5 text-center reveal-element active">
                    <div class="p-5 bg-light rounded-4 border border-light d-flex flex-column align-items-center justify-content-center">
                        <div class="bg-white text-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center mb-4" style="width: 84px; height: 84px; border: 1px solid #e2e8f0;">
                            <i class="bi bi-shield-check-fill fs-1"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Production Grade Security</h4>
                        <p class="text-muted small px-lg-3 mb-0" style="line-height: 1.65;">Hardware-accelerated data isolation and strict authentication parameters protect the household tracking records of every constituent.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section id="about" class="section-padding bg-white reveal-element">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0">
                <span class="section-tag">About the Architecture</span>
                <h2 class="section-title mb-3">Transparent Social Welfare Management</h2>
                <p class="text-muted mb-0" style="line-height: 1.75; font-size: 0.95rem;">
                    The Solo Parent Profiling System (SPPS) serves as an administrative anchor for Barangay Sankanan. It eliminates old paper-based tracking by centralizing applications, document reviews, and status auditing into one secure web dashboard.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="p-4 rounded-4 h-100" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="text-success mb-3"><i class="bi bi-patch-check-fill fs-1"></i></div>
                            <h5 class="fw-bold text-dark mb-2">Verified Validation</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.55;">Eliminates profile processing fraud through multi-stage digital validation checkpoints.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-4 rounded-4 h-100" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="text-primary mb-3"><i class="bi bi-lightning-charge-fill fs-1"></i></div>
                            <h5 class="fw-bold text-dark mb-2">Instant Operations</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.55;">Accelerates verification times across local sectors to speed up resource provisioning.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="features" class="section-padding bg-clear reveal-element">
    <div class="container">
        <div class="text-center mb-5 pb-2">
            <span class="section-tag">Key Features</span>
            <h2 class="section-title mb-2">Engineered to Support Administrators</h2>
            <p class="text-muted mx-auto mb-0" style="max-width: 540px; font-size: 0.95rem;">Built on centralized data protocols to optimize tracking workflows and reduce administrative work.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="interactive-card">
                    <div class="card-icon-box bg-primary bg-opacity-10 text-primary"><i class="bi bi-folder-fill"></i></div>
                    <h5 class="fw-bold text-dark mb-2">Central Registry</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.65;">Store constituent profiles, contact vectors, and family records inside an encrypted core container.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="interactive-card">
                    <div class="card-icon-box bg-success bg-opacity-10 text-success"><i class="bi bi-file-earmark-text-fill"></i></div>
                    <h5 class="fw-bold text-dark mb-2">Requirements Tracking</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.65;">Monitor active identification cards, birth certificate filings, and validation affidavits without physical filing space limits.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="interactive-card">
                    <div class="card-icon-box bg-primary bg-opacity-10 text-primary"><i class="bi bi-graph-up-arrow"></i></div>
                    <h5 class="fw-bold text-dark mb-2">Demographic Metrics</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.65;">Generate instant statistical overviews of single-parent households to optimize regional financial assistance programs.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="benefits" class="section-padding bg-white reveal-element">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="p-4 p-md-5 text-white rounded-4 position-relative overflow-hidden shadow-lg" style="background: linear-gradient(135deg, #0052cc 0%, #002266 100%);">
                    <h3 class="fw-bold mb-3" style="letter-spacing: -0.5px;">Prioritizing the Community</h3>
                    <p class="opacity-75 small mb-4" style="line-height: 1.65;">The system supports the community by matching clear profile tracking parameters directly with local government programs.</p>
                    <ul class="list-unstyled d-grid gap-3 mb-0 opacity-90 small">
                        <li class="d-flex align-items-start gap-2"><i class="bi bi-check-circle-fill text-white fs-5 mt-n1"></i> <span>Guarantees verified entry into community social welfare aid pipelines.</span></li>
                        <li class="d-flex align-items-start gap-2"><i class="bi bi-check-circle-fill text-white fs-5 mt-n1"></i> <span>Speeds up identity audits during annual certification distribution phases.</span></li>
                        <li class="d-flex align-items-start gap-2"><i class="bi bi-check-circle-fill text-white fs-5 mt-n1"></i> <span>Removes repeated paperwork—submit credentials once and keep your parameters securely logged.</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <span class="section-tag">Community Benefits</span>
                <h2 class="section-title mb-3">Ensuring No Single-Parent Family Falls Behind</h2>
                <p class="text-muted small mb-4" style="line-height: 1.65;">By formalizing data collection processes, this platform allows local government staff to allocate support fairly, guaranteeing resources reach those who qualify.</p>
                <a href="#process" class="btn-gov-primary text-decoration-none">View Platform Workflow</a>
            </div>
        </div>
    </div>
</section>

<section id="process" class="section-padding bg-clear reveal-element">
    <div class="container">
        <div class="text-center mb-5 pb-2">
            <span class="section-tag">How It Works</span>
            <h2 class="section-title mb-2">The Profiling Workflow</h2>
            <p class="text-muted mx-auto mb-0" style="max-width: 500px; font-size: 0.95rem;">A secure, step-by-step pipeline ensuring documentation validity and reliable records.</p>
        </div>
        <div class="row g-4 pt-2">
            <div class="col-md-4">
                <div class="process-node h-100">
                    <div class="process-badge">STEP 01</div>
                    <h5 class="fw-bold text-dark mb-2 mt-2">Information Intake</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.6;">The intake officer collects household background data and initializes a distinct profile identifier inside the system registry.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="process-node h-100">
                    <div class="process-badge" style="background: var(--sp-primary);">STEP 02</div>
                    <h5 class="fw-bold text-dark mb-2 mt-2">Document Audit</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.6;">Required document credentials, identification filings, and affidavits are cross-referenced to eliminate entry errors.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="process-node h-100">
                    <div class="process-badge" style="background: var(--sp-success);">STEP 03</div>
                    <h5 class="fw-bold text-dark mb-2 mt-2">Verified Profile</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.6;">The record parameters are locked as an approved account, granting immediate access to ongoing welfare allocation programs.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="stats-strip text-white text-center">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4 stats-divider-line">
                <div class="stats-column-box">
                    <div class="stats-number count-stat mb-2" style="color: #38bdf8 !important;" data-target="1420">0</div>
                    <div class="stats-label">Active Profiles Tracking</div>
                </div>
            </div>
            <div class="col-md-4 stats-divider-line">
                <div class="stats-column-box">
                    <div class="stats-number count-stat mb-2" style="color: #4ade80 !important;" data-target="100">0</div>
                    <div class="stats-label">Audit Integrity Rating (%)</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-column-box">
                    <div class="stats-number count-stat mb-2" style="color: #facc15 !important;" data-target="12">0</div>
                    <div class="stats-label">Active Regional Links</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="faq" class="section-padding bg-white reveal-element">
    <div class="container">
        <div class="text-center mb-5 pb-2">
            <span class="section-tag">Information Desk</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q1">
                                How is personal information protected within this system?
                            </button>
                        </h2>
                        <div id="q1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                The SPPS infrastructure uses strict session variables, restricted admin access states, and continuous parameter filtering to keep constituent records confidential.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2">
                                What documents are required for registry enrollment?
                            </button>
                        </h2>
                        <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Registrants must provide an official affidavit of solo parenthood, child dependency certificates, and proof of residence for verification.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="premium-footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="bg-primary text-white rounded-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                        <i class="bi bi-people-fill small"></i>
                    </div>
                    <h5 class="mb-0 text-white fw-bold" style="font-size: 0.95rem; letter-spacing: 0.5px;">SPPS PORTAL</h5>
                </div>
                <p class="small mb-0" style="max-width: 380px; line-height: 1.7; color: rgba(255, 255, 255, 0.65);">
                    Official administrative system for the local government of Barangay Sankanan. Designed to provide transparent community support workflows.
                </p>
            </div>
            <div class="col-lg-3 offset-lg-1">
                <h6 class="footer-header-text mb-3">Contact Support</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="tel:+630881234567" class="footer-detail-link d-flex align-items-center gap-2">
                        <i class="bi bi-telephone text-info"></i> +63 (088) 123-4567
                    </a>
                    <a href="mailto:support@sankanan.gov.ph" class="footer-detail-link d-flex align-items-center gap-2">
                        <i class="bi bi-envelope text-info"></i> support@sankanan.gov.ph
                    </a>
                </div>
            </div>
            <div class="col-lg-3">
                <h6 class="footer-header-text mb-3">Desk Hours</h6>
                <p class="small mb-0" style="line-height: 1.6; color: rgba(255, 255, 255, 0.65);">
                    <span class="text-white fw-medium">Monday – Friday</span><br>
                    8:00 AM – 5:00 PM PST
                </p>
            </div>
        </div>
        <div class="footer-copyright-strip d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <span>&copy; <?= date('Y') ?> Barangay Sankanan Local Government. All Rights Reserved.</span>
            <span class="fw-semibold px-3 py-1 rounded-pill" style="background: rgba(255, 255, 255, 0.05); color: rgba(255, 255, 255, 0.65);">Version <?= APP_VERSION ?></span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Navbar Scroll Event
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.custom-navbar');
        if (window.scrollY > 30) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Premium Web API Intersection Observer for Section Reveals
    const observerOptions = { threshold: 0.08, rootMargin: "0px 0px -20px 0px" };
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal-element').forEach(el => revealObserver.observe(el));

    // Logarithmic Smooth Stat Counters
    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const targetElement = entry.target;
                const targetNumber = parseInt(targetElement.getAttribute('data-target'), 10);
                
                let currentCount = 0;
                const totalDuration = 1800; 
                const frameRate = 1000 / 60; 
                const totalFrames = Math.round(totalDuration / frameRate);
                let currentFrame = 0;

                function easeOutCubic(t) {
                    return 1 - Math.pow(1 - t, 3);
                }

                const countInterval = setInterval(() => {
                    currentFrame++;
                    const progress = currentFrame / totalFrames;
                    const easedProgress = easeOutCubic(progress);
                    currentCount = Math.round(easedProgress * targetNumber);

                    if (currentFrame >= totalFrames) {
                        targetElement.innerText = targetNumber.toLocaleString();
                        clearInterval(countInterval);
                    } else {
                        targetElement.innerText = currentCount.toLocaleString();
                    }
                }, frameRate);

                observer.unobserve(targetElement);
            }
        });
    }, { threshold: 0.2 });

    document.querySelectorAll('.count-stat').forEach(stat => counterObserver.observe(stat));
</script>
</body>
</html>
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

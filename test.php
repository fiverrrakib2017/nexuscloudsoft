
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>isp billing - Home</title>

    <!-- Fonts: Noto Sans Bengali for better Bangla rendering, plus Outfit for English numbers/brand -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700;800&family=Outfit:wght@600;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Primary Meta Tags -->
<title>isp billing - Home</title>
<meta name="title" content="রক্ত খুঁজি - Home">
<meta name="description" content="Area-based blood donor network in Bangladesh. Find nearby donors in emergencies or become a donor and save lives.">
<meta name="keywords" content="blood donation bangladesh, blood donor search, rokto khuji, find blood donors, emergency blood bangladesh, donate blood, voluntary blood donation">
<meta name="author" content="রক্ত খুঁজি">
<meta name="robots" content="index, follow">
<meta name="language" content="en">
<meta name="revisit-after" content="3 days">
<link rel="canonical" href="https://blood.lilyra.com">

<!-- Favicon -->
<link rel="icon" type="image/png" href="https://blood.lilyra.com/images/favicon.png">
<link rel="apple-touch-icon" href="https://blood.lilyra.com/images/favicon.png">

<!-- Open Graph / Facebook / LinkedIn / WhatsApp -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://blood.lilyra.com">
<meta property="og:title" content="রক্ত খুঁজি - Home">
<meta property="og:description" content="Area-based blood donor network in Bangladesh. Find nearby donors in emergencies or become a donor and save lives.">
<meta property="og:image" content="https://blood.lilyra.com/images/og-image.png">
<meta property="og:site_name" content="রক্ত খুঁজি">
<meta property="og:locale" content="en_US">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://blood.lilyra.com">
<meta property="twitter:title" content="রক্ত খুঁজি - Home">
<meta property="twitter:description" content="Area-based blood donor network in Bangladesh. Find nearby donors in emergencies or become a donor and save lives.">
<meta property="twitter:image" content="https://blood.lilyra.com/images/og-image.png">

<!-- Theme Color for Browsers -->
<meta name="theme-color" content="#dc3545">


    <style>
        :root {
            --primary-red: #dc3545;
            --primary-rose: #e83e8c;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Noto Sans Bengali', sans-serif;
            background-color: var(--bg-light);
            color: #333;
            overflow-x: hidden;
            position: relative;
        }

        .brand-font {
            font-family: 'Outfit', sans-serif;
        }

        /* Custom Background Pattern */
        .bg-grid-pattern {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(rgba(220, 53, 69, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            z-index: -2;
        }

        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .background-wrapper {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: -2;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            filter: blur(60px);
            opacity: 0.5;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }
        .blob-1 {
            background-color: #ffb3b3;
            width: 400px; height: 400px;
            top: -10%; left: -10%;
        }
        .blob-2 {
            background-color: #ffc2d1;
            width: 400px; height: 400px;
            bottom: 10%; right: -5%;
            animation-delay: 2s;
        }

        /* Glassmorphism */
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.6);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 1.5rem;
            transition: all 0.3s ease;
        }
        
        /* Subtle Scroll Animations */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Mobile FAB (Floating Action Button) */
        .mobile-fab {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1040;
            background: linear-gradient(135deg, var(--primary-red), var(--primary-rose));
            color: white;
            border-radius: 50px;
            padding: 12px 20px;
            font-weight: 700;
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
        }
        .mobile-fab:active {
            transform: scale(0.95);
        }
        
        /* Input Focus Glow */
        .form-control:focus, .form-select:focus {
            border-color: rgba(220, 53, 69, 0.5);
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.15);
        }
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: var(--primary-red);
            font-weight: 600;
        }

        /* Custom Gradients & Text */
        .text-gradient {
            background: linear-gradient(90deg, var(--primary-red), var(--primary-rose));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-red), var(--primary-rose));
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary-red), var(--primary-rose));
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #c82333, #d63384);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.3);
        }

        .btn-outline-custom {
            background: white;
            color: #212529;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .btn-outline-custom:hover {
            border-color: #ffccd5;
            color: var(--primary-red);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        /* Hero Section Base */
        .hero-section {
            padding-top: 200px;
            padding-bottom: 120px;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        /* Feature Icon Box */
        .icon-box {
            width: 65px; height: 65px;
            background: linear-gradient(135deg, #ffe5e5, #fff0f5);
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--primary-red);
            margin-bottom: 1.5rem;
            box-shadow: inset 0 2px 4px rgba(255,255,255,0.8);
            transition: transform 0.3s ease;
        }
        .glass-card:hover .icon-box {
            transform: scale(1.1);
        }

        /* Step circle */
        .step-circle {
            width: 50px; height: 50px;
            border-radius: 50%;
            background-color: white;
            color: var(--primary-red);
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.2);
            font-family: 'Outfit', sans-serif;
        }

        /* Attraction Cards */
        .attraction-card {
            background: white;
            border-radius: 1.25rem;
            border: 1px solid rgba(220, 53, 69, 0.08);
            overflow: hidden;
            transition: all 0.35s ease;
            height: 100%;
        }
        .attraction-card .accent-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--primary-red), var(--primary-rose));
        }
        .attraction-icon {
            width: 52px;
            height: 52px;
            border-radius: 0.875rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: white;
            flex-shrink: 0;
        }
        .attraction-icon-red { background: linear-gradient(135deg, #dc3545, #e83e8c); }
        .attraction-icon-rose { background: linear-gradient(135deg, #e83e8c, #fd7e14); }
        .attraction-icon-dark { background: linear-gradient(135deg, #495057, #212529); }
        .attraction-icon-green { background: linear-gradient(135deg, #20c997, #198754); }

        .hero-lead {
            font-size: 1.1rem;
        }

        /* Section headings */
        .section-title {
            font-size: clamp(1.5rem, 4.5vw, 2.5rem);
            line-height: 1.25;
        }
        .section-subtitle {
            font-size: clamp(0.9rem, 2.5vw, 1.1rem);
        }

        /* Blood group cards */
        .blood-group-card {
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .blood-group-badge {
            width: 60px;
            height: 60px;
        }
        .impact-stat {
            font-size: clamp(1.25rem, 4vw, 2rem);
        }
        .impact-stat-label {
            font-size: clamp(0.65rem, 2vw, 0.875rem);
            line-height: 1.35;
        }

        /* Stats dividers on mobile */
        .stats-item + .stats-item {
            border-top: 1px solid rgba(0,0,0,0.08);
            padding-top: 1.25rem;
        }

        .cta-btn {
            transition: transform 0.3s ease;
        }

        /* Touch-friendly: only hover effects on devices that support hover */
        @media (hover: hover) {
            .blood-group-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(220, 53, 69, 0.15);
            }
            .cta-btn:hover {
                transform: translateY(-3px);
            }
            .glass-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 1rem 3rem rgba(220, 53, 69, 0.1) !important;
            }
            .attraction-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 1.25rem 2.5rem rgba(220, 53, 69, 0.12);
                border-color: rgba(220, 53, 69, 0.2);
            }
        }

        /* Tablet & below */
        @media (max-width: 991px) {
            .hero-section {
                padding-top: 140px;
                padding-bottom: 70px;
            }
            .hero-title {
                font-size: clamp(1.75rem, 6vw, 2.2rem);
            }
            .hero-lead {
                font-size: 1rem !important;
            }
            .glass-card {
                padding: 1.5rem !important;
            }
            .feature-card {
                padding: 1.75rem !important;
            }
            .section-block {
                padding-top: 2.5rem !important;
                padding-bottom: 2.5rem !important;
            }
            .how-it-works-section {
                margin-top: 0 !important;
                margin-bottom: 0 !important;
            }
        }

        /* Mobile */
        @media (max-width: 767px) {
            .blob-1, .blob-2 {
                width: 250px;
                height: 250px;
            }
            .hero-section {
                padding-top: 105px;
                padding-bottom: 40px;
            }
            .section-block {
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }
            .section-heading-wrap {
                margin-bottom: 1.25rem !important;
            }
            .glass-card {
                padding: 1.15rem !important;
            }
            .hero-badge {
                font-size: 0.8rem;
                padding: 0.5rem 0.85rem !important;
                white-space: normal;
                line-height: 1.4;
                max-width: 100%;
            }
            .stats-text {
                font-size: 2rem !important;
            }
            .stats-item + .stats-item {
                margin-top: 0.5rem;
            }
            .attraction-card .p-4 {
                padding: 1.15rem !important;
            }
            .attraction-icon {
                width: 44px;
                height: 44px;
                font-size: 1.15rem;
            }
            .highlight-banner {
                padding: 1.25rem !important;
            }
            .highlight-stat-box {
                padding: 0.65rem 0.35rem !important;
            }
            .blood-group-badge {
                width: 48px;
                height: 48px;
            }
            .blood-group-badge span {
                font-size: 1.1rem !important;
            }
            .blood-group-count {
                font-size: 1.5rem !important;
            }
            .icon-box {
                width: 55px;
                height: 55px;
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }
            .step-block {
                padding: 1rem !important;
            }
            .step-circle {
                width: 44px;
                height: 44px;
                font-size: 1.25rem;
            }
            .urgent-card {
                width: 280px;
                padding: 1.25rem !important;
            }
            .hero-avatar {
                width: 70px;
                height: 70px;
                font-size: 1.75rem;
            }
            .mobile-fab {
                display: flex;
                align-items: center;
                gap: 8px;
            }
           
        }

        /* Small mobile */
        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.65rem;
                letter-spacing: 0;
                padding-top: 30px;
            }
            .hero-lead {
                font-size: 0.95rem !important;
                line-height: 1.65 !important;
            }
            .btn-lg {
                padding: 0.75rem 1.25rem;
                font-size: 0.95rem;
                width: 100%;
            }
            .stats-text {
                font-size: 1.75rem !important;
            }
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .section-heading-wrap {
                margin-bottom: 2rem !important;
            }
            .feature-card h3 {
                font-size: 1.15rem;
            }
            footer p {
                font-size: 0.85rem;
                padding: 0 0.5rem;
            }
        }

        /* Stats border on desktop */
        @media (min-width: 768px) {
            .stats-item + .stats-item {
                border-top: none;
                padding-top: 0;
            }
            .border-end-md {
                border-right: 1px solid rgba(0,0,0,0.1);
            }
        }

        /* Marquee / Scroll logic */
        .scrolling-wrapper {
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 15px;
            scroll-behavior: smooth;
        }
        .scrolling-wrapper::-webkit-scrollbar {
            height: 6px;
        }
        .scrolling-wrapper::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
            border-radius: 10px;
        }
        .scrolling-wrapper::-webkit-scrollbar-thumb {
            background: rgba(220, 53, 69, 0.3);
            border-radius: 10px;
        }
        .urgent-card {
            display: inline-block;
            width: 320px;
            white-space: normal;
            vertical-align: top;
            margin-right: 1rem;
            transition: transform 0.3s ease;
        }
        
        /* Hero avatars */
        .hero-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-red), var(--primary-rose));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin: 0 auto 1.25rem;
            border: 5px solid white;
            box-shadow: 0 8px 20px rgba(220,53,69,0.25);
        }

        /* Custom Accordion */
        .accordion-custom .accordion-item {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
            border-radius: 1.25rem !important;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.03);
        }
        .accordion-custom .accordion-button {
            background: transparent;
            font-weight: 700;
            color: #2b2b2b;
            box-shadow: none;
            padding: 1.25rem 1.5rem;
            font-size: 1.1rem;
        }
        .accordion-custom .accordion-button:not(.collapsed) {
            color: var(--primary-red);
            background: linear-gradient(90deg, rgba(220, 53, 69, 0.05), transparent);
        }
        .accordion-custom .accordion-button:focus {
            box-shadow: none;
        }
        .accordion-custom .accordion-body {
            color: #555;
            line-height: 1.7;
            padding: 0 1.5rem 1.25rem;
            font-size: 1rem;
        }

        @media (prefers-reduced-motion: reduce) {
            .animate-float,
            .blob {
                animation: none;
            }
            .glass-card,
            .attraction-card,
            .blood-group-card,
            .cta-btn,
            .btn-gradient,
            .btn-outline-custom {
                transition: none;
            }
        }

        /* Small Mobile Viewport Layout Overrides (< 400px) */
        @media (max-width: 399.98px) {
            .container {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }
            .glass-card, .feature-card {
                padding: 1rem !important;
                border-radius: 0.75rem !important;
            }
            .hero-title {
                font-size: 1.5rem !important;
                padding-top: 20px !important;
            }
            .hero-section {
                padding-top: 90px !important;
                padding-bottom: 25px !important;
            }
        }
    </style>
    <style>
    .site-footer {
        position: relative;
        z-index: 1;
        background: linear-gradient(180deg, #1a1d21 0%, #212529 100%);
        color: rgba(255, 255, 255, 0.75);
    }
    .site-footer__top {
        border-top: 3px solid transparent;
        border-image: linear-gradient(90deg, var(--primary-red), var(--primary-rose)) 1;
    }
    .site-footer__heading {
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        letter-spacing: 0.02em;
    }
    .site-footer__text {
        color: rgba(255, 255, 255, 0.65);
        font-size: 0.9rem;
        line-height: 1.7;
        max-width: 320px;
    }
    .site-footer__links li + li {
        margin-top: 0.55rem;
    }
    .site-footer__links a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.2s ease, padding-left 0.2s ease;
    }
    .site-footer__links a:hover {
        color: #fff;
        padding-left: 4px;
    }
    .site-footer__bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(0, 0, 0, 0.15);
    }
    .site-footer__copy,
    .site-footer__credit {
        font-size: 0.82rem;
        color: rgba(255, 255, 255, 0.55);
    }
    .site-footer__dev-link {
        color: #ffadb5;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .site-footer__dev-link:hover {
        color: #fff;
    }
    @media (max-width: 576px) {
        .site-footer__top .container {
            padding-top: 2.5rem !important;
            padding-bottom: 2rem !important;
        }
        .site-footer__text {
            max-width: 100%;
        }
    }
</style>
    <style>
    .lang-switcher__btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        border: 1px solid rgba(0, 0, 0, 0.1);
        background: #fff;
        color: #333;
        border-radius: 50rem;
        padding: 0.35rem 0.75rem;
        font-size: 0.82rem;
        font-weight: 600;
        line-height: 1.2;
    }
    .lang-switcher__btn::after {
        margin-left: 0.15rem;
        font-size: 0.65rem;
    }
    .lang-switcher__label {
        max-width: 5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .lang-switcher__menu {
        min-width: 150px;
    }
    .user-topbar .lang-switcher__btn {
        background: var(--rk-bg, #f4f6f9);
        border-color: rgba(0, 0, 0, 0.08);
    }
    @media (max-width: 576px) {
        .lang-switcher__label { display: none; }
        .lang-switcher__btn { padding: 0.4rem 0.55rem; }
    }
</style>

    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CRRQEQW7SW"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'G-CRRQEQW7SW');
</script>



</head>
<body>

    <!-- Background Elements -->
    <div class="background-wrapper">
        <div class="bg-grid-pattern"></div>
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <style>
    .brand-slogan {
        font-size: 0.55rem;
        letter-spacing: 0.1px;
    }
    @media (min-width: 576px) {
        .brand-slogan {
            font-size: 0.65rem!important;
            letter-spacing: 0.2px;
        }
    }

    /* Centralized Collapsed Navbar Container Styling (Tablet & Mobile) */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: rgba(255, 255, 255, 0.96) !important;
            backdrop-filter: blur(15px) !important;
            -webkit-backdrop-filter: blur(15px) !important;
            border-radius: 1rem !important;
            padding: 1.25rem !important;
            margin-top: 1rem !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.7) !important;
        }
        .navbar-brand span:first-of-type {
            font-size: 1.25rem !important;
        }
    }

    /* Small Mobile Viewport Optimizations (< 400px) */
    @media (max-width: 399.98px) {
        .navbar-brand {
            max-width: 70%;
            gap: 0.35rem !important;
        }
        /* Scale down brand icon wrapper */
        .navbar-brand div.bg-gradient-primary {
            width: 30px !important;
            height: 30px !important;
            padding: 0.4rem !important;
        }
        .navbar-brand div.bg-gradient-primary i {
            font-size: 0.9rem !important;
        }
        /* Scale down brand name text */
        .navbar-brand span:first-of-type {
            font-size: 1.05rem !important;
            line-height: 1.0 !important;
        }
        /* Scale down brand slogan */
        .brand-slogan {
            font-size: 0.48rem !important;
            letter-spacing: 0px !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }
        /* Reduce navbar container padding */
        .navbar > .container {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
    }
</style>
<nav class="navbar navbar-expand-lg fixed-top glass-nav py-2 py-lg-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 fs-lg-3 d-flex align-items-center gap-2 brand-font" href="#">
            <div class="bg-gradient-primary text-white rounded p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px;">
                <i class="bi bi-globe fs-5"></i>
            </div>
            <div class="d-flex flex-column justify-content-center">
                <span class="text-dark" style="line-height: 1.1;">আইএসপি নেটওয়ার্ক</span>
                <span class="text-muted fw-semibold brand-slogan">Fast, Reliable & Secure Internet.</span>
            </div>
        </a>
        
        <button class="navbar-toggler border-0 p-1 shadow-none bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-2 text-danger"></i>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-2 gap-lg-3 mt-3 mt-lg-0 text-center">

                <li class="nav-item">
                    <a class="nav-link px-3 py-2 fw-medium rounded-3 transition-all hover-bg-light text-nowrap text-secondary" href="#">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 py-2 fw-medium rounded-3 transition-all hover-bg-light text-nowrap text-secondary" href="#packages">Packages</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 py-2 fw-medium rounded-3 transition-all hover-bg-light text-nowrap text-secondary" href="#coverage">Coverage</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 py-2 fw-medium rounded-3 transition-all hover-bg-light text-nowrap text-secondary" href="#about-us">About Us</a>
                </li>
                
                <li class="nav-item w-100 w-lg-auto">
                    <div class="lang-switcher dropdown">
                        <button class="lang-switcher__btn dropdown-toggle"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                aria-label="Language">
                            <i class="bi bi-translate"></i>
                            <span class="lang-switcher__label">English</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 lang-switcher__menu">
                            <li>
                                <a href="?locale=bn" class="dropdown-item d-flex align-items-center justify-content-between">
                                    <span>বাংলা</span>
                                </a>
                            </li>
                            <li>
                                <a href="?locale=en" class="dropdown-item d-flex align-items-center justify-content-between active fw-semibold">
                                    <span>English</span>
                                    <i class="bi bi-check2 text-danger"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item w-100 w-lg-auto">
                    <a href="/dashboard" class="btn btn-gradient text-nowrap rounded-pill px-4 py-2 fw-semibold shadow-sm w-100 w-lg-auto">
                        <i class="bi bi-speedometer2 me-1"></i> Demo Request
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>

   <!-- Hero Section -->
    <section class="hero-section text-center position-relative overflow-hidden">

        <div class="container">

            
            <!-- Heading -->

            <h1 class="hero-title fw-bold mb-4">

                Simplify Your

                <span class="text-gradient">
                    ISP Business
                </span>

                <br>

                with One Powerful Platform

            </h1>

            <!-- Description -->

            <p class="hero-lead text-secondary mx-auto mb-5 fw-medium"
                style="max-width:780px;line-height:1.8;">

                Manage customers, automate billing, monitor MikroTik & OLT devices,
                accept online payments, generate real-time reports,
                and grow your Internet Service Provider business effortlessly.

            </p>

            <!-- Buttons -->

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">

                <a href="/register"
                    class="btn btn-primary btn-lg rounded-pill px-5 fw-semibold shadow">

                    <i class="bi bi-rocket-takeoff-fill me-2"></i>

                    Get Started Free

                </a>

                <a href="/demo"
                    class="btn btn-outline-dark btn-lg rounded-pill px-5 fw-semibold">

                    <i class="bi bi-play-circle me-2"></i>

                    Live Demo

                </a>

            </div>

            <!-- Features -->

            <div class="d-flex flex-wrap justify-content-center gap-4 mt-5">

                <span class="text-secondary fw-medium">

                    <i class="bi bi-check-circle-fill text-success me-2"></i>

                    Automated Billing

                </span>

                <span class="text-secondary fw-medium">

                    <i class="bi bi-check-circle-fill text-success me-2"></i>

                    MikroTik Integration

                </span>

                <span class="text-secondary fw-medium">

                    <i class="bi bi-check-circle-fill text-success me-2"></i>

                    GPON / EPON OLT

                </span>

                <span class="text-secondary fw-medium">

                    <i class="bi bi-check-circle-fill text-success me-2"></i>

                    Online Payments

                </span>

            </div>

        </div>

    </section>

  


    <!-- Key Attractions Section -->
    <section class="py-3 py-md-5 section-block position-relative z-1 px-3">
        <div class="container">
            <div class="text-center mb-5 section-heading-wrap">
               

                <h2 class="fw-bold section-title text-dark">
                    Why Choose Our ISP Billing Platform?
                </h2>

                <div class="mx-auto bg-gradient-primary rounded-pill mt-3"
                    style="width:80px;height:5px;"></div>

                <p class="text-secondary mt-3 section-subtitle mx-auto px-2"
                    style="max-width:620px;">

                    Everything you need to manage customers, automate billing,
                    monitor your network, and grow your ISP business from one platform.

                </p>
            </div>

            <div class="row g-3 g-md-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="attraction-card shadow-sm fade-up">
                        <div class="accent-bar"></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="attraction-icon attraction-icon-red">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div>
                                   <h3 class="h6 fw-bold mb-2">
                                        Customer Management
                                    </h3>
                                   <p class="text-secondary small mb-0" style="line-height:1.65;">

                                        Manage customer profiles, internet packages,
                                        POP branches, billing cycles, and connection status
                                        from one centralized dashboard.

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="attraction-card shadow-sm">
                        <div class="accent-bar"></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="attraction-icon attraction-icon-rose">
                                    <i class="bi bi-receipt-cutoff"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold mb-2">
                                        Automated Billing
                                    </h3>

                                    <p class="text-secondary small mb-0" style="line-height:1.65;">

                                        Generate invoices automatically, manage due payments,
                                        recharge history, SMS reminders, and online payment
                                        collection with ease.

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="attraction-card shadow-sm">
                        <div class="accent-bar"></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="attraction-icon attraction-icon-dark">
                                    <i class="bi bi-router-fill"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold mb-2">
                                        MikroTik & OLT Integration
                                    </h3>

                                    <p class="text-secondary small mb-0" style="line-height:1.65;">

                                        Monitor MikroTik routers, manage PPPoE users,
                                        track ONU status, and control GPON/EPON devices
                                        from a single platform.

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               <div class="col-12 col-sm-6 col-lg-3">
                    <div class="attraction-card shadow-sm">
                        <div class="accent-bar"></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="attraction-icon attraction-icon-green">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold mb-2">
                                        Reports & Analytics
                                    </h3>

                                    <p class="text-secondary small mb-0" style="line-height:1.65;">

                                        Access real-time financial reports, customer insights,
                                        payment history, and business analytics to make
                                        smarter decisions.

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="attraction-card shadow-sm">
                        <div class="accent-bar"></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="attraction-icon attraction-icon-red">
                                    <i class="bi bi-chat-dots-fill"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold mb-2">
                                        SMS Gateway
                                    </h3>

                                    <p class="text-secondary small mb-0" style="line-height:1.65;">
                                        Send automated SMS notifications for invoices, payments, due reminders, and service updates.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="attraction-card shadow-sm">
                        <div class="accent-bar"></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="attraction-icon attraction-icon-rose">
                                    <i class="bi bi-headset"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold mb-2">
                                        CRM & Ticketing
                                    </h3>

                                    <p class="text-secondary small mb-0" style="line-height:1.65;">
                                        Manage customer support tickets, complaints, follow-ups, and CRM activities efficiently.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="attraction-card shadow-sm">
                        <div class="accent-bar"></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="attraction-icon attraction-icon-dark">
                                    <i class="bi bi-box-seam-fill"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold mb-2">
                                        Inventory Management
                                    </h3>

                                    <p class="text-secondary small mb-0" style="line-height:1.65;">
                                        Track routers, ONUs, accessories, stock levels, suppliers, purchases, and inventory movements.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="attraction-card shadow-sm">
                        <div class="accent-bar"></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="attraction-icon attraction-icon-green">
                                    <i class="bi bi-credit-card-2-front-fill"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold mb-2">
                                        Online Payments
                                    </h3>

                                    <p class="text-secondary small mb-0" style="line-height:1.65;">
                                        Integrate SSLCommerz, bKash, Nagad, Rocket, and other gateways for seamless online payments.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Highlight Banner -->
            <div class="glass-card highlight-banner mt-4 mt-md-5 p-4 p-md-5 shadow-sm">
                <div class="row align-items-center g-4">

                    <div class="col-lg-7">

                        <h3 class="fw-bold h4 mb-3">
                            Everything You Need to Grow Your ISP Business
                        </h3>

                        <p class="text-secondary mb-0 section-subtitle" style="line-height: 1.75;">

                            Simplify customer management, automate billing, monitor MikroTik & OLT
                            devices, collect payments online, and access powerful reports—all from
                            one modern platform designed for Internet Service Providers.

                        </p>

                    </div>

                    <div class="col-lg-5">

                        <div class="row g-2 g-md-3 text-center">

                            <div class="col-4">

                                <div class="bg-white rounded-4 highlight-stat-box p-3 shadow-sm h-100">

                                    <div class="impact-stat fw-bold text-gradient brand-font">
                                        99.9%
                                    </div>

                                    <p class="impact-stat-label text-secondary mb-0 fw-medium">

                                        System<br>Uptime

                                    </p>

                                </div>

                            </div>

                            <div class="col-4">

                                <div class="bg-white rounded-4 highlight-stat-box p-3 shadow-sm h-100">

                                    <div class="impact-stat fw-bold text-gradient brand-font">
                                        24/7
                                    </div>

                                    <p class="impact-stat-label text-secondary mb-0 fw-medium">

                                        Technical<br>Support

                                    </p>

                                </div>

                            </div>

                            <div class="col-4">

                                <div class="bg-white rounded-4 highlight-stat-box p-3 shadow-sm h-100">

                                    <div class="impact-stat fw-bold text-gradient brand-font">
                                        10K+
                                    </div>

                                    <p class="impact-stat-label text-secondary mb-0 fw-medium">

                                        Managed<br>Customers

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Pricing Section ------->
    <section id="packages" class="pricing-section py-5">
        <div class="container">

            <!-- Section Heading -->
            <div class="text-center mb-4">
                
                <h2 class="fw-bold h1 text-dark mb-2">
                    Choose Your Internet Plan
                </h2>
                <div class="mx-auto rounded-pill bg-primary mb-3" style="width:60px; height:4px;"></div>
                <p class="text-muted mx-auto mb-0" style="max-width:550px; font-size: 15px;">
                    High-speed internet packages for home and business users. Choose the plan that best fits your needs.
                </p>
            </div>

            <div class="row g-3 justify-content-center align-items-center">

                <!-- ================= BASIC ================= -->
                <div class="col-xl-3 col-md-6">
                    <div class="pricing-card">
                        <div class="pricing-header basic">
                            <h5>BASIC</h5>
                        </div>
                        <div class="pricing-body">
                            <div class="price">
                                <span class="currency">৳</span>
                                <span class="amount">800</span>
                                <span class="duration">/mo</span>
                            </div>
                            <ul class="pricing-features">
                                <li><i class="bi bi-check-circle-fill"></i> 20 Mbps Unlimited</li>
                                <li><i class="bi bi-check-circle-fill"></i> Shared IP</li>
                                <li><i class="bi bi-check-circle-fill"></i> 24/7 Support</li>
                                <li><i class="bi bi-check-circle-fill"></i> Free Installation</li>
                            </ul>
                            <div class="pricing-buttons">
                                <a href="#" class="btn btn-outline-primary rounded-pill w-100">View Features</a>
                                <a href="#" class="btn btn-primary rounded-pill w-100">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= STANDARD ================= -->
                <div class="col-xl-3 col-md-6">
                    <div class="pricing-card">
                        <div class="pricing-header standard">
                            <h5>STANDARD</h5>
                        </div>
                        <div class="pricing-body">
                            <div class="price">
                                <span class="currency">৳</span>
                                <span class="amount">1200</span>
                                <span class="duration">/mo</span>
                            </div>
                            <ul class="pricing-features">
                                <li><i class="bi bi-check-circle-fill"></i> 40 Mbps Unlimited</li>
                                <li><i class="bi bi-check-circle-fill"></i> Gaming Optimized</li>
                                <li><i class="bi bi-check-circle-fill"></i> IPv6 Ready</li>
                                <li><i class="bi bi-check-circle-fill"></i> Priority Support</li>
                            </ul>
                            <div class="pricing-buttons">
                                <a href="#" class="btn btn-outline-primary rounded-pill w-100">View Features</a>
                                <a href="#" class="btn btn-primary rounded-pill w-100">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= PROFESSIONAL (POPULAR) ================= -->
                <div class="col-xl-3 col-md-6">
                    <div class="pricing-card featured">
                        <div class="popular-badge">Popular</div>
                        <div class="pricing-header premium">
                            <h5>PROFESSIONAL</h5>
                        </div>
                        <div class="pricing-body">
                            <div class="price">
                                <span class="currency">৳</span>
                                <span class="amount">1800</span>
                                <span class="duration">/mo</span>
                            </div>
                            <ul class="pricing-features">
                                <li><i class="bi bi-check-circle-fill"></i> 60 Mbps Unlimited</li>
                                <li><i class="bi bi-check-circle-fill"></i> Gaming + Streaming</li>
                                <li><i class="bi bi-check-circle-fill"></i> Public IP</li>
                                <li><i class="bi bi-check-circle-fill"></i> VIP Support</li>
                            </ul>
                            <div class="pricing-buttons">
                                <a href="#" class="btn btn-outline-primary rounded-pill w-100">View Features</a>
                                <a href="#" class="btn btn-primary rounded-pill w-100">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= ENTERPRISE ================= -->
                <div class="col-xl-3 col-md-6">
                    <div class="pricing-card">
                        <div class="pricing-header enterprise">
                            <h5>ENTERPRISE</h5>
                        </div>
                        <div class="pricing-body">
                            <div class="price">
                                <span class="currency">৳</span>
                                <span class="amount">2500</span>
                                <span class="duration">/mo</span>
                            </div>
                            <ul class="pricing-features">
                                <li><i class="bi bi-check-circle-fill"></i> 100 Mbps Unlimited</li>
                                <li><i class="bi bi-check-circle-fill"></i> Dedicated Bandwidth</li>
                                <li><i class="bi bi-check-circle-fill"></i> Static Public IP</li>
                                <li><i class="bi bi-check-circle-fill"></i> SLA Support</li>
                            </ul>
                            <div class="pricing-buttons">
                                <a href="#" class="btn btn-outline-primary rounded-pill w-100">View Features</a>
                                <a href="#" class="btn btn-primary rounded-pill w-100">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

<style>
/*=========================================
        Pricing Section Clean & Compact
=========================================*/
.pricing-section {
    background: #f8fafc;
}

.pricing-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    position: relative;
}

.pricing-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
}

/* Header */
.pricing-header {
    padding: 22px 20px;
    text-align: center;
    color: #fff;
}

.pricing-header h5 {
    font-size: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin: 0;
}

/* Gradients */
.basic { background: linear-gradient(135deg, #0284c7, #0ea5e9); }
.standard { background: linear-gradient(135deg, #6366f1, #818cf8); }
.premium { background: linear-gradient(135deg, #f97316, #fb923c); }
.enterprise { background: linear-gradient(135deg, #1e293b, #334155); }

/* Body */
.pricing-body {
    padding: 14px 20px;
}

/* Price */
.price {
    display: flex;
    align-items: baseline;
    justify-content: center;
    margin-bottom: 20px;
}

.currency {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin-right: 2px;
}

.amount {
    font-size: 30px;
    line-height: 1;
    color: #0f172a;
}

.duration {
    color: #64748b;
    font-size: 14px;
    margin-left: 4px;
}

/* Features */
.pricing-features {
    list-style: none;
    padding: 0;
    margin: 0 0 24px 0;
    line-height: normal;
}

.pricing-features li {
    padding: 8px 0;
    font-size: 14px;
    color: #475569;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #f1f5f9;
}

.pricing-features li:last-child {
    border-bottom: none;
}

.pricing-features i {
    color: #10b981;
    font-size: 14px;
    margin-right: 8px;
}

/* Buttons Component */
.pricing-buttons {
    display: flex;
    gap: 3px; 
}

.pricing-card .btn {
    padding: 10px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.pricing-card .btn-primary {
    background: #0ea5e9;
    border: 1px solid #0ea5e9;
    color: #fff;
}

.pricing-card .btn-primary:hover {
    background: #0284c7;
    border-color: #0284c7;
}

.pricing-card .btn-outline-primary {
    color: #0ea5e9;
    border-color: #0ea5e9;
}

.pricing-card .btn-outline-primary:hover {
    background: #0ea5e9;
    color: #fff;
}

/* Featured / Popular Card Styling */
.featured {
    border: 2px solid #f97316;
}

.featured .btn-outline-primary {
    color: #f97316;
    border-color: #f97316;
}
.featured .btn-outline-primary:hover {
    background: #f97316;
    color: #fff;
}
.featured .btn-primary {
    background: #f97316;
    border-color: #f97316;
}
.featured .btn-primary:hover {
    background: #ea580c;
    border-color: #ea580c;
}

/* Popular Badge */
.popular-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    padding: 4px 12px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    border-radius: 20px;
    letter-spacing: 0.5px;
    backdrop-filter: blur(4px);
    z-index: 5;
}

/* Responsive Grid adjustment */
@media (min-width: 1200px) {
    .row {
        --bs-gutter-x: 1rem; 
    }
}
</style>
    <!---------- Modern Feature Cards CSS------------>
    <section class="py-5 section-block position-relative z-1 px-3 pricing-section">
        <div class="container">

            <div class="text-center mb-5 section-heading-wrap">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-2">Features Platform</span>
                <h2 class="fw-bold section-title text-dark h1">
                    What Makes Our ISP Billing Platform Different?
                </h2>
                <div class="mx-auto rounded-pill bg-primary mt-2" style="width:60px; height:4px;"></div>
                <p class="text-muted mt-3 section-subtitle mx-auto" style="max-width:600px; font-size: 15px;">
                    Powerful automation, seamless network integration, and intelligent management tools—everything your ISP needs to operate efficiently.
                </p>
            </div>

            <div class="row g-4">

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="glass-card feature-card p-4 h-100 shadow-sm">
                        <div class="icon-box icon-blue">
                            <i class="bi bi-router-fill"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-2 text-dark">
                            MikroTik & OLT Integration
                        </h3>
                        <p class="text-secondary mb-0" style="line-height:1.6; font-size: 14px;">
                            Connect MikroTik routers, GPON/EPON OLT devices, monitor ONU status, and manage network equipment from one centralized platform.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="glass-card feature-card p-4 h-100 shadow-sm">
                        <div class="icon-box icon-indigo">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-2 text-dark">
                            Smart Billing Automation
                        </h3>
                        <p class="text-secondary mb-0" style="line-height:1.6; font-size: 14px;">
                            Automatically generate invoices, manage billing cycles, collect payments, and send SMS notifications without manual intervention.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="glass-card feature-card p-4 h-100 shadow-sm">
                        <div class="icon-box icon-green">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-2 text-dark">
                            Secure & Reliable Platform
                        </h3>
                        <p class="text-secondary mb-0" style="line-height:1.6; font-size: 14px;">
                            Built with enterprise-grade security, role-based access, encrypted authentication, and reliable cloud infrastructure to keep your ISP running smoothly.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="glass-card feature-card p-4 h-100 shadow-sm">
                        <div class="icon-box icon-purple">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-2 text-dark">
                            Multi-POP & Multi-Branch
                        </h3>
                        <p class="text-secondary mb-0" style="line-height:1.6; font-size: 14px;">
                            Easily manage multiple POPs, branches, and service areas from a single dashboard with centralized control and user management.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="glass-card feature-card p-4 h-100 shadow-sm">
                        <div class="icon-box icon-orange">
                            <i class="bi bi-credit-card-2-front-fill"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-2 text-dark">
                            Online Payment Integration
                        </h3>
                        <p class="text-secondary mb-0" style="line-height:1.6; font-size: 14px;">
                            Accept payments through SSLCommerz, bKash, Nagad, Rocket, cards, and other payment gateways with automatic invoice updates.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="glass-card feature-card p-4 h-100 shadow-sm">
                        <div class="icon-box icon-teal">
                            <i class="bi bi-bar-chart-line-fill"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-2 text-dark">
                            Reports & Analytics
                        </h3>
                        <p class="text-secondary mb-0" style="line-height:1.6; font-size: 14px;">
                            Monitor revenue, customer growth, collections, network performance, and business insights with real-time reports and interactive dashboards.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
    /*---------- Modern Feature Cards CSS------------*/
    .glass-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .feature-card:hover {
        transform: translateY(-6px);
        border-color: #0ea5e9;
        box-shadow: 0 12px 25px rgba(14, 165, 233, 0.08) !important;
    }

    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .feature-card:hover .icon-box {
        transform: scale(1.08) rotate(3deg);
    }
    .icon-blue { background: #e0f2fe; color: #0284c7; }
    .icon-indigo { background: #e0e7ff; color: #4f46e5; }
    .icon-green { background: #dcfce7; color: #16a34a; }
    .icon-purple { background: #f3e8ff; color: #9333ea; }
    .icon-orange { background: #ffedd5; color: #ea580c; }
    .icon-teal { background: #ccfbf1; color: #0d9488; }

    /* কার্ডের ভেতরের টাইটেল */
    .feature-card h3 {
        letter-spacing: -0.3px;
    }
    </style>

   <!-- --------- How It Works---------- -->
    <section class="py-5 section-block how-it-works-section position-relative overflow-hidden">

        <div class="container">

            <!-- Heading -->
            <div class="text-center mb-5 section-heading-wrap">

            

                <h2 class="fw-bold section-title">
                    Get Started in 3 Simple Steps
                </h2>

                <div class="mx-auto bg-gradient-primary rounded-pill mt-3"
                    style="width:80px;height:5px;"></div>

                <p class="text-secondary mt-4 section-subtitle mx-auto"
                    style="max-width:700px;">

                    Launch your ISP business within minutes.
                    Configure everything from customers to network devices
                    and start managing your business effortlessly.

                </p>

            </div>

            <div class="position-relative">

                <!-- Connection Line -->
                <div class="step-connector d-none d-lg-block"></div>

                <div class="row text-center g-4">

                    <!-- Step 1 -->

                    <div class="col-lg-4">

                        <div class="step-block h-100">

                            <div class="step-circle">

                                <i class="bi bi-person-plus-fill"></i>

                            </div>

                            <span class="badge bg-primary-subtle text-primary rounded-pill mb-3">

                                STEP 01

                            </span>

                            <h4 class="fw-bold mb-3">

                                Create Your Account

                            </h4>

                            <p class="text-secondary mb-0">

                                Register your ISP company,
                                configure your profile,
                                branches,
                                internet packages,
                                and billing settings.

                            </p>

                        </div>

                    </div>

                    <!-- Step 2 -->

                    <div class="col-lg-4">

                        <div class="step-block h-100">

                            <div class="step-circle">

                                <i class="bi bi-router-fill"></i>

                            </div>

                            <span class="badge bg-primary-subtle text-primary rounded-pill mb-3">

                                STEP 02

                            </span>

                            <h4 class="fw-bold mb-3">

                                Connect Your Network

                            </h4>

                            <p class="text-secondary mb-0">

                                Integrate MikroTik,
                                GPON / EPON OLT,
                                Payment Gateway,
                                SMS Gateway
                                and automate your workflow.

                            </p>

                        </div>

                    </div>

                    <!-- Step 3 -->

                    <div class="col-lg-4">

                        <div class="step-block h-100">

                            <div class="step-circle">

                                <i class="bi bi-graph-up-arrow"></i>

                            </div>

                            <span class="badge bg-primary-subtle text-primary rounded-pill mb-3">

                                STEP 03

                            </span>

                            <h4 class="fw-bold mb-3">

                                Manage & Grow

                            </h4>

                            <p class="text-secondary mb-0">

                                Automate billing,
                                monitor customers,
                                generate reports,
                                and grow your ISP
                                with one powerful dashboard.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <style>
        /*----------How It Works---------*/

        .how-it-works-section{

            background:#fff;

        }

        .step-block{

            position:relative;

            z-index:2;

            padding:40px 25px;

            transition:.35s;

            border-radius:20px;

        }

        .step-block:hover{

            transform:translateY(-10px);

        }

        .step-circle{

            width:90px;

            height:90px;

            margin:auto;

            margin-bottom:25px;

            border-radius:50%;

            display:flex;

            justify-content:center;

            align-items:center;

            background:linear-gradient(135deg,#0d6efd,#4f8cff);

            color:#fff;

            font-size:34px;

            box-shadow:0 20px 40px rgba(13,110,253,.20);

            transition:.35s;

        }

        .step-block:hover .step-circle{

            transform:scale(1.08);

            box-shadow:0 30px 60px rgba(13,110,253,.35);

        }

        .step-circle i{

            font-size:34px;

        }

        .step-connector{

            position:absolute;

            top:45px;

            left:17%;

            width:66%;

            height:3px;

            background:linear-gradient(
                to right,
                #0d6efd,
                #74a9ff,
                #0d6efd
            );

            z-index:1;

        }

        .step-connector::before,

        .step-connector::after{

            content:"";

            position:absolute;

            top:-5px;

            width:12px;

            height:12px;

            border-radius:50%;

            background:#0d6efd;

            box-shadow:0 0 15px rgba(13,110,253,.45);

        }

        .step-connector::before{

            left:33%;

        }

        .step-connector::after{

            left:66%;

        }

        @media(max-width:991px){

        .step-block{

        padding:20px;

        }

        .step-circle{

        width:75px;

        height:75px;

        font-size:28px;

        }

        }
    </style>
    <!-- About Us Section -->
<section id="about" class="py-5 section-block position-relative z-1 px-3 bg-white">
    <div class="container">
        <div class="row g-4 align-items-center">
            
            <!-- Left Side: Interactive Stats & Visual Grid -->
            <div class="col-12 col-lg-6">
                <div class="position-relative pe-lg-4">
                    <!-- Stat Card 1 -->
                    <div class="about-stat-card glass-card p-4 shadow-sm mb-3 d-flex align-items-center gap-3">
                        <div class="about-icon bg-primary-subtle text-primary">
                            <i class="bi bi-rocket-takeoff-fill"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold text-dark mb-0">99.9%</h3>
                            <p class="text-muted mb-0 font-14">Automation Efficiency</p>
                        </div>
                    </div>

                    <!-- Stat Card 2 -->
                    <div class="about-stat-card glass-card p-4 shadow-sm mb-3 ms-md-4 d-flex align-items-center gap-3 border-primary-light">
                        <div class="about-icon bg-success-subtle text-success">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold text-dark mb-0">500+</h3>
                            <p class="text-muted mb-0 font-14">Active ISPs Trusted Us</p>
                        </div>
                    </div>

                    <!-- Stat Card 3 -->
                    <div class="about-stat-card glass-card p-4 shadow-sm d-flex align-items-center gap-3">
                        <div class="about-icon bg-warning-subtle text-warning">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold text-dark mb-0">Bank-Grade</h3>
                            <p class="text-muted mb-0 font-14">Data Security & Encryption</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Content -->
            <div class="col-12 col-lg-6">
                <div class="about-content">
                   
                    <h2 class="fw-bold text-dark h1 mb-3">
                        Empowering ISPs with Smart Automation
                    </h2>
                    <div class="rounded-pill bg-primary mb-3" style="width:60px; height:4px;"></div>
                    
                    <p class="text-secondary mb-3" style="line-height:1.7; font-size: 15px;">
                        We are dedicated to revolutionizing how Internet Service Providers manage their business. Our all-in-one billing and network management platform eliminates manual paperwork, reduces customer churn, and optimizes bandwidth control.
                    </p>
                    
                    <p class="text-secondary mb-4" style="line-height:1.7; font-size: 15px;">
                        Whether you are a local multi-pop ISP or a large enterprise branch, our software provides the exact tools you need to sync MikroTik routers, automate bills, and accept instant online payments.
                    </p>

                    <!-- Core Values Checklist -->
                    <div class="row g-2 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fw-boldfs-5"></i>
                                <span class="text-dark fw-semibold font-14">Real-time MikroTik Sync</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fw-bold fs-5"></i>
                                <span class="text-dark fw-semibold font-14">Automated Bkash/Nagad Payment</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fw-bold fs-5"></i>
                                <span class="text-dark fw-semibold font-14">Auto SMS Alerts</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-primary fw-bold fs-5"></i>
                                <span class="text-dark fw-semibold font-14">24/7 Dedicated Support</span>
                            </div>
                        </div>
                    </div>

                    <a href="#packages" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold btn-about">
                        Explore Our Plans <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
/*=========================================
        Modern About Us Section CSS
=========================================*/
.about-stat-card {
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    background: #ffffff;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    max-width: 400px;
}

/* মাউস হোভার করলে লাইভ ফিলিং আসবে */
.about-stat-card:hover {
    transform: translateX(6px);
    border-color: #0ea5e9;
    box-shadow: 0 10px 25px rgba(14, 165, 233, 0.06) !important;
}

.border-primary-light {
    border-left: 4px solid #0ea5e9 !important;
}

/* আইকন বক্স */
.about-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.font-14 {
    font-size: 14px;
}

/* বাটন অ্যানিমেশন */
.btn-about {
    background: #0ea5e9;
    border: 1px solid #0ea5e9;
    font-size: 14px;
    transition: all 0.3s ease;
}

.btn-about:hover {
    background: #0284c7;
    border-color: #0284c7;
    transform: translateY(-2px);
}

@media (max-width: 991px) {
    .about-stat-card {
        max-width: 100%;
    }
    .ms-md-4 {
        margin-left: 0 !important;
    }
}
</style>

    <!-- Trusted Clients Section -->
    <section class="py-3 py-md-5 section-block position-relative z-1 px-3 bg-light">
        <div class="container">

            <div class="text-center mb-4 mb-md-5 section-heading-wrap">

                <h2 class="fw-bold section-title text-dark">
                    Our Trusted ISP Partners
                </h2>

                <div class="mx-auto bg-gradient-primary rounded-pill mt-3"
                    style="width:80px;height:5px;"></div>

                <p class="text-secondary mt-3 section-subtitle mx-auto px-2"
                    style="max-width:620px;">

                    Internet Service Providers across Bangladesh trust our platform
                    to automate billing, manage customers, and grow their business.

                </p>

            </div>

            <div class="row g-4 justify-content-center">

                <!-- Client 1 -->
                <div class="col-12 col-sm-6 col-lg-3 fade-up">

                    <div class="glass-card text-center p-4 h-100 shadow-sm border-0">

                        <div class="hero-avatar shadow-sm">
                            A
                        </div>

                        <h5 class="fw-bold mb-1 text-dark fs-6">
                            Alpha Net
                        </h5>

                        <p class="text-muted small mb-0">

                            <i class="bi bi-patch-check-fill text-primary me-1"></i>

                            Trusted ISP Partner

                        </p>

                    </div>

                </div>

                <!-- Client 2 -->

                <div class="col-12 col-sm-6 col-lg-3 fade-up">

                    <div class="glass-card text-center p-4 h-100 shadow-sm border-0">

                        <div class="hero-avatar shadow-sm">
                            B
                        </div>

                        <h5 class="fw-bold mb-1 text-dark fs-6">

                            Broadband Plus

                        </h5>

                        <p class="text-muted small mb-0">

                            <i class="bi bi-patch-check-fill text-primary me-1"></i>

                            Trusted ISP Partner

                        </p>

                    </div>

                </div>

                <!-- Client 3 -->

                <div class="col-12 col-sm-6 col-lg-3 fade-up">

                    <div class="glass-card text-center p-4 h-100 shadow-sm border-0">

                        <div class="hero-avatar shadow-sm">
                            N
                        </div>

                        <h5 class="fw-bold mb-1 text-dark fs-6">

                            NetZone ISP

                        </h5>

                        <p class="text-muted small mb-0">

                            <i class="bi bi-patch-check-fill text-primary me-1"></i>

                            Trusted ISP Partner

                        </p>

                    </div>

                </div>

                <!-- Client 4 -->

                <div class="col-12 col-sm-6 col-lg-3 fade-up">

                    <div class="glass-card text-center p-4 h-100 shadow-sm border-0">

                        <div class="hero-avatar shadow-sm">
                            S
                        </div>

                        <h5 class="fw-bold mb-1 text-dark fs-6">

                            SkyLink Network

                        </h5>

                        <p class="text-muted small mb-0">

                            <i class="bi bi-patch-check-fill text-primary me-1"></i>

                            Trusted ISP Partner

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- Success Stories -->
    <section class="py-3 py-md-5 section-block position-relative z-1 px-3 bg-light">

        <div class="container">

            <div class="text-center mb-4 mb-md-5 section-heading-wrap">

                
                <h2 class="fw-bold section-title text-dark">
                    What Our Clients Say
                </h2>

                <div class="mx-auto bg-gradient-primary rounded-pill mt-3"
                    style="width:80px;height:5px;"></div>

                <p class="text-secondary mt-3 section-subtitle mx-auto"
                    style="max-width:650px;">

                    Trusted by Internet Service Providers for reliable billing,
                    customer management, and network automation.

                </p>

            </div>

            <div class="row g-4">

                <div class="col-lg-4">

                    <div class="glass-card p-4 h-100 shadow-sm">

                        <div class="mb-3 text-warning fs-5">

                            ★★★★★

                        </div>

                        <p class="text-secondary">

                            "Managing thousands of customers has become effortless.
                            Billing automation and MikroTik integration save us hours every month."

                        </p>

                        <hr>

                        <h6 class="fw-bold mb-1">

                            Rakib Hasan

                        </h6>

                        <small class="text-muted">

                            Alpha Net ISP

                        </small>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="glass-card p-4 h-100 shadow-sm">

                        <div class="mb-3 text-warning fs-5">

                            ★★★★★

                        </div>

                        <p class="text-secondary">

                            "The reporting system is outstanding.
                            We can monitor collections, customer growth,
                            and network performance in real time."

                        </p>

                        <hr>

                        <h6 class="fw-bold mb-1">

                            Mehedi Islam

                        </h6>

                        <small class="text-muted">

                            SkyLink Network

                        </small>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="glass-card p-4 h-100 shadow-sm">

                        <div class="mb-3 text-warning fs-5">

                            ★★★★★

                        </div>

                        <p class="text-secondary">

                            "One of the best ISP Billing platforms we've used.
                            Easy to manage multiple branches and payment gateways."

                        </p>

                        <hr>

                        <h6 class="fw-bold mb-1">

                            Tanvir Ahmed

                        </h6>

                        <small class="text-muted">

                            NetZone Broadband

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- FAQ Section -->
    <section class="py-3 py-md-5 section-block position-relative z-1 px-0 px-sm-3">

        <div class="container" style="max-width:850px;">

            <div class="text-center mb-4 mb-md-5 section-heading-wrap">

                

                <h2 class="fw-bold section-title text-dark">
                    Frequently Asked Questions
                </h2>

                <div class="mx-auto bg-gradient-primary rounded-pill mt-3"
                    style="width:80px;height:5px;"></div>

                <p class="text-secondary mt-3 section-subtitle">

                    Find answers to the most common questions about our ISP Billing Platform.

                </p>

            </div>

            <div class="accordion accordion-flush accordion-custom" id="faqAccordion">

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button class="accordion-button"

                            type="button"

                            data-bs-toggle="collapse"

                            data-bs-target="#faq1">

                            Is the software cloud-based?

                        </button>

                    </h2>

                    <div id="faq1"

                        class="accordion-collapse collapse show"

                        data-bs-parent="#faqAccordion">

                        <div class="accordion-body">

                            Yes. Our platform is cloud-based, allowing you to securely manage your ISP business anytime and from anywhere.

                        </div>

                    </div>

                </div>

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button class="accordion-button collapsed"

                            type="button"

                            data-bs-toggle="collapse"

                            data-bs-target="#faq2">

                            Does it support MikroTik and OLT devices?

                        </button>

                    </h2>

                    <div id="faq2"

                        class="accordion-collapse collapse"

                        data-bs-parent="#faqAccordion">

                        <div class="accordion-body">

                            Yes. The system integrates with MikroTik routers and supports GPON/EPON OLT management for centralized network monitoring.

                        </div>

                    </div>

                </div>

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button class="accordion-button collapsed"

                            type="button"

                            data-bs-toggle="collapse"

                            data-bs-target="#faq3">

                            Which payment gateways are supported?

                        </button>

                    </h2>

                    <div id="faq3"

                        class="accordion-collapse collapse"

                        data-bs-parent="#faqAccordion">

                        <div class="accordion-body">

                            You can integrate popular payment gateways such as SSLCommerz, bKash, Nagad, Rocket, and other supported providers.

                        </div>

                    </div>

                </div>

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button class="accordion-button collapsed"

                            type="button"

                            data-bs-toggle="collapse"

                            data-bs-target="#faq4">

                            Can I manage multiple branches?

                        </button>

                    </h2>

                    <div id="faq4"

                        class="accordion-collapse collapse"

                        data-bs-parent="#faqAccordion">

                        <div class="accordion-body">

                            Absolutely. The software supports multiple branches, POPs, and administrators from a single centralized dashboard.

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

   <!-- Call to Action -->
    <section class="py-3 py-md-5 mb-3 px-2 px-md-3">
        <div class="container px-2 px-sm-3">

            <div class="bg-white rounded-4 shadow-sm border p-4 p-md-5 mx-auto"
                style="max-width:1100px;">

                <div class="row align-items-center text-center text-lg-start g-4">

                    <div class="col-lg-7">

                       

                        <h2 class="fw-bold display-5 mb-3 lh-sm">

                            Power Your
                            <span class="text-gradient">ISP Business</span>
                            with Smart Automation

                        </h2>

                        <p class="text-secondary mb-0 fw-medium"
                            style="line-height:1.7;font-size:clamp(1rem,2vw,1.15rem);">

                            Automate billing, manage customers, monitor MikroTik & OLT devices,
                            accept online payments, and grow your Internet Service Provider
                            business with one powerful platform.

                        </p>

                    </div>

                    <div class="col-lg-5 text-lg-end">

                        <div class="d-grid d-sm-flex justify-content-center justify-content-lg-end gap-3">

                            <a href="/demo"
                                class="btn btn-light border rounded-pill px-4 py-2 fw-bold text-nowrap">

                                <i class="bi bi-play-circle me-2"></i>

                                Live Demo

                            </a>

                            <a href="/register"
                                class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm text-nowrap">

                                <i class="bi bi-person-plus-fill me-2"></i>

                                Get Started

                            </a>

                        </div>

                        <div class="mt-4 text-muted small fw-medium d-flex flex-wrap align-items-center justify-content-center justify-content-lg-end gap-2 gap-sm-3">

                            <span>

                                <i class="bi bi-check-circle-fill text-success me-1"></i>

                                Free Setup

                            </span>

                            <span class="d-none d-sm-inline">•</span>

                            <span>

                                <i class="bi bi-cloud-check-fill text-success me-1"></i>

                                Cloud Based

                            </span>

                            <span class="d-none d-sm-inline">•</span>

                            <span>

                                <i class="bi bi-headset text-success me-1"></i>

                                24/7 Support

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- Footer -->
<footer class="site-footer mt-auto">

    <div class="site-footer__top">

        <div class="container py-5">

            <div class="row g-4 g-lg-5">

                <!-- Company -->

                <div class="col-lg-4">

                    <a href="/"
                        class="site-footer__brand d-inline-flex align-items-center gap-2 text-decoration-none mb-3">

                        <div class="bg-gradient-primary text-white rounded p-2 d-flex align-items-center justify-content-center shadow-sm"
                            style="width:38px;height:38px;">

                            <i class="bi bi-router-fill"></i>

                        </div>

                        <div class="d-flex flex-column">

                            <span class="fw-bold fs-5 text-white brand-font">

                                ISP Billing

                            </span>

                            <span class="text-white-50 fw-semibold"
                                style="font-size:.72rem;">

                                Smart Billing. Smarter ISP.

                            </span>

                        </div>

                    </a>

                    <p class="site-footer__text mb-3">

                        A complete ISP Billing & Network Management solution
                        for Internet Service Providers. Automate billing,
                        manage customers, monitor MikroTik & OLT devices,
                        and grow your business with confidence.

                    </p>

                    <div class="d-flex flex-wrap gap-2">

                        <a href="/register"
                            class="btn btn-sm btn-light rounded-pill fw-semibold px-3">

                            Get Started

                        </a>

                        <a href="/login"
                            class="btn btn-sm btn-outline-light rounded-pill fw-semibold px-3">

                            Client Portal

                        </a>

                    </div>

                </div>

                <!-- Quick Links -->

                <div class="col-6 col-md-4 col-lg-2">

                    <h6 class="site-footer__heading">

                        Quick Links

                    </h6>

                    <ul class="site-footer__links list-unstyled">

                        <li><a href="/">Home</a></li>

                        <li><a href="#features">Features</a></li>

                        <li><a href="#pricing">Pricing</a></li>

                        <li><a href="#faq">FAQ</a></li>

                        <li><a href="/contact">Contact</a></li>

                    </ul>

                </div>

                <!-- Features -->

                <div class="col-6 col-md-4 col-lg-3">

                    <h6 class="site-footer__heading">

                        Platform

                    </h6>

                    <ul class="site-footer__links list-unstyled">

                        <li>MikroTik Integration</li>

                        <li>OLT Management</li>

                        <li>Automated Billing</li>

                        <li>Payment Gateway</li>

                        <li>Reports & Analytics</li>

                    </ul>

                </div>

                <!-- Contact -->

                <div class="col-md-4 col-lg-3">

                    <h6 class="site-footer__heading">

                        Contact

                    </h6>

                    <ul class="site-footer__links list-unstyled">

                        <li class="d-flex align-items-start gap-2">

                            <i class="bi bi-envelope-fill mt-1"></i>

                            <span>

                                support@yourdomain.com

                            </span>

                        </li>

                        <li class="d-flex align-items-start gap-2 mt-2">

                            <i class="bi bi-telephone-fill mt-1"></i>

                            <span>

                                +880 1700-000000

                            </span>

                        </li>

                        <li class="d-flex align-items-start gap-2 mt-2">

                            <i class="bi bi-geo-alt-fill mt-1"></i>

                            <span>

                                Dhaka, Bangladesh

                            </span>

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <!-- Bottom -->

    <div class="site-footer__bottom">

        <div class="container py-3">

            <div class="row align-items-center">

                <div class="col-md-6 text-center text-md-start">

                    <p class="site-footer__copy mb-0">

                        © {{ date('Y') }}

                        ISP Billing.

                        All Rights Reserved.

                    </p>

                </div>

                <div class="col-md-6 text-center text-md-end">

                    <p class="site-footer__credit mb-0">

                        Designed & Developed by

                        <a href="#"
                            class="site-footer__dev-link">

                            Your Company

                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Mobile FAB for urgent requests -->
    

    <!-- Intersection Observer Script for Fade Up Animations -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        // Optional: stop observing once animated
                        // observer.unobserve(entry.target); 
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: "0px 0px -50px 0px"
            });

            document.querySelectorAll('.fade-up').forEach((el) => observer.observe(el));
        });
    </script>
    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": ["NGO", "MedicalOrganization"],
      "name": "রক্ত খুঁজি",
      "url": "https://blood.lilyra.com",
      "logo": "https://blood.lilyra.com/images/og-image.png",
      "description": "Bangladesh&#039;s most advanced area-based blood donor network. Find donors in your village, union, or neighborhood — or become a donor and save someone&#039;s life.",
      "areaServed": "Bangladesh",
      "sameAs": [
        "https://www.facebook.com/profile.php?id=100080721994951"
      ]
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "রক্ত খুঁজি",
      "url": "https://blood.lilyra.com",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "https://blood.lilyra.com/donors/search?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Is it completely free to use?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes! Rokto Khuji is a 100% free platform. We do not charge anything from donors or patients."
          }
        },
        {
          "@type": "Question",
          "name": "Who can donate blood?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Anyone in good health, between 18-60 years of age, weighing at least 45 kg, can donate blood. You must not have donated blood in the last 90 days (120 days for women)."
          }
        },
        {
          "@type": "Question",
          "name": "Will my phone number be public?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Your phone number is only visible to registered users who need blood. You can also hide your profile by marking yourself as unavailable."
          }
        }
      ]
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "HowTo",
      "name": "How It Works",
      "description": "Connect with blood donors in just 3 simple steps",
      "step": [
        {
          "@type": "HowToStep",
          "name": "Create an Account",
          "text": "Easily sign up and add your blood group and area information."
        },
        {
          "@type": "HowToStep",
          "name": "Find or Donate Blood",
          "text": "Search when blood is needed in your ward or village, or stay ready as a donor."
        },
        {
          "@type": "HowToStep",
          "name": "Contact Directly",
          "text": "Reach out to donors directly by phone — no middlemen involved."
        }
      ]
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "রক্ত খুঁজি",
      "applicationCategory": "HealthApplication",
      "operatingSystem": "All",
      "description": "Bangladesh&#039;s most advanced area-based blood donor network. Find donors in your village, union, or neighborhood — or become a donor and save someone&#039;s life."
    }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sproutplex Jobs')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Verified jobs with direct links to official company websites.')">

    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">


    <meta name="theme-color" content="#198754">
    <link rel="icon" type="image/png" href="favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="favicon/favicon.svg" />
    <link rel="shortcut icon" href="favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="MyWebSite" />
    <link rel="manifest" href="favicon/site.webmanifest" />


    @yield('meta')

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }

        .navbar {
            border-bottom: 1px solid #e9ecef;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #14a344 !important;
        }

        .tagline {
            font-size: 0.85rem;
            color: #6c757d;
            margin-left: 0.5rem;
        }

        main {
            min-height: 70vh;
        }

        footer {
            background-color: #fff;
            border-top: 1px solid #e9ecef;
        }

        footer small {
            color: #6c757d;
        }

        .alert {
            border-radius: 0.5rem;
        }

        .btn-primary {
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, .1);
        }

        #cookie-banner a:hover {
            text-decoration: underline;
        }

        .btn-telegram {
            background-color: #0088cc;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            transition: background-color 0.2s ease;
        }

        .btn-telegram:hover {
            background-color: #006699;
            color: #fff;
        }

        /* Hero Background Section */

        /* Add to your CSS */
        /* Remove any potential spacing from the first element */
        .hero-bg {
            position: relative;
            background: url('../images/sprout_bg.png') center/cover no-repeat;
            color: #ffffff;
            width: 100%;
            margin: 0;
            padding: 0;
            margin-left: calc(-50vw + 50%);
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100dvh;
        }

        /* Full screen on both desktop and mobile */

        /* Fallback for older browsers */
        @supports not (min-height: 100dvh) {
            .hero-bg {
                min-height: 100vh;
            }
        }

        /* Ensure html/body are full width */
        html,
        body {
            width: 100%;
            /* height: 100%; */
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Overlay for readability */
        /* Overlay layer */
        .hero-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.6));
            /* or gradient for depth */
            z-index: 0;
        }

        /* Ensure content sits above overlay */
        .hero-bg .container {
            position: relative;
            z-index: 1;
        }

        /* === TYPOGRAPHY WITH ANIMATIONS === */

        /* Keyframes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Main headline */
        /* Main headline - moderate size with animation */
        .hero-bg h1 {
            font-weight: 800 !important;
            margin-bottom: 1.5rem !important;
            animation: fadeInUp 0.8s ease-out forwards;
            font-size: clamp(1.75rem, 4vw, 3rem);
            /* base scaling */
        }

        /* Subtext paragraph */
        .hero-bg .lead {
            font-size: 1.4rem !important;
            margin-bottom: 1.75rem !important;
            font-weight: 400;
            animation: fadeInUp 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }

        /* Trust signal badges */
        .hero-bg .badge {
            font-size: 0.95rem !important;
            padding: 0.6rem 1.2rem !important;
            font-weight: 500;
            animation: scaleIn 0.5s ease-out forwards;
            opacity: 0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hero-bg .badge:nth-child(1) {
            animation-delay: 0.3s;
        }

        .hero-bg .badge:nth-child(2) {
            animation-delay: 0.5s;
        }

        .hero-bg .badge:nth-child(3) {
            animation-delay: 0.7s;
        }

        .hero-bg .badge:nth-child(4) {
            animation-delay: 0.9s;
        }

        .hero-bg .badge:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }


        /* Bottom trust text */
        .hero-bg .small {
            font-size: 0.9rem !important;
            margin-top: 1rem;
            animation: fadeIn 1s ease-out 1.1s forwards;
            opacity: 0;
        }

        /* Logo animation */
        .premium-logo {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Desktop adjustments */
        @media (min-width: 768px) {
            .hero-bg h1 {
                font-size: 3.5rem !important;
            }

            .hero-bg .lead {
                font-size: 1.6rem !important;
            }
        }

        /* Mobile adjustments — bigger heading */
        @media (max-width: 767px) {
            .hero-bg h1 {
                font-size: 3rem !important;
            }

            /* bumped up */
            .hero-bg .lead {
                font-size: 1.35rem !important;
            }

            .hero-bg .badge {
                font-size: 0.85rem !important;
                padding: 0.5rem 1rem !important;
            }

            .hero-bg .small {
                font-size: 0.85rem !important;
            }
        }

        /* Very large screens */
        @media (min-width: 1400px) {
            .hero-bg h1 {
                font-size: 4rem !important;
            }

            .hero-bg .lead {
                font-size: 1.8rem !important;
            }
        }
    </style>

    <style>
        #cookie-banner {
            animation: slideUp .4s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }

            to {
                transform: translateY(0);
            }
        }


        /* Share layout */
        .share-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* container */
        .share-icons {
            display: flex;
            gap: 8px;
        }

        /* circular elegant buttons */
        .share-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;

            background: #f8f9fa;
            border: 1px solid #e9ecef;

            color: #6c757d;
            transition: all .25s ease;
        }

        /* hover effect */
        .share-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, .12);
        }

        /* brand colors on hover only (clean look) */
        .share-btn.whatsapp:hover {
            background: #25D366;
            color: #fff;
            border-color: #25D366;
        }

        .share-btn.facebook:hover {
            background: #1877F2;
            color: #fff;
            border-color: #1877F2;
        }

        .share-btn.linkedin:hover {
            background: #0A66C2;
            color: #fff;
            border-color: #0A66C2;
        }

        .share-btn.twitter:hover {
            background: #000;
            color: #fff;
            border-color: #000;
        }

        .share-btn.copy:hover {
            background: #198754;
            color: #fff;
            border-color: #198754;
        }

        /* OPTIONAL: show only on card hover (premium look) */
        /* .share-row {
            opacity: 0;
            transition: opacity .25s ease;
        }

        .card:hover .share-row {
            opacity: 1;
        } */

        /* End Style for job card */


        /* big share layout */
        .share-big {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* circular buttons */
        .share-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 18px;

            background: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #6c757d;

            transition: all .25s ease;
        }

        /* smooth lift */
        .share-circle:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .12);
        }

        /* brand hover colors */
        .share-circle.whatsapp:hover {
            background: #25D366;
            color: #fff;
            border-color: #25D366;
        }

        .share-circle.facebook:hover {
            background: #1877F2;
            color: #fff;
            border-color: #1877F2;
        }

        .share-circle.linkedin:hover {
            background: #0A66C2;
            color: #fff;
            border-color: #0A66C2;
        }

        .share-circle.twitter:hover {
            background: #000;
            color: #fff;
            border-color: #000;
        }

        .share-circle.copy:hover {
            background: #198754;
            color: #fff;
            border-color: #198754;
        }

        .share-circle.share-native:hover {
            background: #20c997;
            color: #fff;
            border-color: #20c997;
        }

        #backToTop:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s;
        }

        .hover-shadow:hover {
            background: #198754;
            color: white !important;
            transform: translateY(-2px);
            transition: .2s;
        }

        .hover-shadow {
            transition: .25s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
        }

        .hover-shadow:hover {
            background-color: var(--bs-white);
            color: #fff;
            transition: 0.3s ease;
        }

        .hover-shadow:hover .btn-outline-success {
            background-color: #fff;
            color: var(--bs-success);
            border-color: #fff;
        }

        /* ===== RESET DROPDOWN STYLES ===== */
        .nav-item.dropdown .nav-link.dropdown-toggle {
            list-style: none !important;
        }

        .nav-item.dropdown .nav-link.dropdown-toggle::before,
        .nav-item.dropdown .nav-link.dropdown-toggle::after,
        .nav-item.dropdown .nav-link.dropdown-toggle>*:first-child::before,
        .nav-item.dropdown .nav-link.dropdown-toggle>*:first-child::after {
            display: none !important;
            content: none !important;
        }

        .nav-item.dropdown .nav-link.dropdown-toggle,
        .nav-item.dropdown .nav-link.dropdown-toggle * {
            list-style-type: none !important;
        }

        /* ===== NOTIFICATION TOGGLE ===== */
        .notification-toggle {
            position: relative;
            padding: 0.5rem !important;
            margin: 0 0.25rem;
            border-radius: 50%;
            transition: background-color 0.2s ease;
            text-decoration: none;
        }

        .notification-toggle::after {
            display: none !important;
            /* Removes Bootstrap dropdown chevron */
            content: none !important;
        }

        .notification-toggle:hover {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .bell-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bell-container i {
            font-size: 1.4rem;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .notification-toggle:hover i {
            color: #10b981;
        }

        .notification-counter {
            position: absolute;
            top: -8px;
            right: -8px;
            min-width: 20px;
            height: 20px;
            background: linear-gradient(145deg, #ef4444, #dc2626);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            box-shadow: 0 3px 8px rgba(239, 68, 68, 0.4);
            border: 2px solid white;
        }

        /* ===== NOTIFICATION DROPDOWN ===== */
        .notification-menu {
            width: 360px;
            padding: 0 !important;
            border: none !important;
            border-radius: 20px !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
            overflow: hidden;
            margin-top: 0.75rem !important;
            animation: dropdown-appear 0.2s ease;
        }

        @keyframes dropdown-appear {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== NOTIFICATION HEADER ===== */
        .notification-header {
            padding: 1rem 1.25rem;
            background: #f8fafc;
            border-bottom: 1px solid #e9eef2;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-title i {
            color: #10b981;
            font-size: 1.1rem;
        }

        .header-title span {
            font-weight: 600;
            color: #1e2937;
            font-size: 0.95rem;
        }

        .unread-chip {
            background: #e2f3e4;
            color: #0b7b4b;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 30px;
            letter-spacing: 0.3px;
        }

        /* ===== NOTIFICATION LIST ===== */
        .notification-list {
            max-height: 340px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .notification-list::-webkit-scrollbar {
            width: 5px;
        }

        .notification-list::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .notification-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* ===== NOTIFICATION ITEM ===== */
        .notification-item {
            padding: 1rem 1.25rem;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            text-decoration: none;
            border-bottom: 1px solid #f0f4f8;
            transition: background-color 0.15s ease;
            cursor: default;
        }

        .notification-item:hover {
            background-color: #fafdff;
        }

        .notification-item.unread {
            background-color: #f4faf7;
            position: relative;
        }

        .notification-item.unread::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #10b981;
            border-radius: 0 2px 2px 0;
        }

        /* Item Icon */
        .item-icon {
            width: 36px;
            height: 36px;
            background: #e8f3ef;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .item-icon i {
            color: #10b981;
            font-size: 1rem;
        }

        .unread .item-icon {
            background: #d9f0e5;
        }

        .unread .item-icon i {
            color: #0e7d4e;
        }

        /* Item Content */
        .item-content {
            flex: 1;
            min-width: 0;
        }

        .item-message {
            color: #1e2937;
            font-size: 0.9rem;
            line-height: 1.4;
            margin-bottom: 0.35rem;
            font-weight: 400;
            word-wrap: break-word;
        }

        .unread .item-message {
            font-weight: 500;
            color: #0b2e1f;
        }

        .item-time {
            color: #8a9aa8;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .item-time::before {
            content: '•';
            color: #cbd5e1;
            font-size: 0.8rem;
            margin-right: 0.2rem;
        }

        /* Unread Dot */
        .item-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            margin-top: 0.3rem;
            flex-shrink: 0;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.15);
        }

        /* ===== EMPTY STATE ===== */
        .notification-empty {
            padding: 2.5rem 1.5rem;
            text-align: center;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            background: #f3f6f9;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .empty-icon i {
            font-size: 2.2rem;
            color: #a7b8c7;
        }

        .empty-title {
            color: #1e2937;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .empty-text {
            color: #8698a8;
            font-size: 0.85rem;
        }

        /* ===== NOTIFICATION FOOTER ===== */
        .notification-footer {
            padding: 0.85rem 1.25rem;
            background: #f9fbfd;
            border-top: 1px solid #e9eef2;
            text-align: center;
        }

        .view-all {
            color: #10b981;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            cursor: default;
            transition: gap 0.2s ease;
        }

        .view-all i {
            font-size: 0.8rem;
            transition: transform 0.2s ease;
        }

        .view-all:hover {
            gap: 0.6rem;
        }

        .view-all:hover i {
            transform: translateX(3px);
        }

        /* ===== RESPONSIVE ADJUSTMENTS ===== */
        @media (max-width: 576px) {
            .notification-menu {
                width: 320px;
                position: fixed !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
            }
        }
    </style>

</head>

<body>

    <!-- Navbar -->
    <!-- Premium Navbar - N1.4 Million Edition -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-premium" id="premiumNav">
        <div class="container">
            <div class="navbar-content d-flex justify-content-between align-items-center w-100">

                <!-- Premium Logo with Animation -->
                <a class="navbar-brand d-flex align-items-center gap-3" href="/jobs">
                    <div class="logo-wrapper position-relative">
                        <div class="logo-glow"></div>
                        <img src="{{ asset('images/sprout_logo.png') }}" class="premium-logo"
                            style="height:52px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));">
                    </div>
                    {{-- <div class="brand-text">
                        <span class="brand-primary">Sproutplex</span>
                        <span class="brand-secondary">Apple</span>
                        <span class="brand-jobs">Jobs</span>
                    </div> --}}
                </a>

                <!-- Premium Tagline Badge -->
                <div class="premium-badge-wrapper d-md-flex justify-content-center">
                    <div class="premium-badge premium-success-badge">
                        <div class="badge-shine"></div>
                        <span class="badge-icon success-icon">✓</span>
                        <span class="badge-text success-text">Verified Jobs Only</span>
                        <span class="badge-premium">Premium</span>
                    </div>
                </div>

                <!-- Premium Navigation Right justify-content-end -->
                <div class="d-flex align-items-center gap-3">

                    @guest
                        <!-- Premium Guest Navigation -->
                        {{-- <a href="{{ route('companies.index') }}" class="companies-button">
                            <span class="button-text">Companies</span>
                            <span class="button-icon">→</span>
                            <div class="button-glow"></div>
                        </a>

                        <a href="{{ route('pricing') }}" class="premium-button">
                            <span class="button-text">For Employers</span>
                            <span class="button-icon">→</span>
                            <div class="button-glow"></div>
                        </a> --}}
                        {{-- <a href="{{ route('opportunities.index') }}" class="companies-button">
                            <span class="button-text">Opportunities</span>
                            <span class="button-icon">→</span>
                            <div class="button-glow"></div>
                        </a> --}}
                    @endguest

                    @auth
                        @if (auth()->user()->role === 'employer')
                            <!-- Premium Employer Dropdown -->
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link notification-toggle" data-bs-toggle="dropdown" role="button"
                                        aria-expanded="false">
                                        <div class="bell-container">
                                            <i class="bi bi-bell"></i>
                                            @if (auth()->user()->unreadNotifications->count() > 0)
                                                <span class="notification-counter">
                                                    {{ auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count() }}
                                                </span>
                                            @endif
                                        </div>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end notification-menu">
                                        <div class="notification-header">
                                            <div class="header-title">
                                                <i class="bi bi-bell-fill"></i>
                                                <span>Notifications</span>
                                            </div>
                                            @if (auth()->user()->unreadNotifications->count() > 0)
                                                <span class="unread-chip">{{ auth()->user()->unreadNotifications->count() }}
                                                    new</span>
                                            @endif
                                        </div>

                                        <div class="notification-list">
                                            @forelse(auth()->user()->notifications->take(5) as $notification)
                                                <a class="notification-item {{ $notification->read_at ? '' : 'unread' }}">
                                                    <div class="item-icon">
                                                        <i class="bi bi-bell"></i>
                                                    </div>
                                                    <div class="item-content">
                                                        <div class="item-message">{{ $notification->data['message'] }}</div>
                                                        <div class="item-time">
                                                            {{ $notification->created_at->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                    @if (!$notification->read_at)
                                                        <span class="item-dot"></span>
                                                    @endif
                                                </a>
                                            @empty
                                                <div class="notification-empty">
                                                    <div class="empty-icon">
                                                        <i class="bi bi-bell-slash"></i>
                                                    </div>
                                                    <div class="empty-title">No notifications</div>
                                                    <div class="empty-text">You're all caught up!</div>
                                                </div>
                                            @endforelse
                                        </div>

                                        @if (auth()->user()->notifications->count() < 5)
                                            <div class="notification-footer">
                                                <a href="/notifications" class="view-all">
                                                    View all notifications <i class="bi bi-arrow-right"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                            <div class="premium-dropdown-container">
                                <button class="premium-user-button" type="button" id="employerMenu"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-avatar">
                                        <span class="avatar-initials">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                        <span class="avatar-status"></span>
                                    </div>
                                    <span class="user-name d-none d-lg-block">{{ auth()->user()->name }}</span>
                                    <span class="user-chevron">▼</span>
                                </button>

                                <div class="premium-dropdown-menu dropdown-menu dropdown-menu-end"
                                    aria-labelledby="employerMenu">
                                    <div class="dropdown-header">
                                        <div class="dropdown-header-icon">👋</div>
                                        <div>
                                            <div class="dropdown-greeting">Welcome back</div>
                                            <div class="dropdown-user">{{ auth()->user()->name }}</div>
                                        </div>
                                    </div>

                                    <div class="dropdown-divider"></div>

                                    <a class="premium-dropdown-item" href="{{ route('employer.dashboard') }}">
                                        <span class="item-icon">📊</span>
                                        <span class="item-text">Dashboard</span>
                                        <span class="item-badge">New</span>
                                    </a>

                                    <a class="premium-dropdown-item" href="{{ route('employer.create') }}">
                                        <span class="item-icon">➕</span>
                                        <span class="item-text">Post Job</span>
                                    </a>

                                    <a class="premium-dropdown-item" href="{{ route('employer.subscription') }}">
                                        <span class="item-icon">💎</span>
                                        <span class="item-text">Subscription</span>
                                        <span class="item-badge premium">Active</span>
                                    </a>

                                    <a class="premium-dropdown-item" href="{{ route('employer.applicants') }}">
                                        <span class="item-icon">👥</span>
                                        <span class="item-text">Applicants</span>
                                        <span class="item-count">3</span>
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <a class="premium-dropdown-item"
                                        href="{{ route('employer.company.page', auth()->user()->id) }}" target="_blank">
                                        <span class="item-icon">🏢</span>
                                        <span class="item-text">Company Page</span>
                                    </a>

                                    <a class="premium-dropdown-item" href="{{ route('employer.profile') }}">
                                        <span class="item-icon">⚙️</span>
                                        <span class="item-text">Profile Settings</span>
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <button type="submit" class="premium-dropdown-item logout-button">
                                            <span class="item-icon text-danger">🚪</span>
                                            <span class="item-text text-danger">Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @elseif(auth()->user()->role === 'admin')
                            <!-- Premium Admin Button -->
                            <form method="POST" action="{{ route('logout') }}" class="admin-logout-form">
                                @csrf
                                <button type="submit" class="admin-logout-button">
                                    <span class="admin-icon">⚡</span>
                                    <span class="admin-text d-none d-md-inline">Admin Logout</span>
                                </button>
                            </form>
                        @endif
                    @endauth

                </div>
            </div>
        </div>
    </nav>

    <style>
        /* Premium Navbar Styles - N1.4 Million Edition */
        .navbar-premium {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            padding: 16px 0;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.02);
        }

        .navbar-premium.scrolled {
            padding: 12px 0;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 10px 40px rgba(16, 185, 129, 0.1);
        }

        /* Premium Logo Animation */
        .logo-wrapper {
            position: relative;
            transition: transform 0.3s ease;
        }

        .logo-wrapper:hover {
            transform: scale(1.05);
        }

        .logo-glow {
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, rgba(16, 185, 129, 0) 70%);
            filter: blur(8px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .logo-wrapper:hover .logo-glow {
            opacity: 1;
        }

        .premium-logo {
            position: relative;
            z-index: 2;
            transition: filter 0.3s ease;
        }

        .premium-logo:hover {
            filter: drop-shadow(0 8px 16px rgba(16, 185, 129, 0.3)) !important;
        }

        /* Premium Brand Text */
        .brand-text {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            position: relative;
        }

        .brand-primary {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-secondary {
            background: linear-gradient(135deg, #064e3b 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-jobs {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 1rem;
            position: relative;
            top: -1px;
        }

        /* Premium Badge - Success Green Version */
        .premium-badge-wrapper {
            position: relative;
            /* overflow: hidden; */
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        .premium-success-badge {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            padding: 8px 16px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(16, 185, 129, 0.2);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.1);
            transition: all 0.3s ease;
        }

        .premium-success-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2);
        }

        .badge-shine {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(30deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(30deg);
            }

            20%,
            100% {
                transform: translateX(100%) rotate(30deg);
            }
        }

        .success-icon {
            background: #10b981;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .success-text {
            color: #047857;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .badge-premium {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            padding: 4px 8px;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Companies Button - Success Green */
        .companies-button {
            position: relative;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 60px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .companies-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
            color: white;
        }

        .companies-button .button-icon {
            transition: transform 0.3s ease;
        }

        .companies-button:hover .button-icon {
            transform: translateX(5px);
        }

        .companies-button .button-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .companies-button:hover .button-glow {
            opacity: 1;
        }

        /* Premium Button - For Employers (keeping original) */
        .premium-button {
            position: relative;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 60px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .premium-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
            color: white;
        }

        .premium-button .button-icon {
            transition: transform 0.3s ease;
        }

        .premium-button:hover .button-icon {
            transform: translateX(5px);
        }

        .premium-button .button-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .premium-button:hover .button-glow {
            opacity: 1;
        }

        /* Premium User Button */
        .premium-user-button {
            background: none;
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 6px 12px 6px 6px;
            border-radius: 60px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            background: white;
        }

        .premium-user-button:hover {
            border-color: #10b981;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.1);
            transform: translateY(-2px);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }

        .avatar-status {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            background: #10b981;
            border: 2px solid white;
            border-radius: 50%;
        }

        .user-name {
            color: #1f2937;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .user-chevron {
            color: #9ca3af;
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }

        .premium-user-button[aria-expanded="true"] .user-chevron {
            transform: rotate(180deg);
        }

        /* Premium Dropdown Menu */
        .premium-dropdown-menu {
            border: none;
            border-radius: 20px;
            padding: 16px 8px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(16, 185, 129, 0.1);
            min-width: 280px;
            margin-top: 15px;
            overflow: hidden;
        }

        .dropdown-header {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dropdown-header-icon {
            font-size: 2rem;
        }

        .dropdown-greeting {
            color: #6b7280;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .dropdown-user {
            color: #1f2937;
            font-weight: 700;
            font-size: 1rem;
        }

        .premium-dropdown-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #374151;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 12px;
            margin: 4px 8px;
        }

        .premium-dropdown-item:hover {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(4, 120, 87, 0.05) 100%);
            color: #10b981;
            transform: translateX(5px);
        }

        .item-icon {
            font-size: 1.2rem;
            width: 24px;
        }

        .item-text {
            flex: 1;
            font-weight: 500;
        }

        .item-badge {
            background: #10b981;
            color: white;
            padding: 2px 8px;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .item-badge.premium {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .item-count {
            background: #f3f4f6;
            color: #4b5563;
            padding: 2px 8px;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .logout-button {
            width: 100%;
            border: none;
            background: none;
            transition: all 0.3s ease;
        }

        .logout-button:hover {
            background: rgba(239, 68, 68, 0.05);
        }

        /* Admin Logout Button */
        .admin-logout-button {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 60px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
        }

        .admin-logout-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }

        /* Dropdown Divider */
        .dropdown-divider {
            margin: 8px 0;
            border-color: rgba(16, 185, 129, 0.1);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .premium-badge-wrapper {
                display: none;
            }

            .brand-text {
                font-size: 1.2rem;
            }

            .premium-button {
                padding: 8px 16px;
                font-size: 0.85rem;
            }

            .companies-button {
                padding: 8px 16px;
                font-size: 0.85rem;
            }
        }
    </style>

    <script>
        // Add scroll effect to navbar
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('premiumNav');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Add click animation to dropdown items
            const dropdownItems = document.querySelectorAll('.premium-dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    // Don't prevent default, just add a ripple effect
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple-effect');
                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>


    <!-- Main Content -->
    <main class="py-5">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- <form method="POST" action="/subscribe" class="mt-5">
        @csrf

        <div class="p-4 rounded-4 bg-light">
            <h5 class="fw-bold mb-1">Job alerts that matter</h5>
            <p class="text-muted small mb-3">
                Curated jobs. Zero noise.
            </p>

            <div class="d-flex gap-2">
                <input type="email" name="email" class="form-control form-control-lg" placeholder="you@example.com"
                    required>

                <button class="btn btn-success btn-lg px-4">
                    <i class="bi bi-bell"></i> Notify me
                </button>
            </div>

            <p class="text-muted small mt-2 mb-0">
                Weekly updates. No spam.
            </p>
        </div>
    </form> --}}

    <!-- Trigger Button (Add this where you want the modal trigger) -->
    {{-- <button type="button" class="btn btn-success rounded-pill px-4 shadow-sm hover-lift" data-bs-toggle="modal"
        data-bs-target="#jobAlertsModal">
        <i class="bi bi-bell-fill me-2"></i> Get Alerts
    </button> --}}

    <!-- Floating Trigger Button -->
    <button type="button" class="btn btn-success rounded-circle shadow-lg floating-alert-btn" data-bs-toggle="modal"
        data-bs-target="#jobAlertsModal">
        <i class="bi bi-bell-fill fs-4"></i>
    </button>


    <!-- Modal -->
    <div class="modal fade" id="jobAlertsModal" tabindex="-1" aria-labelledby="jobAlertsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- Modal Header with Gradient --}}
                <div class="modal-header border-0 pb-0 position-relative">
                    <div class="bg-success-gradient py-4 px-5 w-100">
                        <div class="text-center">
                            <div class="icon-wrapper bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 64px; height: 64px;">
                                <i class="bi bi-bell-fill text-success fs-3"></i>
                            </div>
                            <h3 class="modal-title text-white fw-bold mb-1" id="jobAlertsModalLabel">Get Job Alerts
                            </h3>
                            <p class="text-white-75 mb-0">Never miss your perfect opportunity</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body p-5">
                    <form method="POST" action="{{ route('alerts.subscribe') }}" id="jobAlertForm"
                        class="needs-validation" novalidate>
                        @csrf


                        <div class="mb-4">
                            <label class="form-label fw-semibold">What do you want alerts for?</label>

                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="alert_type" value="job"
                                    id="alertJob" checked>
                                <label class="btn btn-outline-success" for="alertJob">Jobs</label>

                                <input type="radio" class="btn-check" name="alert_type" value="opportunity"
                                    id="alertOpportunity">
                                <label class="btn btn-outline-success" for="alertOpportunity">Opportunities</label>
                            </div>
                        </div>

                        {{-- Email Field --}}
                        <div class="mb-4">
                            <label for="alertEmail"
                                class="form-label fw-semibold text-dark d-flex align-items-center gap-2">
                                <i class="bi bi-envelope text-success"></i>
                                <span>Email Address</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success-soft border-success-subtle">
                                    <i class="bi bi-envelope text-success"></i>
                                </span>
                                <input type="email" name="email" id="alertEmail"
                                    class="form-control border-success-subtle py-3" placeholder="you@example.com"
                                    required autocomplete="email">
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>
                            <small class="text-muted mt-1 d-block">We'll send job alerts to this email</small>
                        </div>

                        {{-- Category Field --}}
                        <div class="mb-4">
                            <div id="jobCategoryField">

                                <label for="alertCategory"
                                    class="form-label fw-semibold text-dark d-flex align-items-center gap-2">
                                    <i class="bi bi-folder text-success"></i>
                                    <span>Job Category</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success-soft border-success-subtle">
                                        <i class="bi bi-folder text-success"></i>
                                    </span>
                                    <select name="category_id" id="alertCategory"
                                        class="form-select border-success-subtle py-3">
                                        <option value="" class="text-muted">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="text-muted mt-1 d-block">Optional - filter by specific category</small>
                            </div>


                            {{-- Opportunity Type --}}
                            <div class="mb-4" id="opportunityTypeField" style="display:none;">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-stars text-success"></i>
                                    Opportunity Type
                                </label>

                                <select name="opportunity_type" class="form-select">
                                    <option value="">All Opportunities</option>
                                    <option value="internship">Internship</option>
                                    <option value="scholarship">Scholarship</option>
                                    <option value="grant">Grant</option>
                                    <option value="graduate_program">Graduate Program</option>
                                </select>
                            </div>
                        </div>

                        {{-- Location Field --}}
                        <div class="mb-4">
                            <label for="alertLocation"
                                class="form-label fw-semibold text-dark d-flex align-items-center gap-2">
                                <i class="bi bi-geo-alt text-success"></i>
                                <span>Location Preference</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success-soft border-success-subtle">
                                    <i class="bi bi-geo-alt text-success"></i>
                                </span>
                                <input type="text" name="location" id="alertLocation"
                                    class="form-control border-success-subtle py-3"
                                    placeholder="City, State, or leave blank for all locations">
                                <div class="invalid-feedback">
                                    Please enter a valid location.
                                </div>
                            </div>
                            <small class="text-muted mt-1 d-block">
                                Optional - filter by location (ignored if Remote Only is checked)
                            </small>
                        </div>

                        {{-- Remote Only Toggle --}}
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="remote_only"
                                    value="1" id="remoteSwitch" style="width: 3em; height: 1.5em;">
                                <label class="form-check-label fw-semibold text-dark d-flex align-items-center gap-2"
                                    for="remoteSwitch">
                                    <i class="bi bi-laptop text-success"></i>
                                    <span>Remote Only</span>
                                </label>
                            </div>
                            <small class="text-muted mt-1 d-block">Only receive alerts for remote positions</small>
                        </div>

                        {{-- Frequency Option --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark d-flex align-items-center gap-2">
                                <i class="bi bi-clock text-success"></i>
                                <span>Alert Frequency</span>
                            </label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="frequency" id="frequencyDaily"
                                    value="daily" checked>
                                <label class="btn btn-outline-success border-success-subtle"
                                    for="frequencyDaily">Daily</label>

                                <input type="radio" class="btn-check" name="frequency" id="frequencyWeekly"
                                    value="weekly">
                                <label class="btn btn-outline-success border-success-subtle"
                                    for="frequencyWeekly">Weekly</label>

                                <input type="radio" class="btn-check" name="frequency" id="frequencyInstant"
                                    value="instant">
                                <label class="btn btn-outline-success border-success-subtle"
                                    for="frequencyInstant">Instant</label>
                            </div>
                        </div>

                        {{-- Terms & Privacy --}}
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input border-success-subtle" type="checkbox" name="terms"
                                    id="termsCheckbox" required>
                                <label class="form-check-label small text-muted" for="termsCheckbox">
                                    I agree to receive job alerts and have read the
                                    <a href="privacy-policy" target="_blank"
                                        class="text-success text-decoration-underline fw-semibold">Privacy Policy</a>
                                </label>
                                <div class="invalid-feedback">
                                    You must agree to the terms before subscribing.
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid gap-2">
                            <button type="submit"
                                class="btn btn-success btn-lg rounded-pill py-3 shadow-sm hover-lift">
                                <i class="bi bi-bell-fill me-2"></i>Subscribe to Alerts
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill"
                                data-bs-dismiss="modal">
                                Maybe Later
                            </button>

                            <a href="https://t.me/Sproutplexjobs" target="_blank"
                                class="btn btn-primary d-inline-flex align-items-center">
                                <i class="bi bi-telegram me-2"></i> Subscribe on Telegram
                            </a>
                        </div>
                    </form>

                </div>

                {{-- Modal Footer --}}
                <div class="modal-footer border-0 bg-light rounded-bottom-4">
                    <p class="text-muted small text-center mb-0">
                        <i class="bi bi-shield-check text-success me-1"></i>
                        We respect your privacy. Unsubscribe anytime.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-success-gradient {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        }

        .bg-success-soft {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .border-success-subtle {
            border-color: rgba(25, 135, 84, 0.2) !important;
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.75);
        }

        .icon-wrapper {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(25, 135, 84, 0.3) !important;
        }

        .btn-outline-success {
            color: #198754;
            border-color: rgba(25, 135, 84, 0.3);
        }

        .btn-outline-success:hover,
        .btn-outline-success:active,
        .btn-outline-success:focus {
            background-color: rgba(25, 135, 84, 0.1);
            border-color: #198754;
            color: #198754;
        }

        .btn-check:checked+.btn-outline-success {
            background-color: #198754;
            border-color: #198754;
            color: white;
        }

        /* Custom switch styling */
        .form-switch .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }

        /* Input focus effects */
        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }

        /* Modal animation */
        .modal-content {
            animation: modalSlideUp 0.3s ease-out;
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }



        .floating-alert-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            /* above most elements */
            transition: all 0.3s ease;
        }

        .floating-alert-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.4);
        }
    </style>

    <style>
        #pwaInstallBanner {
            animation: slideUp .35s ease;
        }

        @keyframes slideUp {
            from {
                transform: translate(-50%, 40px);
                opacity: 0;
            }

            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        .footer-link {
            transition: 0.2s ease;
        }

        .footer-link:hover {
            color: #198754 !important;
            padding-left: 4px;
        }

        footer {
            font-size: 14px;
        }

        .btn-outline-primary {
            transition: all 0.25s ease;
        }

        .btn-outline-primary:hover {
            background-color: #0088cc;
            border-color: #0088cc;
            color: #fff;
        }

        .telegram-btn {
            display: inline-block;
            background: linear-gradient(135deg, #0088cc, #20c997);
            color: #fff;
            padding: 8px 16px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s ease;
        }

        .telegram-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jobRadio = document.getElementById('alertJob');
            const oppRadio = document.getElementById('alertOpportunity');

            const jobField = document.getElementById('jobCategoryField');
            const oppField = document.getElementById('opportunityTypeField');

            function toggleFields() {
                if (oppRadio.checked) {
                    jobField.style.display = 'none';
                    oppField.style.display = 'block';
                } else {
                    jobField.style.display = 'block';
                    oppField.style.display = 'none';
                }
            }

            jobRadio.addEventListener('change', toggleFields);
            oppRadio.addEventListener('change', toggleFields);

            toggleFields(); // initial
        });
    </script>



    <script>
        // Form validation
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    } else {
                        // Show success state
                        const submitBtn = form.querySelector('button[type="submit"]')
                        const originalText = submitBtn.innerHTML
                        submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Subscribed!'
                        submitBtn.classList.remove('btn-success')
                        submitBtn.classList.add('btn-outline-success')
                        submitBtn.disabled = true

                        // Close modal after 1.5 seconds
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'jobAlertsModal'))
                            modal.hide()

                            // Reset button after modal closes
                            setTimeout(() => {
                                submitBtn.innerHTML = originalText
                                submitBtn.classList.remove('btn-outline-success')
                                submitBtn.classList.add('btn-success')
                                submitBtn.disabled = false
                            }, 300)
                        }, 1500)
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>

    <script>
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        )
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el))
    </script>


    <!-- Footer -->
    <footer class="bg-white border-top mt-5 pt-5 pb-0 position-relative">

        <!-- Top Accent Line -->
        <div style="height:4px; background:linear-gradient(90deg,#198754,#20c997,#0dcaf0);"></div>

        <div class="container py-5">

            <div class="row g-5">

                <!-- Brand Section -->
                <div class="col-lg-4 col-md-6">

                    <div class="d-flex align-items-center mb-3">
                        {{-- <img src="{{ asset('images/logo.svg') }}" style="height:40px;" class="me-2"> --}}
                        <img src="{{ asset('images/sprout_logo.png') }}" class="premium-logo"
                            style="height:60px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));">

                        {{-- <h5 class="fw-bold mb-0">Sproutplex Jobs</h5> --}}
                    </div>

                    <p class="text-muted small">
                        Sproutplex connects ambitious professionals with verified job opportunities across Nigeria.
                        We only link directly to official employer websites.
                    </p>

                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="text-muted"><i class="bi bi-twitter fs-5"></i></a>
                        <a href="#" class="text-muted"><i class="bi bi-linkedin fs-5"></i></a>
                        <a href="#" class="text-muted"><i class="bi bi-facebook fs-5"></i></a>
                    </div>

                    <div class="mt-4">
                        <span class="badge bg-success-subtle text-success border border-success">
                            ✔ Verified Listings Only
                        </span>
                    </div>

                </div>

                <!-- Job Seekers -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-semibold mb-3">For Job Seekers</h6>
                    <ul class="list-unstyled small">
                        @foreach ($footerLocations as $location)
                            <li class="mb-1">
                                <a href="{{ route('jobs.index', ['location' => $location]) }}"
                                    class="text-decoration-none text-muted footer-link">
                                    Jobs in {{ $location }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Popular Categories -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-semibold mb-3">Popular Categories</h6>
                    <ul class="list-unstyled small">
                        @foreach ($footerCategories as $category)
                            <li class="mb-1">
                                <a href="{{ route('jobs.index', ['category' => $category->id]) }}"
                                    class="text-decoration-none text-muted footer-link">
                                    {{ $category->name }}
                                    <span class="text-secondary">({{ $category->job_posts_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Company -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-semibold mb-3">Company</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1">
                            <a href="{{ route('about') }}" class="text-decoration-none text-muted footer-link">
                                About Us
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('why') }}" class="text-decoration-none text-muted footer-link">
                                Why Sproutplex
                            </a>
                        </li>
                        {{-- <li class="mb-1">
                            <a href="{{ route('pricing') }}" class="text-decoration-none text-muted footer-link">
                                Post a Job
                            </a>
                        </li> --}}
                        <li class="mb-1">
                            <a href="/contact" class="text-decoration-none text-muted footer-link">
                                Contact
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="/privacy-policy" class="text-decoration-none text-muted footer-link">
                                Privacy Policy
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="/terms" class="text-decoration-none text-muted footer-link">
                                Terms of Use
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="/cookies" class="text-decoration-none text-muted footer-link">
                                Cookies Policy
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-semibold mb-3">Stay Updated</h6>

                    <p class="small text-muted">
                        Get instant job alerts on Telegram. Join thousands of professionals already inside.
                    </p>

                    <a href="https://t.me/Sproutplexjobs" target="_blank"
                        class="btn btn-outline-primary btn-sm rounded-pill d-flex align-items-center justify-content-center gap-2">

                        <i class="bi bi-telegram"></i>
                        Subscribe
                    </a>
                    <p class="small text-muted mt-2 mb-0">
                        Free · No spam · Instant updates
                    </p>

                </div>

            </div>

            <hr class="my-5">

            <!-- Bottom Footer -->
            <div
                class="d-md-flex justify-content-between align-items-center text-center text-md-start small text-muted">

                <div>
                    © {{ date('Y') }} Sproutplex Jobs. All rights reserved.
                </div>

                <div class="mt-3 mt-md-0">
                    Abuja, Nigeria · support@Sproutplex.com
                </div>

            </div>

            <div class="text-center small text-muted mt-3">
                Sproutplex is not a recruitment agency. We aggregate and link to verified employer websites.
            </div>

        </div>
    </footer>



    <div id="cookie-banner" class="alert alert-success alert-dismissible fade show fixed-bottom mb-0" role="alert"
        style="z-index:9999; display:none;">
        <div class="container d-flex justify-content-between align-items-center"> <span> We use cookies to
                improve your experience. <a href="/cookies" class="alert-link">Read our Cookies Policy</a>.
            </span> <button id="accept-cookies" class="btn btn-primary btn-sm ms-3"> Accept </button> </div>
    </div>


    <!-- PWA Install Button -->
    {{-- <button id="pwaInstallBtn" class="btn btn-success rounded-pill shadow position-fixed"
        style="bottom:20px; center:20px; z-index:9999; display:none;">
        <i class="bi bi-download me-1"></i>
        Install Sproutplex Jobs
    </button> --}}


    <!-- iOS Instructions Modal -->
    {{-- <div id="iosInstallModal" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-none"
        style="z-index:10000;">

        <div class="bg-white rounded-4 p-4 shadow position-absolute top-50 start-50 translate-middle"
            style="max-width:340px; width:90%;">
            <h6 class="fw-bold mb-3">Install App</h6>

            <ol class="small text-muted">
                <li>Tap <strong>Share</strong> <i class="bi bi-share"></i></li>
                <li>Select <strong>Add to Home Screen</strong></li>
                <li>Tap <strong>Add</strong></li>
            </ol>

            <button id="closeIosModal" class="btn btn-success w-100 mt-3">
                Got it
            </button>
        </div>
    </div> --}}


    <script>
        let deferredPrompt;
        const installBtn = document.getElementById('pwaInstallBtn');
        const iosModal = document.getElementById('iosInstallModal');
        const closeIos = document.getElementById('closeIosModal');

        const isIOS = /iphone|ipad|ipod/i.test(navigator.userAgent);
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;

        // Hide if already installed
        if (!isStandalone) {

            // ---------- ANDROID ----------
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;

                installBtn.style.display = 'block';
            });

            installBtn.addEventListener('click', async () => {

                // Android install
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    await deferredPrompt.userChoice;
                    deferredPrompt = null;
                    installBtn.style.display = 'none';
                }

                // iOS fallback
                else if (isIOS) {
                    iosModal.classList.remove('d-none');
                }
            });

            // ---------- iOS ----------
            if (isIOS) {
                installBtn.style.display = 'block';
            }

            closeIos.addEventListener('click', () => {
                iosModal.classList.add('d-none');
            });
        }
    </script>

    <script>
        // Check if cookies have already been accepted
        function cookiesAccepted() {
            return document.cookie.split(';').some(item => item.trim().startsWith('cookiesAccepted='));
        } // Show banner if not accepted
        window.onload = function() {
            if (!cookiesAccepted()) {
                document.getElementById('cookie-banner').style.display = 'block';
            }
        }; // Handle acceptance
        document.getElementById('accept-cookies').onclick =
            function() { // Set a cookie valid for 1 year
                document.cookie = "cookiesAccepted=true; path=/; max-age=" + 60 * 60 * 24 * 365;
                document.getElementById('cookie-banner').style.display = 'none';
            };
    </script>

    <!-- Back to Top Button -->
    {{-- <button id="backToTop" class="btn btn-success btn-lg rounded-circle shadow-lg"
        style="position: fixed; top: 40px; right: 40px; display: none; z-index: 9999;">
        <i class="bi bi-arrow-up"></i>
    </button> --}}

    <!-- Back to Top Button -->
    <button id="backToTop" class="btn btn-lg rounded-circle shadow-lg border-0"
        style="position: fixed; bottom: 90px; right: 23px; z-index: 9999;
           width: 56px; height: 56px; display: none; opacity: 0;
           background: linear-gradient(135deg, #348850 0%, #266e42 100%);
           transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
        <i class="bi bi-chevron-up text-white" style="font-size: 1.5rem;"></i>
    </button>

    <script>
        const backToTop = document.getElementById('backToTop');

        // Show/hide button with fade animation
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.style.display = 'flex';
                backToTop.style.alignItems = 'center';
                backToTop.style.justifyContent = 'center';
                setTimeout(() => {
                    backToTop.style.opacity = '1';
                    backToTop.style.transform = 'translateY(0)';
                }, 10);
            } else {
                backToTop.style.opacity = '0';
                backToTop.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    if (parseFloat(backToTop.style.opacity) === 0) {
                        backToTop.style.display = 'none';
                    }
                }, 300);
            }
        });

        // Scroll to top smoothly with button feedback
        backToTop.addEventListener('click', () => {
            // Add click animation
            backToTop.style.transform = 'scale(0.9)';
            setTimeout(() => {
                backToTop.style.transform = 'scale(1)';
            }, 150);

            // Scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Hover effects
        backToTop.addEventListener('mouseenter', () => {
            backToTop.style.transform = 'translateY(-3px)';
            backToTop.style.boxShadow = '0 10px 25px rgba(37, 117, 252, 0.3)';
        });

        backToTop.addEventListener('mouseleave', () => {
            backToTop.style.transform = 'translateY(0)';
            backToTop.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.2)';
        });

        // Initialize button position
        backToTop.style.transform = 'translateY(20px)';
        backToTop.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.2)';
    </script>


    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('PWA registered'))
                    .catch(err => console.log(err));
            });
        }
    </script>


    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        // Initialize CKEditor on your textarea

        CKEDITOR.replace('descriptionEditor', {
            height: 300,
            removePlugins: 'elementspath',
            resize_enabled: false,
            toolbar: [{
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                },
                {
                    name: 'document',
                    items: ['Source']
                }
            ]
        });



        CKEDITOR.replace('aboutCompanyEditor', {
            height: 300,
            removePlugins: 'elementspath',
            resize_enabled: false,
            toolbar: [{
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                },
                {
                    name: 'document',
                    items: ['Source']
                }
            ]
        });
    </script>



    {!! NoCaptcha::renderJs() !!}

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS (for dropdowns) -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
</body>

</html>

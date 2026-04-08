@extends('layouts.app')

@section('title', $seo['title'])
@section('description', $seo['description'])

@section('content')
    {{-- PREMIUM HERO SECTION --}}
    <section class="premium-hero position-relative overflow-hidden">
        <div class="hero-bg-pattern"></div>
        <div class="hero-gradient"></div>
        <div class="hero-shape shape-1"></div>
        <div class="hero-shape shape-2"></div>
        <div class="hero-shape shape-3"></div>

        <div class="container position-relative" style="z-index: 10;">
            <div class="row min-vh-50 align-items-center py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="hero-badge-wrapper mb-4">
                        <span class="hero-badge">
                            <i class="bi bi-star-fill me-2"></i>
                            Our Story
                            <i class="bi bi-star-fill ms-2"></i>
                        </span>
                    </div>

                    <h1 class="hero-title display-3 fw-bold mb-4">
                        About <span class="text-gradient">AntApple</span>
                    </h1>

                    <p class="hero-subtitle lead mb-5 mx-auto" style="max-width: 700px;">
                        Connecting ambition with opportunity — building Africa's most trusted
                        platform for meaningful careers and exceptional talent.
                    </p>

                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number">10K+</span>
                            <span class="stat-label">Jobs Posted</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">5K+</span>
                            <span class="stat-label">Companies</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">50K+</span>
                            <span class="stat-label">Job Seekers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-scroll-indicator">
            <span>Scroll to discover</span>
            <i class="bi bi-arrow-down"></i>
        </div>
    </section>

    {{-- PREMIUM STORY SECTION --}}
    <section class="premium-story py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="story-badge mb-4">
                        <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill">
                            <i class="bi bi-clock-history me-2"></i>Our Journey
                        </span>
                    </div>

                    <h2 class="section-title fw-bold mb-4">
                        The Story Behind <span class="text-success">AntApple</span>
                    </h2>

                    <div class="story-content">
                        <p class="lead mb-4" style="color: #1e2937; font-weight: 500;">
                            We saw a gap in Nigeria's job market — and decided to fill it.
                        </p>

                        <p class="text-muted mb-4">
                            AntApple was born from a simple observation: job seekers were struggling
                            with outdated listings, poor filtering systems, and overwhelming platforms
                            that made finding the right opportunity feel impossible.
                        </p>

                        <p class="text-muted mb-4">
                            At the same time, employers faced the opposite challenge — reaching qualified
                            candidates felt like searching for a needle in a haystack. The connection
                            between talent and opportunity was broken.
                        </p>

                        <div class="story-quote p-4 rounded-4">
                            <i class="bi bi-quote fs-1 text-success opacity-50"></i>
                            <p class="mb-0 fst-italic">
                                We didn't just want to build another job board. We wanted to create
                                a platform that truly understands and serves both sides of the equation.
                            </p>
                            <div class="quote-author mt-3">
                                <strong>— The AntApple Team</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="story-image-wrapper">
                        <div class="image-glow"></div>
                        <div class="image-pattern"></div>
                        <img src="https://placehold.co/600x400/10b981/white?text=Our+Journey" alt="AntApple Journey"
                            class="story-image rounded-4 shadow-lg">

                        <div class="image-caption">
                            <span>Founded in 2024, Lagos, Nigeria</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PREMIUM MISSION & VISION CARDS --}}
    <section class="premium-mission-vision py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mission-card h-100">
                        <div class="card-icon">
                            <i class="bi bi-rocket-takeoff"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Our Mission</h3>
                        <p class="text-muted">
                            To simplify job search experiences and empower both job seekers
                            and employers with a transparent, efficient, and intelligent platform
                            that puts opportunity within everyone's reach.
                        </p>
                        <div class="mission-stats mt-4">
                            <div class="stat">
                                <span class="stat-value">10K+</span>
                                <span class="stat-label">Jobs Filled</span>
                            </div>
                            <div class="stat">
                                <span class="stat-value">98%</span>
                                <span class="stat-label">Satisfaction</span>
                            </div>
                        </div>
                        <div class="card-glow"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="vision-card h-100">
                        <div class="card-icon">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Our Vision</h3>
                        <p class="text-muted">
                            To become one of Africa's most trusted job platforms,
                            recognized for innovation, reliability, and creating meaningful
                            connections that transform careers and businesses across the continent.
                        </p>
                        <div class="vision-list mt-4">
                            <div class="list-item">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Leader in African job tech</span>
                            </div>
                            <div class="list-item">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>AI-powered matching</span>
                            </div>
                            <div class="list-item">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>1 million connections by 2026</span>
                            </div>
                        </div>
                        <div class="card-glow"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PREMIUM VALUES SECTION --}}
    <section class="premium-values py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                    <i class="bi bi-heart me-2"></i>What We Stand For
                </span>
                <h2 class="section-title fw-bold mb-3">Our Core Values</h2>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">
                    The principles that guide everything we do
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="value-icon integrity">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="fw-bold">Integrity</h4>
                        <p class="text-muted">
                            Transparent listings and trusted employers. We verify every company
                            to ensure authentic opportunities.
                        </p>
                        <div class="value-footer">
                            <span class="value-feature">✓ Verified companies only</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="value-icon simplicity">
                            <i class="bi bi-brush"></i>
                        </div>
                        <h4 class="fw-bold">Simplicity</h4>
                        <p class="text-muted">
                            Clean, intuitive, stress-free job search experience. No clutter,
                            no confusion — just opportunities.
                        </p>
                        <div class="value-footer">
                            <span class="value-feature">✓ One-click apply</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="value-icon opportunity">
                            <i class="bi bi-stars"></i>
                        </div>
                        <h4 class="fw-bold">Opportunity</h4>
                        <p class="text-muted">
                            Every job has the power to change a life. We're committed to
                            making opportunity accessible to all.
                        </p>
                        <div class="value-footer">
                            <span class="value-feature">✓ Equal access for all</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="value-icon growth">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h4 class="fw-bold">Growth</h4>
                        <p class="text-muted">
                            Continuous improvement and innovation. We're always evolving
                            to serve our community better.
                        </p>
                        <div class="value-footer">
                            <span class="value-feature">✓ Regular platform updates</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOUNDER SECTION --}}
    <section class="premium-team py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                    <i class="bi bi-person-badge me-2"></i>The Visionary
                </span>
                <h2 class="section-title fw-bold mb-3">Meet the Founder</h2>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">
                    Driven by a mission to bridge the gap in the African job market through innovative technology.
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="team-card text-center">
                        <div class="team-image-wrapper mx-auto">
                            <img src="{{ asset('images/Dave-Enyi.jpg') }}" alt="Dave - Founder" class="team-image">
                            <div class="team-social">
                                <a href="https://www.linkedin.com/in/david-enyi-631aa2109/" class="social-icon"><i
                                        class="bi bi-linkedin"></i></a>
                                <a href="https://x.com/dave_sleek1" class="social-icon"><i
                                        class="bi bi-twitter-x"></i></a>
                                <a href="https://github.com/Dave-Sleek" class="social-icon"><i
                                        class="bi bi-github"></i></a>
                            </div>
                        </div>
                        <h4 class="fw-bold mt-4 mb-1">Dave Enyi</h4>
                        <p class="text-success fw-semibold mb-2">Founder & Lead Developer</p>
                        <p class="text-muted px-3">
                            Full-stack architect with a passion for building scalable solutions and empowering the next
                            generation of African talent.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PREMIUM FUTURE SECTION --}}
    <section class="premium-future py-5 position-relative overflow-hidden">
        <div class="future-bg-pattern"></div>
        <div class="container position-relative" style="z-index: 10;">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="future-card">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <span class="badge bg-warning-subtle text-warning px-4 py-2 rounded-pill mb-3">
                                    <i class="bi bi-rocket me-2"></i>What's Next
                                </span>
                                <h3 class="fw-bold mb-3">Looking Ahead: The Future of AntApple</h3>
                                <p class="text-muted mb-4">
                                    We're building the next generation of job discovery with:
                                </p>

                                <div class="future-features">
                                    <div class="feature-item">
                                        <i class="bi bi-robot"></i>
                                        <div>
                                            <h6>AI-Powered Matching</h6>
                                            <p class="small text-muted">Intelligent job recommendations based on your
                                                skills and preferences</p>
                                        </div>
                                    </div>

                                    <div class="feature-item">
                                        <i class="bi bi-graph-up"></i>
                                        <div>
                                            <h6>Advanced Analytics</h6>
                                            <p class="small text-muted">Detailed insights for employers on applicant
                                                engagement</p>
                                        </div>
                                    </div>

                                    <div class="feature-item">
                                        <i class="bi bi-phone"></i>
                                        <div>
                                            <h6>Mobile Experience</h6>
                                            <p class="small text-muted">Native apps for iOS and Android coming soon</p>
                                        </div>
                                    </div>

                                    <div class="feature-item">
                                        <i class="bi bi-globe"></i>
                                        <div>
                                            <h6>Pan-African Expansion</h6>
                                            <p class="small text-muted">Taking AntApple across the continent</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <div class="future-stats">
                                    <div class="stat-circle">
                                        <span class="stat-number">2026</span>
                                        <span class="stat-label">Target Launch</span>
                                    </div>
                                    <div class="stat-circle">
                                        <span class="stat-number">10</span>
                                        <span class="stat-label">New Features</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="future-glow"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PREMIUM CTA SECTION --}}
    <section class="premium-cta py-5">
        <div class="container">
            <div class="cta-card text-center">
                <div class="cta-pattern"></div>
                <h2 class="fw-bold mb-3">Join the AntApple Community</h2>
                <p class="lead mb-4 mx-auto" style="max-width: 600px; color: rgba(255,255,255,0.9);">
                    Discover opportunities. Connect with employers. Build your future with Africa's fastest growing job
                    platform.
                </p>
                <div class="cta-buttons">
                    <a href="/jobs" class="btn-cta-primary">
                        <i class="bi bi-search me-2"></i>
                        Explore Jobs
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    <a href="{{ route('pricing') }}" class="btn-cta-secondary">
                        <i class="bi bi-building me-2"></i>
                        Post a Job
                    </a>
                </div>
                <div class="cta-stats mt-5">
                    <div class="stat">
                        <span class="stat-value">10K+</span>
                        <span class="stat-label">Jobs</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">5K+</span>
                        <span class="stat-label">Companies</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">50K+</span>
                        <span class="stat-label">Job Seekers</span>
                    </div>
                </div>
                <div class="cta-glow"></div>
            </div>
        </div>
    </section>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium About Page Styles */

    /* Hero Section */
    .premium-hero {
        min-height: 80vh;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        position: relative;
        display: flex;
        align-items: center;
    }

    .hero-gradient {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 30% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
    }

    .hero-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .hero-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        z-index: 1;
    }

    .shape-1 {
        width: 300px;
        height: 300px;
        background: rgba(16, 185, 129, 0.1);
        top: -100px;
        right: -100px;
    }

    .shape-2 {
        width: 200px;
        height: 200px;
        background: rgba(16, 185, 129, 0.15);
        bottom: -50px;
        left: -50px;
    }

    .shape-3 {
        width: 150px;
        height: 150px;
        background: rgba(16, 185, 129, 0.05);
        bottom: 50%;
        right: 20%;
    }

    .hero-badge-wrapper {
        animation: fadeInDown 1s ease;
    }

    .hero-badge {
        display: inline-block;
        padding: 12px 30px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 60px;
        color: #10b981;
        font-weight: 600;
        font-size: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .hero-title {
        animation: fadeInUp 1s ease 0.2s both;
        color: #1e2937;
    }

    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        animation: fadeInUp 1s ease 0.4s both;
        color: #475569;
    }

    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        animation: fadeInUp 1s ease 0.6s both;
    }

    .hero-stats .stat-item {
        text-align: center;
    }

    .hero-stats .stat-number {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        color: #10b981;
        line-height: 1.2;
    }

    .hero-stats .stat-label {
        font-size: 0.9rem;
        color: #64748b;
    }

    .hero-scroll-indicator {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        color: #64748b;
        font-size: 0.9rem;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateX(-50%) translateY(0);
        }

        40% {
            transform: translateX(-50%) translateY(-20px);
        }

        60% {
            transform: translateX(-50%) translateY(-10px);
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

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

    /* Story Section */
    .premium-story {
        padding: 80px 0;
    }

    .section-title {
        font-size: 2.5rem;
        color: #1e2937;
    }

    .story-content {
        position: relative;
    }

    .story-quote {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-left: 4px solid #10b981;
        margin-top: 2rem;
    }

    .story-image-wrapper {
        position: relative;
    }

    .story-image {
        width: 100%;
        height: auto;
        position: relative;
        z-index: 2;
    }

    .image-glow {
        position: absolute;
        top: -20px;
        left: -20px;
        right: -20px;
        bottom: -20px;
        background: radial-gradient(circle at 30% 50%, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
        filter: blur(30px);
        z-index: 1;
    }

    .image-pattern {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        opacity: 0.1;
        border-radius: 20px;
        z-index: 1;
    }

    .image-caption {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 40px;
        font-size: 0.85rem;
        color: #1e2937;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Mission & Vision Cards */
    .mission-card,
    .vision-card {
        background: white;
        border-radius: 28px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .mission-card:hover,
    .vision-card:hover {
        transform: translateY(-10px);
        border-color: #10b981;
        box-shadow: 0 30px 60px rgba(16, 185, 129, 0.15);
    }

    .mission-card .card-icon,
    .vision-card .card-icon {
        width: 70px;
        height: 70px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: white;
        margin-bottom: 1.5rem;
    }

    .mission-card .card-icon {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .vision-card .card-icon {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .mission-stats {
        display: flex;
        gap: 2rem;
    }

    .mission-stats .stat {
        text-align: center;
    }

    .mission-stats .stat-value {
        display: block;
        font-size: 1.8rem;
        font-weight: 700;
        color: #10b981;
    }

    .mission-stats .stat-label {
        font-size: 0.8rem;
        color: #64748b;
    }

    .vision-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .vision-list .list-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #475569;
    }

    .card-glow {
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .mission-card:hover .card-glow,
    .vision-card:hover .card-glow {
        opacity: 1;
    }

    /* Values Cards */
    .value-card {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        text-align: center;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .value-card:hover {
        transform: translateY(-8px);
        border-color: #10b981;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.1);
    }

    .value-icon {
        width: 70px;
        height: 70px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1.5rem;
    }

    .value-icon.integrity {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .value-icon.simplicity {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .value-icon.opportunity {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .value-icon.growth {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .value-footer {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }

    .value-feature {
        font-size: 0.85rem;
        color: #64748b;
    }

    /* Team Section */
    .team-card {
        text-align: center;
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .team-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.1);
    }

    .team-image-wrapper {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
    }

    .team-image {
        width: 100%;
        height: auto;
        transition: transform 0.3s ease;
    }

    .team-card:hover .team-image {
        transform: scale(1.05);
    }

    .team-social {
        position: absolute;
        bottom: -40px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 10px;
        transition: bottom 0.3s ease;
    }

    .team-card:hover .team-social {
        bottom: 20px;
    }

    .social-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: white;
        color: #10b981;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        background: #10b981;
        color: white;
        transform: translateY(-3px);
    }

    /* Future Section */
    .premium-future {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
    }

    .future-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M10 50 L50 10 L90 50 L50 90 Z' fill='none' stroke='%2310b981' stroke-width='1' opacity='0.05'/%3E%3C/svg%3E");
    }

    .future-card {
        background: white;
        border-radius: 32px;
        padding: 3rem;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.05);
    }

    .future-features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .feature-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .feature-item i {
        font-size: 1.8rem;
        color: #10b981;
    }

    .feature-item h6 {
        font-weight: 600;
        margin-bottom: 4px;
        color: #1e2937;
    }

    .future-stats {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .stat-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        margin: 0 auto;
    }

    .stat-circle .stat-number {
        font-size: 1.8rem;
        font-weight: 800;
        line-height: 1;
    }

    .stat-circle .stat-label {
        font-size: 0.8rem;
        opacity: 0.9;
    }

    .future-glow {
        position: absolute;
        bottom: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
        pointer-events: none;
    }

    /* CTA Section */
    .premium-cta {
        padding: 80px 0;
    }

    .cta-card {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 48px;
        padding: 4rem;
        position: relative;
        overflow: hidden;
        color: white;
        box-shadow: 0 30px 60px rgba(16, 185, 129, 0.3);
    }

    .cta-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='50' cy='50' r='40' fill='none' stroke='rgba(255,255,255,0.1)' stroke-width='1'/%3E%3C/svg%3E");
    }

    .cta-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .btn-cta-primary {
        padding: 16px 36px;
        background: white;
        color: #10b981;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 999;
    }

    .btn-cta-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .btn-cta-secondary {
        padding: 16px 36px;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        position: relative;
        z-index: 999;
    }

    .btn-cta-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .cta-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
    }

    .cta-stats .stat {
        text-align: center;
    }

    .cta-stats .stat-value {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        color: white;
    }

    .cta-stats .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .cta-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
        pointer-events: none;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-stats {
            flex-direction: column;
            gap: 1rem;
        }

        .future-features {
            grid-template-columns: 1fr;
        }

        .cta-buttons {
            flex-direction: column;
        }

        .cta-stats {
            flex-direction: column;
            gap: 1rem;
        }

        .section-title {
            font-size: 2rem;
        }
    }
</style>

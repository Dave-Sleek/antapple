@extends('layouts.app')

@section('title', 'Why Sproutplex - The Smarter Way to Find Your Dream Job')

@section('content')

    {{-- PREMIUM HERO SECTION --}}
    <section class="why-hero position-relative overflow-hidden">
        <div class="hero-bg-gradient"></div>
        <div class="hero-pattern"></div>
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>

        <div class="container position-relative" style="z-index: 10;">
            <div class="row min-vh-60 align-items-center py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="hero-badge mb-4 animate__animated animate__fadeInDown">
                        <span class="badge-premium">
                            <i class="bi bi-question-circle me-2"></i>
                            Why Choose Us
                            <i class="bi bi-question-circle ms-2"></i>
                        </span>
                    </div>

                    <h1 class="hero-title display-3 fw-bold mb-4 animate__animated animate__fadeInUp">
                        Why <span class="text-gradient">Sproutplex?</span>
                    </h1>

                    <p class="hero-subtitle lead mb-5 mx-auto animate__animated animate__fadeInUp animate__delay-1s"
                        style="max-width: 700px;">
                        Because finding the right opportunity shouldn't feel like solving a puzzle.
                        We've reimagined job discovery for the modern Nigerian professional.
                    </p>

                    <div class="hero-stats animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="stat-item">
                            <span class="stat-number">98%</span>
                            <span class="stat-label">Job Satisfaction</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">10K+</span>
                            <span class="stat-label">Successful Hires</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">24h</span>
                            <span class="stat-label">Response Time</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="scroll-indicator">
            <span>Discover the difference</span>
            <i class="bi bi-arrow-down"></i>
        </div>
    </section>

    {{-- PREMIUM INTRO SECTION --}}
    <section class="premium-intro py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="intro-card">
                        <div class="intro-quote-icon">
                            <i class="bi bi-quote"></i>
                        </div>
                        <p class="intro-text display-6 fw-medium mb-4" style="line-height: 1.4;">
                            Sproutplex is more than a job listing platform. We're building
                            a smarter ecosystem that connects job seekers with verified employers,
                            simplifies search experiences, and removes the frustration from job hunting.
                        </p>
                        <div class="intro-author">
                            <span class="author-name">— The Sproutplex Team</span>
                            <span class="author-title">Building Better Connections</span>
                        </div>
                        <div class="intro-pattern"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PREMIUM FEATURES SECTION --}}
    <section class="premium-features py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                    <i class="bi bi-stars me-2"></i>What Makes Us Different
                </span>
                <h2 class="section-title fw-bold mb-3">The Sproutplex Advantage</h2>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">
                    Four pillars that transform how you discover and land your next opportunity
                </p>
            </div>

            <div class="features-grid">
                {{-- Feature 1: Quality Over Quantity --}}
                <div class="feature-card premium-card">
                    <div class="feature-number">01</div>
                    <div class="feature-icon quality">
                        <i class="bi bi-gem"></i>
                    </div>
                    <h3 class="feature-title">Quality Over Quantity</h3>
                    <p class="feature-description">
                        We focus on relevant, active job postings. Expired roles are removed.
                        Verified employers are prioritized. We believe one real opportunity
                        is better than 100 outdated listings.
                    </p>
                    <div class="feature-stats">
                        <div class="stat">
                            <span class="stat-value">95%</span>
                            <span class="stat-label">Active Jobs</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">100%</span>
                            <span class="stat-label">Verified</span>
                        </div>
                    </div>
                    <div class="feature-glow"></div>
                </div>

                {{-- Feature 2: Built for Nigeria --}}
                <div class="feature-card premium-card">
                    <div class="feature-number">02</div>
                    <div class="feature-icon local">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h3 class="feature-title">Built for the Nigerian Market</h3>
                    <p class="feature-description">
                        Sproutplex understands local hiring trends, from Lagos to Abuja and emerging states.
                        We optimize for both physical and remote opportunities relevant to Nigerian professionals.
                    </p>
                    <div class="feature-locations">
                        <span class="location-badge">Lagos</span>
                        <span class="location-badge">Abuja</span>
                        <span class="location-badge">Port Harcourt</span>
                        <span class="location-badge">Remote</span>
                    </div>
                    <div class="feature-glow"></div>
                </div>

                {{-- Feature 3: Smart Filtering System --}}
                <div class="feature-card premium-card">
                    <div class="feature-number">03</div>
                    <div class="feature-icon smart">
                        <i class="bi bi-funnel"></i>
                    </div>
                    <h3 class="feature-title">Smart Filtering System</h3>
                    <p class="feature-description">
                        Our search system ensures users never face dead ends. If no result matches your filter,
                        we intelligently suggest alternative opportunities instead of showing empty pages.
                    </p>
                    <div class="filter-demo">
                        <div class="filter-row">
                            <span>Search: "Laravel Developer"</span>
                            <span class="filter-result">12 results</span>
                        </div>
                        <div class="filter-row">
                            <span>No results? →</span>
                            <span class="filter-suggestion">Try "PHP Developer"</span>
                        </div>
                    </div>
                    <div class="feature-glow"></div>
                </div>

                {{-- Feature 4: User-Focused Experience --}}
                <div class="feature-card premium-card">
                    <div class="feature-number">04</div>
                    <div class="feature-icon ux">
                        <i class="bi bi-phone"></i>
                    </div>
                    <h3 class="feature-title">User-Focused Experience</h3>
                    <p class="feature-description">
                        Fast loading speed, structured navigation, clean interface, and simplified job discovery —
                        because technology should reduce stress, not add to it.
                    </p>
                    <div class="ux-metrics">
                        <div class="metric">
                            <span class="metric-label">Page Load</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 98%"></div>
                            </div>
                            <span class="metric-value">0.8s</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">Satisfaction</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 96%"></div>
                            </div>
                            <span class="metric-value">96%</span>
                        </div>
                    </div>
                    <div class="feature-glow"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- PREMIUM TRUST SECTION --}}
    <section class="premium-trust py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="trust-badge mb-4">
                        <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill">
                            <i class="bi bi-shield-check me-2"></i>Built With Purpose
                        </span>
                    </div>

                    <h2 class="display-5 fw-bold mb-4">
                        A Platform Built <span class="text-success">With Purpose</span>
                    </h2>

                    <p class="lead mb-4" style="color: #1e2937;">
                        Every job posted represents growth. Every application represents hope.
                    </p>

                    <p class="text-muted mb-4">
                        We design Sproutplex with empathy, knowing that behind every click
                        is a real person seeking opportunity. Our platform is built on
                        principles of transparency, reliability, and genuine care for
                        both job seekers and employers.
                    </p>

                    <div class="trust-features">
                        <div class="trust-feature">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Verified job listings with employer screening</span>
                        </div>
                        <div class="trust-feature">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Clean job categorization for easy navigation</span>
                        </div>
                        <div class="trust-feature">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Reliable filtering that actually works</span>
                        </div>
                        <div class="trust-feature">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Structured job recommendations based on your profile</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="trust-showcase">
                        <div class="showcase-card card-1">
                            <i class="bi bi-building"></i>
                            <div>
                                <strong>500+</strong>
                                <span>Verified Employers</span>
                            </div>
                        </div>
                        <div class="showcase-card card-2">
                            <i class="bi bi-people"></i>
                            <div>
                                <strong>10K+</strong>
                                <span>Active Job Seekers</span>
                            </div>
                        </div>
                        <div class="showcase-card card-3">
                            <i class="bi bi-check-circle"></i>
                            <div>
                                <strong>98%</strong>
                                <span>Success Rate</span>
                            </div>
                        </div>
                        <div class="showcase-glow"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PREMIUM TESTIMONIAL SECTION --}}
    <section class="premium-testimonials py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                    <i class="bi bi-chat-quote me-2"></i>Success Stories
                </span>
                <h2 class="section-title fw-bold mb-3">What Our Users Say</h2>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">
                    Real experiences from job seekers and employers who found their match on Sproutplex
                </p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                    <p class="testimonial-text">
                        "I was tired of scrolling through outdated job posts on other platforms.
                        Sproutplex's filtering system actually works! I found my current role as a
                        Senior Developer within two weeks."
                    </p>
                    <div class="testimonial-author">
                        <img src="https://placehold.co/50x50/10b981/white?text=TC" alt="Author" class="author-image">
                        <div>
                            <strong>Tunde Coker</strong>
                            <span class="text-muted small">Software Developer</span>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card featured">
                    <div class="testimonial-rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                    <p class="testimonial-text">
                        "As an employer, Sproutplex has been a game-changer. We posted our job and
                        received qualified applications within hours. The verification process
                        ensures we only get serious candidates."
                    </p>
                    <div class="testimonial-author">
                        <img src="https://placehold.co/50x50/047857/white?text=AA" alt="Author" class="author-image">
                        <div>
                            <strong>Amara Anenih</strong>
                            <span class="text-muted small">HR Manager, TechCorp</span>
                        </div>
                    </div>
                    <div class="featured-badge">
                        <i class="bi bi-patch-check-fill"></i>
                        Verified Employer
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                    <p class="testimonial-text">
                        "The smart filtering system recommended a role I hadn't considered,
                        and it turned out to be perfect for my skills. Sproutplex understands
                        the Nigerian job market like no other platform."
                    </p>
                    <div class="testimonial-author">
                        <img src="https://placehold.co/50x50/10b981/white?text=KO" alt="Author" class="author-image">
                        <div>
                            <strong>Kemi Ogunleye</strong>
                            <span class="text-muted small">Marketing Specialist</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PREMIUM COMPARISON SECTION --}}
    <section class="premium-comparison py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                    <i class="bi bi-bar-chart me-2"></i>The Sproutplex Difference
                </span>
                <h2 class="section-title fw-bold mb-3">How We Compare</h2>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">
                    See why job seekers and employers choose Sproutplex over traditional platforms
                </p>
            </div>

            <div class="comparison-table-wrapper">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Features</th>
                            <th>Traditional Platforms</th>
                            <th class="highlight">Sproutplex</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Job Verification</td>
                            <td><i class="bi bi-x-circle-fill text-danger"></i> Limited</td>
                            <td><i class="bi bi-check-circle-fill text-success"></i> 100% Verified</td>
                        </tr>
                        <tr>
                            <td>Smart Filtering</td>
                            <td><i class="bi bi-x-circle-fill text-danger"></i> Basic Search</td>
                            <td><i class="bi bi-check-circle-fill text-success"></i> AI-Powered Suggestions</td>
                        </tr>
                        <tr>
                            <td>Local Market Focus</td>
                            <td><i class="bi bi-x-circle-fill text-danger"></i> Generic</td>
                            <td><i class="bi bi-check-circle-fill text-success"></i> Nigeria-Specific</td>
                        </tr>
                        <tr>
                            <td>Response Time</td>
                            <td><i class="bi bi-x-circle-fill text-danger"></i> 3-5 days</td>
                            <td><i class="bi bi-check-circle-fill text-success"></i> Within 24h</td>
                        </tr>
                        <tr>
                            <td>User Experience</td>
                            <td><i class="bi bi-x-circle-fill text-danger"></i> Cluttered</td>
                            <td><i class="bi bi-check-circle-fill text-success"></i> Clean & Intuitive</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- PREMIUM CTA SECTION --}}
    <section class="premium-why-cta py-5">
        <div class="container">
            <div class="cta-card text-center">
                <div class="cta-particles"></div>
                <h2 class="display-5 fw-bold mb-4">Ready to Experience the Sproutplex Difference?</h2>
                <p class="lead mb-5 mx-auto" style="max-width: 700px; color: rgba(255,255,255,0.9);">
                    Join thousands of job seekers and employers who've discovered a better way to connect.
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('jobs.index') }}" class="btn-cta-primary">
                        <i class="bi bi-search me-2"></i>
                        Browse Jobs
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    <a href="#" class="btn-cta-secondary">
                        <i class="bi bi-building me-2"></i>
                        Post a Job (Coming soon...)
                    </a>
                </div>
                <div class="cta-footer mt-5">
                    <span>No credit card required • Free job alerts • 24/7 support</span>
                </div>
                <div class="cta-glow"></div>
            </div>
        </div>
    </section>
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Why Sproutplex Styles */

    /* Hero Section */
    .why-hero {
        min-height: 80vh;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        position: relative;
        display: flex;
        align-items: center;
    }

    .hero-bg-gradient {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 30% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
    }

    .hero-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.05'%3E%3Cpath d='M50 50h30v30H50V50zm0-30h30v30H50V20zM20 50h30v30H20V50zm0-30h30v30H20V20z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .floating-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        z-index: 1;
        animation: float 6s ease-in-out infinite;
    }

    .shape-1 {
        width: 300px;
        height: 300px;
        background: rgba(16, 185, 129, 0.1);
        top: -100px;
        right: -100px;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 200px;
        height: 200px;
        background: rgba(16, 185, 129, 0.15);
        bottom: -50px;
        left: -50px;
        animation-delay: 2s;
    }

    .shape-3 {
        width: 150px;
        height: 150px;
        background: rgba(16, 185, 129, 0.05);
        top: 30%;
        right: 20%;
        animation-delay: 4s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) scale(1);
        }

        50% {
            transform: translateY(-20px) scale(1.05);
        }
    }

    .badge-premium {
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

    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
    }

    .hero-stats .stat-item {
        text-align: center;
    }

    .hero-stats .stat-number {
        display: block;
        font-size: 2.5rem;
        font-weight: 800;
        color: #10b981;
        line-height: 1.2;
    }

    .hero-stats .stat-label {
        font-size: 0.9rem;
        color: #64748b;
    }

    .scroll-indicator {
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

    /* Intro Section */
    .premium-intro {
        padding: 60px 0;
    }

    .intro-card {
        background: white;
        border-radius: 48px;
        padding: 3rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .intro-quote-icon {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 6rem;
        color: rgba(16, 185, 129, 0.1);
    }

    .intro-text {
        color: #1e2937;
        font-weight: 500;
        position: relative;
        z-index: 2;
    }

    .intro-author {
        position: relative;
        z-index: 2;
    }

    .author-name {
        display: block;
        font-weight: 700;
        color: #10b981;
        margin-bottom: 4px;
    }

    .author-title {
        color: #64748b;
        font-size: 0.9rem;
    }

    .intro-pattern {
        position: absolute;
        bottom: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    /* Features Section */
    .premium-features {
        padding: 80px 0;
    }

    .section-title {
        font-size: 2.5rem;
        color: #1e2937;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .feature-card {
        background: white;
        border-radius: 28px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        border-color: #10b981;
        box-shadow: 0 30px 60px rgba(16, 185, 129, 0.1);
    }

    .feature-number {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 3rem;
        font-weight: 800;
        color: rgba(16, 185, 129, 0.1);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin-bottom: 1.5rem;
    }

    .feature-icon.quality {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .feature-icon.local {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .feature-icon.smart {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .feature-icon.ux {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .feature-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #1e2937;
    }

    .feature-description {
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .feature-stats {
        display: flex;
        gap: 2rem;
    }

    .feature-stats .stat {
        text-align: center;
    }

    .feature-stats .stat-value {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: #10b981;
    }

    .feature-stats .stat-label {
        font-size: 0.8rem;
        color: #64748b;
    }

    .feature-locations {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .location-badge {
        padding: 4px 12px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 40px;
        font-size: 0.85rem;
    }

    .filter-demo {
        background: #f8fafc;
        border-radius: 16px;
        padding: 1rem;
    }

    .filter-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .filter-row:last-child {
        border-bottom: none;
    }

    .filter-result {
        color: #10b981;
        font-weight: 600;
    }

    .filter-suggestion {
        color: #f59e0b;
        font-weight: 600;
    }

    .ux-metrics {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .metric {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .metric-label {
        width: 100px;
        color: #64748b;
    }

    .progress-bar {
        flex: 1;
        height: 8px;
        background: #e2e8f0;
        border-radius: 100px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #10b981 0%, #047857 100%);
        border-radius: 100px;
    }

    .metric-value {
        width: 50px;
        font-weight: 600;
        color: #10b981;
    }

    .feature-glow {
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

    .feature-card:hover .feature-glow {
        opacity: 1;
    }

    /* Trust Section */
    .premium-trust {
        padding: 80px 0;
    }

    .trust-features {
        margin-top: 2rem;
    }

    .trust-feature {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.8rem 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .trust-feature:last-child {
        border-bottom: none;
    }

    .trust-feature i {
        font-size: 1.2rem;
    }

    .trust-showcase {
        position: relative;
        min-height: 400px;
    }

    .showcase-card {
        position: absolute;
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
        animation: float 4s ease-in-out infinite;
    }

    .showcase-card:hover {
        transform: translateY(-5px) scale(1.02);
        border-color: #10b981;
    }

    .showcase-card i {
        font-size: 2rem;
        color: #10b981;
    }

    .showcase-card strong {
        display: block;
        font-size: 1.5rem;
        color: #1e2937;
    }

    .card-1 {
        top: 0;
        left: 0;
        animation-delay: 0s;
    }

    .card-2 {
        top: 100px;
        right: 0;
        animation-delay: 1s;
    }

    .card-3 {
        bottom: 0;
        left: 50px;
        animation-delay: 2s;
    }

    .showcase-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(30px);
        z-index: -1;
    }

    /* Testimonials Section */
    .premium-testimonials {
        padding: 80px 0;
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .testimonial-card {
        background: white;
        border-radius: 28px;
        padding: 2rem;
        position: relative;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        border-color: #10b981;
        box-shadow: 0 30px 60px rgba(16, 185, 129, 0.1);
    }

    .testimonial-card.featured {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
    }

    .testimonial-card.featured .testimonial-text {
        color: rgba(255, 255, 255, 0.9);
    }

    .featured-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.2);
        padding: 4px 12px;
        border-radius: 40px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .testimonial-rating {
        margin-bottom: 1rem;
    }

    .testimonial-rating i {
        margin-right: 2px;
    }

    .testimonial-text {
        color: #475569;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .author-image {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        object-fit: cover;
    }

    /* Comparison Section */
    .premium-comparison {
        padding: 80px 0;
    }

    .comparison-table-wrapper {
        background: white;
        border-radius: 28px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow-x: auto;
    }

    .comparison-table {
        width: 100%;
        border-collapse: collapse;
    }

    .comparison-table th {
        padding: 1rem;
        font-weight: 600;
        color: #1e2937;
        border-bottom: 2px solid #e2e8f0;
    }

    .comparison-table th.highlight {
        color: #10b981;
        border-bottom-color: #10b981;
    }

    .comparison-table td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .comparison-table tr:last-child td {
        border-bottom: none;
    }

    .comparison-table i {
        margin-right: 4px;
    }

    /* CTA Section */
    .premium-why-cta {
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

    .cta-particles {
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

    .cta-footer {
        font-size: 0.9rem;
        opacity: 0.8;
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
    @media (max-width: 992px) {
        .features-grid {
            grid-template-columns: 1fr;
        }

        .testimonials-grid {
            grid-template-columns: 1fr;
        }

        .showcase-card {
            position: relative;
            margin-bottom: 1rem;
        }

        .trust-showcase {
            min-height: auto;
        }

        .cta-buttons {
            flex-direction: column;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-stats {
            flex-direction: column;
            gap: 1rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .comparison-table {
            font-size: 0.9rem;
        }
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/noframework.waypoints.min.js"></script>
<script>
    // Counter animation for stats
    function animateCounter(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = value + (element.dataset.suffix || '');
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Intersection Observer for counters
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counters = entry.target.querySelectorAll('.stat-number');
                counters.forEach(counter => {
                    const value = parseInt(counter.textContent);
                    animateCounter(counter, 0, value, 2000);
                });
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.5
    });

    document.querySelectorAll('.hero-stats, .feature-stats, .cta-stats').forEach(section => {
        observer.observe(section);
    });
</script>

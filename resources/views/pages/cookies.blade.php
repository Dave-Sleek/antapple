@extends('layouts.app')

@section('title', $seo['title'] ?? 'Cookies Policy - Sproutplex Jobs')
@section('description',
    $seo['description'] ??
    'Learn how Sproutplex Jobs uses cookies to enhance your browsing experience
    and personalize job recommendations.')

@section('content')
    <div class="cookies-hero py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <div class="hero-badge mb-4">
                        <span class="badge bg-warning-subtle text-warning px-4 py-2 rounded-pill">
                            <i class="bi bi-cookie me-2"></i>COOKIES POLICY
                        </span>
                    </div>
                    <h1 class="display-4 fw-bold mb-3">Cookies <span class="text-gradient">Policy</span></h1>
                    <p class="lead text-muted mb-4">How we use cookies to improve your job discovery experience</p>
                    <div class="last-updated">
                        <i class="bi bi-calendar-check me-2"></i>
                        Last updated: {{ date('F d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cookies-content py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    {{-- Cookie Consent Reminder --}}
                    <div class="consent-reminder mb-5">
                        <i class="bi bi-info-circle"></i>
                        <p class="mb-0">By continuing to use Sproutplex Jobs, you consent to our use of cookies as
                            described
                            in this policy.</p>
                    </div>

                    {{-- What Are Cookies --}}
                    <div class="cookies-card">
                        <div class="card-icon">
                            <i class="bi bi-question-circle"></i>
                        </div>
                        <h2>1. What Are Cookies?</h2>
                        <p>Cookies are small text files stored on your device when you visit a website. They act as memory
                            tokens, helping websites recognize you and remember your preferences. Think of them as a cookie
                            jar that stores little notes about your visit to make future experiences smoother.</p>

                        <div class="cookie-analogy">
                            <i class="bi bi-emoji-smile"></i>
                            <span>Like a friendly waiter who remembers your usual order, cookies help us serve you
                                better.</span>
                        </div>
                    </div>

                    {{-- How We Use Cookies --}}
                    <div class="cookies-card">
                        <div class="card-icon">
                            <i class="bi bi-gear"></i>
                        </div>
                        <h2>2. How We Use Cookies</h2>
                        <div class="use-grid">
                            <div class="use-item">
                                <i class="bi bi-sliders2"></i>
                                <h6>Remember Preferences</h6>
                                <p class="small">Your location filters, remote job toggles, and search settings</p>
                            </div>
                            <div class="use-item">
                                <i class="bi bi-bar-chart"></i>
                                <h6>Analytics</h6>
                                <p class="small">Understanding which jobs interest you most</p>
                            </div>
                            <div class="use-item">
                                <i class="bi bi-rocket"></i>
                                <h6>Performance</h6>
                                <p class="small">Optimizing site speed and functionality</p>
                            </div>
                        </div>
                    </div>

                    {{-- Types of Cookies --}}
                    <div class="cookies-card">
                        <div class="card-icon">
                            <i class="bi bi-tags"></i>
                        </div>
                        <h2>3. Types of Cookies We Use</h2>

                        <div class="cookie-types">
                            <div class="type-item essential">
                                <div class="type-header">
                                    <i class="bi bi-shield-check"></i>
                                    <h6>Essential Cookies</h6>
                                    <span class="badge ms-auto">Always Active</span>
                                </div>
                                <p class="small text-muted">Required for basic site functionality. Cannot be disabled.</p>
                                <ul class="type-details">
                                    <li>Session management</li>
                                    <li>Security tokens</li>
                                    <li>User authentication</li>
                                </ul>
                            </div>

                            <div class="type-item analytics">
                                <div class="type-header">
                                    <i class="bi bi-graph-up"></i>
                                    <h6>Analytics Cookies</h6>
                                    <span class="badge ms-auto">Optional</span>
                                </div>
                                <p class="small text-muted">Help us understand how visitors interact with our site.</p>
                                <ul class="type-details">
                                    <li>Page visit tracking</li>
                                    <li>Click patterns</li>
                                    <li>Feature usage</li>
                                </ul>
                            </div>

                            <div class="type-item preference">
                                <div class="type-header">
                                    <i class="bi bi-star"></i>
                                    <h6>Preference Cookies</h6>
                                    <span class="badge ms-auto">Optional</span>
                                </div>
                                <p class="small text-muted">Remember your settings and choices.</p>
                                <ul class="type-details">
                                    <li>Job filters</li>
                                    <li>Location preferences</li>
                                    <li>View settings</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Cookie Management --}}
                    <div class="cookies-card">
                        <div class="card-icon">
                            <i class="bi bi-gear-wide-connected"></i>
                        </div>
                        <h2>4. Managing Cookies</h2>
                        <p>You can control cookies through your browser settings. Here's how:</p>

                        <div class="browser-guide">
                            <div class="browser-item">
                                <i class="bi bi-chrome"></i>
                                <span>Chrome: Settings → Privacy → Cookies</span>
                            </div>
                            <div class="browser-item">
                                <i class="bi bi-firefox"></i>
                                <span>Firefox: Options → Privacy → Cookies</span>
                            </div>
                            <div class="browser-item">
                                <i class="bi bi-safari"></i>
                                <span>Safari: Preferences → Privacy → Cookies</span>
                            </div>
                            <div class="browser-item">
                                <i class="bi bi-edge"></i>
                                <span>Edge: Settings → Cookies</span>
                            </div>
                        </div>

                        <div class="warning-note">
                            <i class="bi bi-exclamation-triangle"></i>
                            <span>Disabling cookies may affect some site features, such as saving your job filters.</span>
                        </div>
                    </div>

                    {{-- Updates --}}
                    <div class="cookies-card">
                        <div class="card-icon">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h2>5. Changes to This Policy</h2>
                        <p>We may update this Cookies Policy to reflect changes in technology or regulations. We'll notify
                            you of significant changes through a site notice or email. Your continued use of Sproutplex Jobs
                            after updates constitutes acceptance.</p>
                    </div>

                    {{-- Contact --}}
                    <div class="contact-card">
                        <i class="bi bi-cookie"></i>
                        <div>
                            <h5 class="fw-bold mb-2">Questions About Cookies?</h5>
                            <p class="mb-0">We're happy to explain our cookie usage in more detail.</p>
                        </div>
                        <a href="mailto:privacy@Sproutplex.com" class="btn-contact">Ask Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .cookies-hero {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border-bottom: 1px solid rgba(245, 158, 11, 0.1);
    }

    .text-gradient {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .consent-reminder {
        background: #f1f5f9;
        border-radius: 60px;
        padding: 1rem 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border-left: 4px solid #f59e0b;
    }

    .cookies-card {
        background: white;
        border-radius: 28px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .cookies-card:hover {
        border-color: #f59e0b;
        box-shadow: 0 30px 60px rgba(245, 158, 11, 0.1);
    }

    .card-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }

    .cookie-analogy {
        background: #fef3c7;
        padding: 1rem 2rem;
        border-radius: 60px;
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .use-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .use-item {
        text-align: center;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 20px;
    }

    .use-item i {
        font-size: 2rem;
        color: #f59e0b;
        margin-bottom: 1rem;
    }

    .cookie-types {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .type-item {
        padding: 1.5rem;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
    }

    .type-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .type-header i {
        font-size: 1.5rem;
    }

    .essential .type-header i {
        color: #3b82f6;
    }

    .analytics .type-header i {
        color: #10b981;
    }

    .preference .type-header i {
        color: #8b5cf6;
    }

    .type-details {
        list-style: none;
        padding: 0;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .type-details li {
        background: #f1f5f9;
        padding: 4px 12px;
        border-radius: 40px;
        font-size: 0.85rem;
        color: #475569;
    }

    .browser-guide {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .browser-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 16px;
    }

    .browser-item i {
        font-size: 1.5rem;
        color: #f59e0b;
    }

    .warning-note {
        background: #fee2e2;
        border-radius: 16px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #b91c1c;
    }

    @media (max-width: 768px) {
        .use-grid {
            grid-template-columns: 1fr;
        }

        .browser-guide {
            grid-template-columns: 1fr;
        }
    }
</style>

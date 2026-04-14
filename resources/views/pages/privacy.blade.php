@extends('layouts.app')

@section('title', $seo['title'] ?? 'Privacy Policy - Sproutplex Jobs')
@section('description',
    $seo['description'] ??
    'Learn how Sproutplex Jobs protects your privacy and handles your personal
    information with the highest standards of security and transparency.')

@section('content')
    <div class="privacy-hero py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="hero-badge mb-4">
                        <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill">
                            <i class="bi bi-shield-lock me-2"></i>PRIVACY & SECURITY
                        </span>
                    </div>
                    <h1 class="display-4 fw-bold mb-3">Privacy <span class="text-gradient">Policy</span></h1>
                    <p class="lead text-muted mb-4">Your trust is our foundation. Learn how we protect and handle your
                        information.</p>
                    <div class="last-updated">
                        <i class="bi bi-calendar-check me-2"></i>
                        Last updated: {{ date('F d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="privacy-content py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    {{-- Executive Summary --}}
                    <div class="summary-card mb-5">
                        <div class="summary-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="summary-text">
                            <h5>Our Promise to You</h5>
                            <p class="mb-0">We collect only what's necessary, never sell your data, and maintain
                                transparent practices. Your privacy is protected by design.</p>
                        </div>
                    </div>

                    {{-- Main Content --}}
                    <div class="policy-sections">

                        {{-- Section 1 --}}
                        <div class="policy-section">
                            <div class="section-header">
                                <span class="section-number">1</span>
                                <h2>Information We Collect</h2>
                            </div>
                            <div class="section-content">
                                <p class="section-intro">To provide you with the best job discovery experience, we collect
                                    the following information:</p>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <i class="bi bi-envelope"></i>
                                        <h6>Email Address</h6>
                                        <p>When you subscribe to job alerts or create an account</p>
                                    </div>
                                    <div class="info-item">
                                        <i class="bi bi-bar-chart"></i>
                                        <h6>Usage Data</h6>
                                        <p>Pages visited, clicks, and job preferences</p>
                                    </div>
                                    <div class="info-item">
                                        <i class="bi bi-phone"></i>
                                        <h6>Device Information</h6>
                                        <p>Browser type, device type, and analytics data</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2 --}}
                        <div class="policy-section">
                            <div class="section-header">
                                <span class="section-number">2</span>
                                <h2>How We Use Your Information</h2>
                            </div>
                            <div class="section-content">
                                <div class="use-cases">
                                    <div class="use-case">
                                        <div class="use-icon">
                                            <i class="bi bi-bell"></i>
                                        </div>
                                        <div>
                                            <h6>Send Job Alerts</h6>
                                            <p class="text-muted">Personalized notifications for matching opportunities</p>
                                        </div>
                                    </div>
                                    <div class="use-case">
                                        <div class="use-icon">
                                            <i class="bi bi-graph-up"></i>
                                        </div>
                                        <div>
                                            <h6>Platform Improvement</h6>
                                            <p class="text-muted">Analyze usage patterns to enhance user experience</p>
                                        </div>
                                    </div>
                                    <div class="use-case">
                                        <div class="use-icon">
                                            <i class="bi bi-shield"></i>
                                        </div>
                                        <div>
                                            <h6>Security & Fraud Prevention</h6>
                                            <p class="text-muted">Detect and prevent spam, abuse, and unauthorized access
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 3 - What We DON'T Do --}}
                        <div class="policy-section highlight-section">
                            <div class="section-header">
                                <span class="section-number">3</span>
                                <h2>What We Do NOT Do</h2>
                            </div>
                            <div class="section-content">
                                <div class="dont-list">
                                    <div class="dont-item">
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                        <span>Sell your personal data to third parties</span>
                                    </div>
                                    <div class="dont-item">
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                        <span>Post jobs on behalf of companies</span>
                                    </div>
                                    <div class="dont-item">
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                        <span>Redirect you to suspicious or non-official websites</span>
                                    </div>
                                    <div class="dont-item">
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                        <span>Share your information without consent</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 4 --}}
                        <div class="policy-section">
                            <div class="section-header">
                                <span class="section-number">4</span>
                                <h2>Third-Party Links</h2>
                            </div>
                            <div class="section-content">
                                <p>Sproutplex Jobs links only to official company career pages. We carefully review each
                                    destination to ensure legitimacy. However, we are not responsible for the privacy
                                    practices of external websites. We recommend reviewing their policies before submitting
                                    applications.</p>
                            </div>
                        </div>

                        {{-- Section 5 --}}
                        <div class="policy-section">
                            <div class="section-header">
                                <span class="section-number">5</span>
                                <h2>Data Security</h2>
                            </div>
                            <div class="section-content">
                                <p>We implement industry-standard security measures including:</p>
                                <div class="security-badges">
                                    <span class="badge-security"><i class="bi bi-lock"></i> SSL Encryption</span>
                                    <span class="badge-security"><i class="bi bi-shield-check"></i> Regular Security
                                        Audits</span>
                                    <span class="badge-security"><i class="bi bi-key"></i> Secure Data Storage</span>
                                </div>
                                <p class="mt-3 small text-muted">While we take every precaution, no method of transmission
                                    over the internet is 100% secure.</p>
                            </div>
                        </div>

                        {{-- Section 6 --}}
                        <div class="policy-section">
                            <div class="section-header">
                                <span class="section-number">6</span>
                                <h2>Your Rights</h2>
                            </div>
                            <div class="section-content">
                                <p>You have the right to:</p>
                                <ul class="rights-list">
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Access your personal data</li>
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Request correction of
                                        inaccurate information</li>
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Request deletion of your data
                                    </li>
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Opt-out of communications</li>
                                </ul>
                                <p class="mt-3">To exercise these rights, contact us at <a
                                        href="mailto:support@Sproutplex.com" class="text-success">support@Sproutplex.com</a>
                                </p>
                            </div>
                        </div>

                        {{-- Section 7 --}}
                        <div class="policy-section">
                            <div class="section-header">
                                <span class="section-number">7</span>
                                <h2>Changes to This Policy</h2>
                            </div>
                            <div class="section-content">
                                <p>We may update this Privacy Policy to reflect changes in our practices or legal
                                    requirements. Continued use of the site after updates constitutes acceptance of the
                                    revised policy. We'll notify you of significant changes via email or site notice.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Card --}}
                    <div class="contact-card mt-5">
                        <i class="bi bi-envelope-paper"></i>
                        <div>
                            <h5 class="fw-bold mb-2">Have Privacy Questions?</h5>
                            <p class="mb-0">Our Data Protection Officer is ready to assist you.</p>
                        </div>
                        <a href="mailto:privacy@Sproutplex.com" class="btn-contact">Contact DPO</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .privacy-hero {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .last-updated {
        display: inline-block;
        padding: 8px 20px;
        background: white;
        border-radius: 60px;
        color: #64748b;
        font-size: 0.9rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
        border: 1px solid #e2e8f0;
    }

    .summary-card {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-radius: 24px;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .summary-icon i {
        font-size: 3rem;
        color: #10b981;
    }

    .summary-text h5 {
        color: #047857;
        margin-bottom: 8px;
    }

    .policy-section {
        margin-bottom: 3rem;
        padding: 2rem;
        background: white;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .policy-section:hover {
        border-color: #10b981;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.05);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .section-number {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .section-header h2 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
        color: #1e2937;
    }

    .highlight-section {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border-color: rgba(239, 68, 68, 0.2);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .info-item {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .info-item i {
        font-size: 2rem;
        color: #10b981;
        margin-bottom: 1rem;
    }

    .use-cases {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .use-case {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 16px;
    }

    .use-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.4rem;
    }

    .dont-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .dont-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: white;
        border-radius: 16px;
        border: 1px solid #fee2e2;
    }

    .security-badges {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin: 1.5rem 0;
    }

    .badge-security {
        padding: 8px 20px;
        background: #f1f5f9;
        border-radius: 40px;
        font-size: 0.9rem;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .rights-list {
        list-style: none;
        padding: 0;
    }

    .rights-list li {
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .contact-card {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 24px;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        color: white;
    }

    .contact-card i {
        font-size: 3rem;
    }

    .btn-contact {
        margin-left: auto;
        padding: 12px 32px;
        background: white;
        color: #10b981;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-contact:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .contact-card {
            flex-direction: column;
            text-align: center;
        }

        .btn-contact {
            margin-left: 0;
        }
    }
</style>

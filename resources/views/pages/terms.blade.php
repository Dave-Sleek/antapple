@extends('layouts.app')

@section('title', $seo['title'] ?? 'Terms of Use - Sproutplex Jobs')
@section('description',
    $seo['description'] ??
    'Review the terms and conditions for using Sproutplex Jobs platform.
    Understand your rights and responsibilities as a user.')

@section('content')
    <div class="terms-hero py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="hero-badge mb-4">
                        <span class="badge bg-primary-subtle text-primary px-4 py-2 rounded-pill">
                            <i class="bi bi-file-text me-2"></i>TERMS OF USE
                        </span>
                    </div>
                    <h1 class="display-4 fw-bold mb-3">Terms of <span class="text-gradient">Use</span></h1>
                    <p class="lead text-muted mb-4">Please read these terms carefully before using Sproutplex Jobs</p>
                    <div class="last-updated">
                        <i class="bi bi-calendar-check me-2"></i>
                        Last updated: {{ date('F d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="terms-content py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    {{-- Acceptance Card --}}
                    <div class="acceptance-card mb-5">
                        <i class="bi bi-hand-index-thumb"></i>
                        <div>
                            <h5 class="fw-bold mb-2">By using Sproutplex Jobs, you agree to these Terms</h5>
                            <p class="mb-0 text-muted">If you do not agree with any part of these terms, please discontinue
                                use of our platform.</p>
                        </div>
                    </div>

                    {{-- Terms Accordion --}}
                    <div class="terms-accordion">

                        {{-- Term 1 --}}
                        <div class="term-item">
                            <input type="checkbox" id="term1" class="term-toggle">
                            <label for="term1" class="term-header">
                                <span class="term-number">1</span>
                                <h3>Nature of the Platform</h3>
                                <i class="bi bi-chevron-down"></i>
                            </label>
                            <div class="term-content">
                                <p>Sproutplex Jobs is a job aggregation platform. We:</p>
                                <ul>
                                    <li>List job opportunities from various sources</li>
                                    <li>Link users directly to official company career pages</li>
                                    <li>Do NOT act as recruiters or employment agencies</li>
                                    <li>Do NOT guarantee employment or job placement</li>
                                </ul>
                                <div class="term-note">
                                    <i class="bi bi-info-circle"></i>
                                    <span>We're here to connect you with opportunities, not to secure employment on your
                                        behalf.</span>
                                </div>
                            </div>
                        </div>

                        {{-- Term 2 --}}
                        <div class="term-item">
                            <input type="checkbox" id="term2" class="term-toggle">
                            <label for="term2" class="term-header">
                                <span class="term-number">2</span>
                                <h3>User Responsibilities</h3>
                                <i class="bi bi-chevron-down"></i>
                            </label>
                            <div class="term-content">
                                <p>As a user of Sproutplex Jobs, you agree to:</p>
                                <div class="responsibilities-grid">
                                    <div class="resp-item">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span>Use the platform for lawful purposes only</span>
                                    </div>
                                    <div class="resp-item">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span>Provide accurate information when applying</span>
                                    </div>
                                    <div class="resp-item">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span>Respect intellectual property rights</span>
                                    </div>
                                    <div class="resp-item prohibited">
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                        <span>Do NOT attempt to scrape or exploit the system</span>
                                    </div>
                                    <div class="resp-item prohibited">
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                        <span>Do NOT submit false reports or misleading information</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Term 3 --}}
                        <div class="term-item">
                            <input type="checkbox" id="term3" class="term-toggle">
                            <label for="term3" class="term-header">
                                <span class="term-number">3</span>
                                <h3>Job Listings</h3>
                                <i class="bi bi-chevron-down"></i>
                            </label>
                            <div class="term-content">
                                <p>Regarding job postings on our platform:</p>
                                <div class="listing-info">
                                    <div class="info-box">
                                        <h6>We Strive To:</h6>
                                        <ul>
                                            <li>Verify employer legitimacy</li>
                                            <li>Remove outdated listings</li>
                                            <li>Provide accurate information</li>
                                        </ul>
                                    </div>
                                    <div class="info-box warning">
                                        <h6>However:</h6>
                                        <ul>
                                            <li>We cannot guarantee every listing's accuracy</li>
                                            <li>Users should perform their own due diligence</li>
                                            <li>We're not responsible for external application processes</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Term 4 --}}
                        <div class="term-item">
                            <input type="checkbox" id="term4" class="term-toggle">
                            <label for="term4" class="term-header">
                                <span class="term-number">4</span>
                                <h3>Intellectual Property</h3>
                                <i class="bi bi-chevron-down"></i>
                            </label>
                            <div class="term-content">
                                <p>All content on Sproutplex Jobs (excluding third-party job listings) is owned by us and
                                    protected by copyright laws. This includes:</p>
                                <ul>
                                    <li>Website design and layout</li>
                                    <li>Logo and branding elements</li>
                                    <li>Original written content</li>
                                    <li>Platform code and functionality</li>
                                </ul>
                                <p class="mt-3">You may not reproduce, distribute, or modify our content without explicit
                                    permission.</p>
                            </div>
                        </div>

                        {{-- Term 5 --}}
                        <div class="term-item">
                            <input type="checkbox" id="term5" class="term-toggle">
                            <label for="term5" class="term-header">
                                <span class="term-number">5</span>
                                <h3>Limitation of Liability</h3>
                                <i class="bi bi-chevron-down"></i>
                            </label>
                            <div class="term-content">
                                <p>To the maximum extent permitted by law, Sproutplex Jobs shall not be liable for:</p>
                                <ul>
                                    <li>Any loss or damage from job applications</li>
                                    <li>Disputes between users and employers</li>
                                    <li>Issues with external websites</li>
                                    <li>Indirect or consequential damages</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Term 6 --}}
                        <div class="term-item">
                            <input type="checkbox" id="term6" class="term-toggle">
                            <label for="term6" class="term-header">
                                <span class="term-number">6</span>
                                <h3>Termination</h3>
                                <i class="bi bi-chevron-down"></i>
                            </label>
                            <div class="term-content">
                                <p>We reserve the right to:</p>
                                <ul>
                                    <li>Suspend or terminate accounts that violate these terms</li>
                                    <li>Remove content that breaches our policies</li>
                                    <li>Block users who engage in abusive behavior</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Agreement Footer --}}
                    <div class="agreement-footer mt-5">
                        <p class="text-muted text-center">By continuing to use Sproutplex Jobs, you acknowledge that you
                            have
                            read, understood, and agree to these Terms of Use.</p>
                        <div class="footer-actions">
                            <a href="{{ route('jobs.index') }}" class="btn-agree">
                                <i class="bi bi-check-circle me-2"></i>
                                I Agree & Continue
                            </a>
                            <a href="mailto:hello@sproutplex.com" class="btn-contact">Contact Support</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .terms-hero {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
    }

    .text-gradient {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .acceptance-card {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-radius: 24px;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        border: 1px solid rgba(37, 99, 235, 0.2);
    }

    .acceptance-card i {
        font-size: 3rem;
        color: #3b82f6;
    }

    .terms-accordion {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .term-item {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .term-item:hover {
        border-color: #3b82f6;
    }

    .term-toggle {
        display: none;
    }

    .term-header {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        background: #f8fafc;
        transition: all 0.3s ease;
    }

    .term-header:hover {
        background: #f1f5f9;
    }

    .term-number {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .term-header h3 {
        flex: 1;
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
    }

    .term-header i {
        transition: transform 0.3s ease;
    }

    .term-toggle:checked~.term-header i {
        transform: rotate(180deg);
    }

    .term-content {
        max-height: 0;
        padding: 0 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
    }

    .term-toggle:checked~.term-content {
        max-height: 500px;
        padding: 1.5rem;
    }

    .term-note {
        background: #f1f5f9;
        padding: 1rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .responsibilities-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .resp-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 16px;
    }

    .resp-item.prohibited {
        background: #fee2e2;
    }

    .listing-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .info-box {
        padding: 1.5rem;
        border-radius: 20px;
        background: #f0fdf4;
    }

    .info-box.warning {
        background: #fef3c7;
    }

    .agreement-footer {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
    }

    .footer-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 1.5rem;
    }

    .btn-agree {
        padding: 12px 36px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-agree:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
    }

    @media (max-width: 768px) {
        .responsibilities-grid {
            grid-template-columns: 1fr;
        }

        .listing-info {
            grid-template-columns: 1fr;
        }

        .footer-actions {
            flex-direction: column;
        }
    }
</style>

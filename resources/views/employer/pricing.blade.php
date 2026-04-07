@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Premium Header Section --}}
        <div class="text-center mb-5">
            <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">PRICING PLANS</span>
            <h1 class="display-4 fw-bold mb-3" style="color: #1e2937;">Choose Your <span class="text-success">Success
                    Path</span></h1>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">
                Unlock premium features and get your job postings in front of thousands of qualified candidates
            </p>
            <div class="d-flex align-items-center justify-content-center gap-3 mt-4">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-2 rounded-circle">
                        <i class="bi bi-check-lg text-success"></i>
                    </div>
                    <span class="ms-2 text-muted">Cancel anytime</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-2 rounded-circle">
                        <i class="bi bi-check-lg text-success"></i>
                    </div>
                    <span class="ms-2 text-muted">14-day money back</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-2 rounded-circle">
                        <i class="bi bi-check-lg text-success"></i>
                    </div>
                    <span class="ms-2 text-muted">24/7 support</span>
                </div>
            </div>
        </div>

        {{-- Current subscription alert with premium styling --}}
        @if (auth()->check() && optional(auth()->user())->subscription)
            <div class="alert alert-success border-0 shadow-sm mb-5"
                style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="d-flex align-items-center">
                        <div class="bg-white p-3 rounded-circle shadow-sm me-3">
                            <i class="bi bi-gem text-success fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Your Current Subscription</h5>
                            <p class="mb-0">
                                <strong
                                    class="text-success">{{ optional(auth()->user()->subscription->plan)->name ?? 'N/A' }}</strong>
                                •
                                Valid until
                                <strong>{{ \Carbon\Carbon::parse(optional(auth()->user()->subscription)->ends_at)->format('d M Y') }}</strong>
                            </p>
                        </div>
                    </div>
                    <a href="#upgrade" class="btn btn-success px-5 py-2 rounded-pill">Upgrade Plan</a>
                </div>
            </div>
        @endif

        {{-- Premium Pricing Cards --}}
        <div class="row justify-content-center g-4">
            @foreach ($plans as $index => $plan)
                <div class="col-md-6 col-lg-4">
                    <div class="premium-pricing-card h-100 {{ $index === 1 ? 'premium-popular' : '' }}">
                        @if ($index === 1)
                            <div class="popular-badge">
                                <span>Most Popular</span>
                                <i class="bi bi-star-fill ms-1"></i>
                            </div>
                        @endif

                        <div class="card-header">
                            <h4 class="plan-name">{{ $plan->name }}</h4>
                            <div class="plan-price">
                                <span class="currency">₦</span>
                                <span class="amount">{{ number_format($plan->price, 0) }}</span>
                                <span class="period">/{{ $plan->billing_cycle ?? 'month' }}</span>
                            </div>
                            <p class="plan-description">{!! $plan->description ?? 'Perfect for growing businesses' !!}</p>
                        </div>

                        <div class="card-body">
                            {{-- Premium Features List --}}
                            <div class="features-list">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="bi bi-briefcase-fill"></i>
                                    </div>
                                    <div class="feature-details">
                                        <span class="feature-label">Job Postings</span>
                                        <span class="feature-value">{{ $plan->job_limit ?? 0 }} jobs</span>
                                    </div>
                                </div>

                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <div class="feature-details">
                                        <span class="feature-label">Featured Jobs</span>
                                        <span class="feature-value">{{ $plan->featured_limit ?? 0 }} featured</span>
                                    </div>
                                </div>

                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div class="feature-details">
                                        <span class="feature-label">Applicant Tracking</span>
                                        @if ($plan->can_view_applicants)
                                            <span class="feature-value text-success">Unlimited access</span>
                                        @else
                                            <span class="feature-value text-muted">Not included</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div class="feature-details">
                                        <span class="feature-label">Job Duration</span>
                                        <span class="feature-value">30 days</span>
                                    </div>
                                </div>

                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="bi bi-bar-chart-line"></i>
                                    </div>
                                    <div class="feature-details">
                                        <span class="feature-label">Analytics</span>
                                        @if ($index >= 1)
                                            <span class="feature-value">Basic insights</span>
                                        @else
                                            <span class="feature-value text-muted">Not included</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="bi bi-headset"></i>
                                    </div>
                                    <div class="feature-details">
                                        <span class="feature-label">Support</span>
                                        @if ($index === 2)
                                            <span class="feature-value">Priority 24/7</span>
                                        @elseif ($index === 1)
                                            <span class="feature-value">Email support</span>
                                        @else
                                            <span class="feature-value">Basic support</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Additional premium features based on plan --}}
                                @if ($index >= 1)
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="feature-details">
                                            <span class="feature-label">Company Branding</span>
                                            <span class="feature-value">
                                                @if ($index === 2)
                                                    Premium profile
                                                @elseif ($index === 1)
                                                    Enhanced profile
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if ($index === 2)
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="bi bi-award"></i>
                                        </div>
                                        <div class="feature-details">
                                            <span class="feature-label">Verified Badge</span>
                                            <span class="feature-value text-success">
                                                <i class="bi bi-patch-check-fill"></i> Included
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Savings Badge for Annual --}}
                            @if ($plan->billing_cycle === 'yearly' || $index === 2)
                                <div class="savings-badge">
                                    <span>Save 20% with annual billing</span>
                                </div>
                            @endif

                            {{-- CTA Button --}}
                            @if (auth()->check())
                                <form method="POST" action="{{ route('subscribe', $plan->id) }}" class="mt-4">
                                    @csrf
                                    <button class="btn-subscribe w-100" type="submit">
                                        @if (optional(auth()->user())->subscription && optional(auth()->user()->subscription)->plan_id !== $plan->id)
                                            <span>Switch to {{ $plan->name }}</span>
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        @elseif(optional(auth()->user())->subscription && optional(auth()->user()->subscription)->plan_id === $plan->id)
                                            <span>Current Plan</span>
                                            <i class="bi bi-check-lg ms-2"></i>
                                        @else
                                            <span>Get Started</span>
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        @endif
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn-subscribe w-100 text-center">
                                    <span>Login to Subscribe</span>
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Premium FAQ Section --}}
        <div class="premium-faq mt-5">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Frequently Asked Questions</h3>
                <p class="text-muted">Everything you need to know about our pricing</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="faq-item">
                        <h5><i class="bi bi-question-circle text-success me-2"></i> Can I switch plans anytime?</h5>
                        <p class="text-muted">Yes, you can upgrade or downgrade your plan at any time. Changes will be
                            reflected in your next billing cycle.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="faq-item">
                        <h5><i class="bi bi-question-circle text-success me-2"></i> What payment methods do you accept?
                        </h5>
                        <p class="text-muted">We accept all major credit cards, Paystack transfers, and bank transfers for
                            annual plans.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="faq-item">
                        <h5><i class="bi bi-question-circle text-success me-2"></i> Is there a refund policy?</h5>
                        <p class="text-muted">We offer a 14-day money-back guarantee if you're not satisfied with our
                            service.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="faq-item">
                        <h5><i class="bi bi-question-circle text-success me-2"></i> What happens to my jobs after
                            subscription ends?</h5>
                        <p class="text-muted">Your active jobs will remain visible until their expiry date, but you won't
                            be able to post new ones.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Premium Comparison Callout --}}
        <div class="premium-callout mt-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="fw-bold mb-2">Need a custom plan for your business?</h4>
                    <p class="mb-md-0 text-muted">Contact our sales team for enterprise solutions and bulk discounts</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="/contact" class="btn btn-outline-success rounded-pill px-5 py-2">
                        Contact Sales
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Pricing Page Styles - N1.4 Million Edition */
    .premium-pricing-card {
        background: white;
        border-radius: 24px;
        padding: 2rem 1.5rem;
        position: relative;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }

    .premium-pricing-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #10b981, #047857);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .premium-pricing-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 60px rgba(16, 185, 129, 0.15);
        border-color: transparent;
    }

    .premium-pricing-card:hover::before {
        opacity: 1;
    }

    .premium-popular {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border: 2px solid #10b981;
        box-shadow: 0 25px 50px rgba(16, 185, 129, 0.2);
        transform: scale(1.02);
    }

    .premium-popular:hover {
        transform: scale(1.02) translateY(-8px);
    }

    .popular-badge {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 8px 24px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        z-index: 10;
        white-space: nowrap;
    }

    .card-header {
        text-align: left;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        background: transparent;
    }

    .plan-name {
        color: #1e2937;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        letter-spacing: -0.5px;
    }

    .plan-price {
        margin-bottom: 1rem;
        display: flex;
        align-items: baseline;
        justify-content: center;
        gap: 4px;
    }

    .currency {
        font-size: 1.5rem;
        font-weight: 600;
        color: #10b981;
        align-self: flex-start;
        margin-top: 8px;
    }

    .amount {
        font-size: 4rem;
        font-weight: 800;
        color: #1e2937;
        line-height: 1;
        letter-spacing: -2px;
    }

    .period {
        font-size: 1rem;
        color: #6b7280;
        align-self: flex-end;
        margin-bottom: 8px;
    }

    .plan-description {
        color: #64748b;
        font-size: 0.95rem;
        max-width: 250px;
        margin: 0 auto;
    }

    .features-list {
        margin: 1.5rem 0;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 12px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(4, 120, 87, 0.05) 100%);
    }

    .feature-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.2);
    }

    .feature-details {
        flex: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .feature-label {
        color: #475569;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .feature-value {
        font-weight: 700;
        color: #1e2937;
        font-size: 0.95rem;
    }

    .feature-value.text-success {
        color: #10b981;
    }

    .savings-badge {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #047857;
        text-align: center;
        padding: 12px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.9rem;
        margin: 1.5rem 0;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .btn-subscribe {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        padding: 16px 24px;
        border-radius: 60px;
        font-weight: 600;
        font-size: 1rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-subscribe:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .btn-subscribe:active {
        transform: translateY(0);
    }

    .premium-faq {
        background: #f8fafc;
        border-radius: 32px;
        padding: 3rem;
        margin-top: 4rem;
    }

    .faq-item {
        padding: 1.5rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
        height: 100%;
    }

    .faq-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.1);
    }

    .faq-item h5 {
        color: #1e2937;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .faq-item p {
        margin-bottom: 0;
        line-height: 1.6;
    }

    .premium-callout {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 24px;
        padding: 2.5rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        margin-top: 3rem;
    }

    /* Animation for cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .premium-pricing-card {
        animation: fadeInUp 0.6s ease forwards;
    }

    .premium-pricing-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .premium-pricing-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .premium-pricing-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .premium-popular {
            transform: scale(1);
        }

        .premium-popular:hover {
            transform: translateY(-8px);
        }

        .amount {
            font-size: 3rem;
        }

        .premium-faq {
            padding: 2rem;
        }

        .feature-details {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }
    }
</style>

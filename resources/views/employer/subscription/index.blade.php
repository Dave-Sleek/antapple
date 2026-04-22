@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Premium Header --}}
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                    <i class="bi bi-gear-fill me-2"></i>ACCOUNT SETTINGS
                </span>
                <h1 class="display-5 fw-bold mb-2" style="color: #1e2937;">Subscription <span
                        class="text-success">Management</span></h1>
                <p class="text-muted lead" style="max-width: 600px;">Manage your plan, billing details, and subscription
                    preferences</p>
            </div>
            <div class="d-none d-md-block">
            </div>
        </div>

        @if ($subscription && $subscription->status === 'active')
            {{-- Premium Active Subscription Card --}}
            <div class="premium-subscription-card">
                {{-- Decorative Elements --}}
                <div class="decorative-circle circle-1"></div>
                <div class="decorative-circle circle-2"></div>

                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-start gap-4">
                            {{-- Plan Icon --}}
                            <div class="plan-icon-wrapper">
                                <div class="plan-icon">
                                    <i class="bi bi-gem"></i>
                                </div>
                                <div class="plan-icon-glow"></div>
                            </div>

                            {{-- Plan Details --}}
                            <div class="plan-details flex-grow-1">
                                <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                                    <h2 class="fw-bold mb-0">{{ $subscription->plan->name }}</h2>
                                    <span class="status-badge active">
                                        <span class="status-dot"></span>
                                        Active
                                    </span>
                                    @if ($subscription->plan->is_popular ?? false)
                                        <span class="popular-badge">
                                            <i class="bi bi-star-fill me-1"></i>Most Popular
                                        </span>
                                    @endif
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <div class="plan-metric">
                                            <span class="metric-label">Monthly Price</span>
                                            <span
                                                class="metric-value">₦{{ number_format($subscription->plan->price, 0) }}</span>
                                            <span
                                                class="metric-period">/{{ $subscription->plan->billing_cycle ?? 'month' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="plan-metric">
                                            <span class="metric-label">Billing Cycle</span>
                                            <span
                                                class="metric-value">{{ ucfirst($subscription->plan->billing_cycle ?? 'Monthly') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="plan-metric">
                                            <span class="metric-label">Next Billing</span>
                                            <span
                                                class="metric-value">{{ \Carbon\Carbon::parse($subscription->ends_at)->format('d M, Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Progress Bar --}}
                                @php
                                    $start = \Carbon\Carbon::parse($subscription->starts_at ?? now()->subMonth());
                                    $end = \Carbon\Carbon::parse($subscription->ends_at);
                                    $now = now();
                                    $totalDays = $start->diffInDays($end);
                                    $daysLeft = $now->diffInDays($end);
                                    $percentUsed = $totalDays > 0 ? (($totalDays - $daysLeft) / $totalDays) * 100 : 0;
                                @endphp
                                <div class="progress-wrapper mt-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="progress-label">Billing Cycle Progress</span>
                                        <span class="progress-value">{{ round($daysLeft) }} days remaining</span>
                                    </div>
                                    <div class="progress premium-progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $percentUsed }}%; background: linear-gradient(90deg, #10b981, #047857);"
                                            aria-valuenow="{{ $percentUsed }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="action-buttons">
                            <a href="{{ route('pricing') }}" class="btn-upgrade">
                                <span class="btn-text">Upgrade Plan</span>
                                <i class="bi bi-arrow-up-short"></i>
                                <div class="btn-glow"></div>
                            </a>

                            <div class="dropdown mt-3">
                                <button class="btn-more" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                    More Options
                                </button>
                                <ul class="dropdown-menu premium-dropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('billing') }}">
                                            <i class="bi bi-clock-history me-2"></i>Billing History
                                        </a>
                                    </li>
                                    @if ($subscription && $subscription->status === 'active')
                                        <li>
                                            <form method="POST" action="{{ route('subscription.renew') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-arrow-clockwise me-2"></i>Renew Subscription
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bi bi-credit-card me-2"></i>Update Payment Method
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('invoice.download', $subscription) }}">
                                            <i class="bi bi-file-text me-2"></i>Download Invoice
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#">
                                            <i class="bi bi-x-circle me-2"></i>Cancel Subscription
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Plan Features --}}
                <div class="plan-features-section mt-5">
                    <h5 class="fw-bold mb-4">Your Plan Includes</h5>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="feature-card">
                                <div class="feature-icon-wrapper">
                                    <i class="bi bi-briefcase-fill"></i>
                                </div>
                                <div>
                                    <span class="feature-label">Job Postings</span>
                                    <span class="feature-value">{{ $subscription->plan->job_limit ?? 'Unlimited' }}
                                        jobs/month</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card">
                                <div class="feature-icon-wrapper">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div>
                                    <span class="feature-label">Featured Jobs</span>
                                    <span class="feature-value">{{ $subscription->plan->featured_limit ?? 0 }}
                                        featured</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card">
                                <div class="feature-icon-wrapper">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div>
                                    <span class="feature-label">Applicant Tracking</span>
                                    <span
                                        class="feature-value">{{ $subscription->plan->can_view_applicants ? 'Unlimited' : 'Not included' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="recent-activity-card mt-5">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-bold mb-0">Recent Activity</h5>
                    <a href="#" class="view-all-link">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="activity-timeline">
                    <div class="activity-item">
                        <div class="activity-dot bg-success"></div>
                        <div class="activity-content">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold">Subscription Renewed</span>
                                <span
                                    class="activity-time">{{ \Carbon\Carbon::parse($subscription->updated_at)->diffForHumans() }}</span>
                            </div>
                            <p class="text-muted small mb-0">Your {{ $subscription->plan->name }} plan has been renewed
                                successfully</p>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-dot bg-info"></div>
                        <div class="activity-content">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold">Payment Processed</span>
                                <span
                                    class="activity-time">{{ \Carbon\Carbon::parse($subscription->updated_at)->subDays(28)->diffForHumans() }}</span>
                            </div>
                            <p class="text-muted small mb-0">₦{{ number_format($subscription->plan->price, 0) }} was
                                charged to your account</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Premium Empty State --}}
            <div class="premium-empty-state">
                <div class="empty-state-glow"></div>
                <div class="empty-state-icon">
                    <i class="bi bi-gem"></i>
                </div>
                <h2 class="fw-bold mb-3">No Active Subscription</h2>
                <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">
                    You don't have an active subscription yet. Choose a plan to start posting jobs and reaching thousands of
                    qualified candidates.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('pricing') }}" class="btn-choose-plan">
                        <span>Choose a Plan</span>
                        <i class="bi bi-arrow-right ms-2"></i>
                        <div class="btn-glow"></div>
                    </a>
                    <a href="#" class="btn-learn-more">
                        <i class="bi bi-play-circle me-2"></i>
                        Learn More
                    </a>
                </div>

                {{-- Plan Comparison Preview --}}
                <div class="plan-preview mt-5">
                    <h5 class="fw-bold mb-4">Popular Plans</h5>
                    <div class="row g-4">
                        @foreach (App\Models\Plan::take(3)->get() as $plan)
                            <div class="col-md-4">
                                <div class="preview-plan-card">
                                    <h6 class="fw-bold mb-2">{{ $plan->name }}</h6>
                                    <div class="preview-price mb-3">
                                        <span class="fw-bold text-success">₦{{ number_format($plan->price, 0) }}</span>
                                        <span class="text-muted small">/{{ $plan->billing_cycle ?? 'month' }}</span>
                                    </div>
                                    <ul class="list-unstyled small">
                                        <li><i
                                                class="bi bi-check-circle-fill text-success me-2"></i>{{ $plan->job_limit ?? 0 }}
                                            Jobs</li>
                                        <li><i
                                                class="bi bi-check-circle-fill text-success me-2"></i>{{ $plan->featured_limit ?? 0 }}
                                            Featured</li>
                                    </ul>
                                    <a href="{{ route('pricing') }}" class="stretched-link"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Need Help Section --}}
        <div class="need-help-card mt-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-4">
                        <div class="help-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Need Help With Your Subscription?</h5>
                            <p class="text-muted mb-0">Our support team is available 24/7 to assist you with billing,
                                upgrades, or any questions</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('contact') }}" class="btn-contact-support">
                        Contact Support
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Subscription Management Styles */

    /* Main Card */
    .premium-subscription-card {
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
        border-radius: 32px;
        padding: 3rem;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.03);
    }

    .decorative-circle {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(4, 120, 87, 0.05) 100%);
    }

    .circle-1 {
        width: 300px;
        height: 300px;
        top: -150px;
        right: -150px;
    }

    .circle-2 {
        width: 200px;
        height: 200px;
        bottom: -100px;
        left: -100px;
    }

    /* Plan Icon */
    .plan-icon-wrapper {
        position: relative;
    }

    .plan-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        position: relative;
        z-index: 2;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }

    .plan-icon-glow {
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, transparent 70%);
        filter: blur(15px);
        opacity: 0.5;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 0.5;
            transform: scale(1);
        }

        50% {
            opacity: 0.8;
            transform: scale(1.1);
        }
    }

    /* Status Badge */
    .status-badge {
        padding: 8px 16px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .status-badge.active {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #047857;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        display: inline-block;
        animation: blink 2s infinite;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.3;
        }
    }

    .popular-badge {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
    }

    /* Plan Metrics */
    .plan-metric {
        background: white;
        padding: 1.2rem;
        border-radius: 20px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
    }

    .plan-metric:hover {
        transform: translateY(-2px);
        border-color: #10b981;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.1);
    }

    .metric-label {
        display: block;
        color: #6b7280;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .metric-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e2937;
    }

    .metric-period {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 400;
    }

    /* Progress Bar */
    .progress-wrapper {
        background: #f8fafc;
        padding: 1.2rem;
        border-radius: 20px;
    }

    .progress-label {
        color: #475569;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .progress-value {
        color: #10b981;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .premium-progress {
        height: 8px;
        border-radius: 100px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .premium-progress .progress-bar {
        border-radius: 100px;
        transition: width 1s ease;
    }

    /* Action Buttons */
    .action-buttons {
        background: white;
        padding: 2rem;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .btn-upgrade {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        padding: 16px 32px;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        border: none;
    }

    .btn-upgrade:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-upgrade:active {
        transform: translateY(0);
    }

    .btn-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .btn-upgrade:hover .btn-glow {
        opacity: 1;
    }

    .btn-more {
        background: none;
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #475569;
        padding: 12px 24px;
        border-radius: 60px;
        width: 100%;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-more:hover {
        background: rgba(16, 185, 129, 0.05);
        border-color: #10b981;
        color: #10b981;
    }

    /* Premium Dropdown */
    .premium-dropdown {
        border: none;
        border-radius: 20px;
        padding: 12px 8px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        min-width: 240px;
    }

    .premium-dropdown .dropdown-item {
        padding: 12px 20px;
        border-radius: 12px;
        margin: 4px 8px;
        color: #374151;
        transition: all 0.3s ease;
    }

    .premium-dropdown .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(4, 120, 87, 0.05) 100%);
        color: #10b981;
        transform: translateX(5px);
    }

    /* Feature Cards */
    .feature-card {
        background: white;
        padding: 1.5rem;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .feature-card:hover {
        transform: translateY(-2px);
        border-color: #10b981;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.1);
    }

    .feature-icon-wrapper {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .feature-label {
        display: block;
        color: #6b7280;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .feature-value {
        font-weight: 700;
        color: #1e2937;
        font-size: 1.1rem;
    }

    /* Activity Timeline */
    .recent-activity-card {
        background: white;
        border-radius: 32px;
        padding: 2rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .view-all-link {
        color: #10b981;
        text-decoration: none;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 60px;
        transition: all 0.3s ease;
    }

    .view-all-link:hover {
        background: rgba(16, 185, 129, 0.1);
        color: #047857;
    }

    .activity-timeline {
        position: relative;
        padding-left: 2rem;
    }

    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, #10b981 0%, #047857 100%);
        opacity: 0.2;
    }

    .activity-item {
        position: relative;
        margin-bottom: 2rem;
        display: flex;
        gap: 1rem;
    }

    .activity-dot {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        position: absolute;
        left: -2rem;
        top: 4px;
        border: 3px solid white;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
    }

    .activity-dot.bg-success {
        background: #10b981;
    }

    .activity-dot.bg-info {
        background: #3b82f6;
    }

    .activity-content {
        flex: 1;
        background: #f8fafc;
        padding: 1rem;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .activity-content:hover {
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .activity-time {
        color: #94a3b8;
        font-size: 0.8rem;
    }

    /* Empty State */
    .premium-empty-state {
        text-align: center;
        padding: 5rem 3rem;
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
        border-radius: 48px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .empty-state-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .empty-state-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: white;
        margin: 0 auto 2rem;
        position: relative;
        z-index: 2;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
    }

    .btn-choose-plan {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        padding: 16px 40px;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }

    .btn-choose-plan:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-learn-more {
        color: #475569;
        text-decoration: none;
        padding: 16px 32px;
        border-radius: 60px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-learn-more:hover {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    /* Plan Preview Cards */
    .preview-plan-card {
        background: white;
        padding: 1.5rem;
        border-radius: 20px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .preview-plan-card:hover {
        transform: translateY(-2px);
        border-color: #10b981;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.1);
    }

    .preview-price {
        color: #10b981;
        font-size: 1.3rem;
    }

    .preview-plan-card ul {
        padding-left: 0;
    }

    .preview-plan-card ul li {
        margin-bottom: 8px;
        color: #475569;
    }

    /* Need Help Card */
    .need-help-card {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 32px;
        padding: 2.5rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
    }

    .need-help-card:hover {
        border-color: #10b981;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.05);
    }

    .help-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-contact-support {
        background: white;
        color: #10b981;
        padding: 14px 32px;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        border: 1px solid rgba(16, 185, 129, 0.2);
        transition: all 0.3s ease;
    }

    .btn-contact-support:hover {
        background: #10b981;
        color: white;
        border-color: transparent;
        transform: translateX(5px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .premium-subscription-card {
            padding: 2rem;
        }

        .plan-icon {
            width: 60px;
            height: 60px;
            font-size: 2rem;
        }

        .action-buttons {
            margin-top: 2rem;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            font-size: 2.5rem;
        }
    }
</style>

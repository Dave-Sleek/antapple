@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-5 px-4">

        {{-- Premium Header --}}
        <div class="user-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                            <div class="header-icon-ring"></div>
                        </div>
                        <div>
                            <span class="badge bg-primary-subtle text-primary px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-shield-lock me-2"></i>USER MANAGEMENT
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">User <span
                                    class="text-gradient">Details</span></h1>
                            <p class="text-muted lead mb-0">View and manage user information, jobs, and subscriptions</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-actions">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-edit">
                            <i class="bi bi-pencil me-2"></i>
                            Edit User
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn-back">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to Users
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Left Column --}}
            <div class="col-lg-4">

                {{-- Profile Card --}}
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                            @else
                                <span class="avatar-initials">
                                    {{ collect(explode(' ', $user->name))->map(function ($part) {return strtoupper(substr($part, 0, 1));})->take(2)->join('') }}
                                </span>
                            @endif
                            <span class="avatar-status {{ $user->is_online ?? false ? 'online' : 'offline' }}"></span>
                        </div>
                        <div class="profile-info">
                            <h3 class="profile-name">{{ $user->name }}</h3>
                            <p class="profile-email">{{ $user->email }}</p>
                            <div class="profile-badge">
                                @php
                                    $roleColors = [
                                        'admin' => 'danger',
                                        'employer' => 'success',
                                        'seeker' => 'info',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $roleColors[$user->role] ?? 'secondary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-calendar"></i> Joined {{ $user->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="profile-stats">
                        <div class="stat-item">
                            <i class="bi bi-briefcase"></i>
                            <div>
                                <span class="stat-value">{{ $user->jobs->count() }}</span>
                                <span class="stat-label">Jobs Posted</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <i class="bi bi-people"></i>
                            <div>
                                <span class="stat-value">{{ $user->applications_count ?? 0 }}</span>
                                <span class="stat-label">Applications</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <i class="bi bi-eye"></i>
                            <div>
                                <span class="stat-value">{{ $user->profile_views ?? 0 }}</span>
                                <span class="stat-label">Profile Views</span>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Info --}}
                    <div class="profile-contact">
                        <h6 class="section-title">Contact Information</h6>
                        <div class="contact-item">
                            <i class="bi bi-envelope"></i>
                            <div>
                                <span class="contact-label">Email</span>
                                <span class="contact-value">{{ $user->email }}</span>
                            </div>
                        </div>
                        @if ($user->phone)
                            <div class="contact-item">
                                <i class="bi bi-telephone"></i>
                                <div>
                                    <span class="contact-label">Phone</span>
                                    <span class="contact-value">{{ $user->phone }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($user->location)
                            <div class="contact-item">
                                <i class="bi bi-geo-alt"></i>
                                <div>
                                    <span class="contact-label">Location</span>
                                    <span class="contact-value">{{ $user->location }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-lg-8">

                {{-- Company Info Card (for employers) --}}
                @if ($user->role === 'employer' && ($user->company_name || $user->about_company))
                    <div class="info-card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-building"></i>
                                <h5 class="fw-bold mb-0">Company Information</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($user->company_logo)
                                <div class="company-logo mb-3">
                                    <img src="{{ asset('storage/' . $user->company_logo) }}" alt="Company Logo">
                                </div>
                            @endif
                            @if ($user->company_name)
                                <div class="info-row">
                                    <span class="info-label">Company Name</span>
                                    <span class="info-value">{{ $user->company_name }}</span>
                                </div>
                            @endif
                            @if ($user->about_company)
                                <div class="info-row">
                                    <span class="info-label">About Company</span>
                                    <p class="info-value">{{ $user->about_company }}</p>
                                </div>
                            @endif
                            @if ($user->website)
                                <div class="info-row">
                                    <span class="info-label">Website</span>
                                    <a href="{{ $user->website }}" target="_blank"
                                        class="info-link">{{ $user->website }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Subscription Card --}}
                <div class="info-card mb-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-credit-card"></i>
                            <h5 class="fw-bold mb-0">Subscription Details</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($user->subscription)
                            @php
                                $subscription = $user->subscription;
                                $expiresAt = $subscription->ends_at ?? ($subscription->expires_at ?? null);
                                $isExpired = $expiresAt ? \Carbon\Carbon::parse($expiresAt)->isPast() : false;
                                $daysLeft = $expiresAt ? now()->diffInDays($expiresAt, false) : null;
                            @endphp

                            <div class="subscription-status {{ $isExpired ? 'expired' : 'active' }}">
                                <div class="status-icon">
                                    <i class="bi bi-{{ $isExpired ? 'x-circle' : 'check-circle' }}"></i>
                                </div>
                                <div class="status-text">
                                    <span class="status-label">Subscription Status</span>
                                    <span
                                        class="status-value">{{ $isExpired ? 'Expired' : ucfirst($subscription->status) }}</span>
                                </div>
                            </div>

                            <div class="info-grid">
                                <div class="info-row">
                                    <span class="info-label">Plan Name</span>
                                    <span class="info-value highlight">{{ $subscription->plan->name ?? 'N/A' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Billing Cycle</span>
                                    <span
                                        class="info-value">{{ ucfirst($subscription->plan->billing_cycle ?? 'N/A') }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Price</span>
                                    <span
                                        class="info-value">₦{{ number_format($subscription->plan->price ?? 0, 0) }}</span>
                                </div>
                                @if ($expiresAt)
                                    <div class="info-row">
                                        <span class="info-label">Expires On</span>
                                        <span
                                            class="info-value">{{ \Carbon\Carbon::parse($expiresAt)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Time Left</span>
                                        <div class="time-left">
                                            @if ($isExpired)
                                                <span class="badge-expired">Expired</span>
                                            @elseif ($daysLeft <= 3)
                                                <span class="badge-warning">{{ $daysLeft }} day(s) left ⚠️</span>
                                            @else
                                                <span class="badge-active">{{ $daysLeft }} day(s) left</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if ($subscription->plan->job_limit)
                                @php
                                    $jobsUsed = $user->jobs->count();
                                    $jobLimit = $subscription->plan->job_limit;
                                    $percentage = ($jobsUsed / $jobLimit) * 100;
                                @endphp
                                <div class="usage-stats">
                                    <div class="usage-header">
                                        <span>Job Usage</span>
                                        <span>{{ $jobsUsed }} / {{ $jobLimit }} jobs</span>
                                    </div>
                                    <div class="progress-bar-container">
                                        <div class="progress-fill"
                                            style="width: {{ min($percentage, 100) }}%; background: linear-gradient(90deg, #10b981, #047857);">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="empty-subscription">
                                <div class="empty-icon">
                                    <i class="bi bi-credit-card"></i>
                                </div>
                                <p class="empty-text">No active subscription</p>
                                <p class="empty-subtext">This user hasn't subscribed to any plan yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Jobs Posted Card --}}
                <div class="info-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-briefcase"></i>
                            <h5 class="fw-bold mb-0">Jobs Posted</h5>
                            <span class="job-count">{{ $user->jobs->count() }}</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if ($user->jobs->count())
                            <div class="jobs-list">
                                @foreach ($user->jobs as $job)
                                    <div class="job-item">
                                        <div class="job-info">
                                            <div class="job-icon">
                                                <i class="bi bi-file-text"></i>
                                            </div>
                                            <div>
                                                <div class="job-title">{{ $job->title }}</div>
                                                <div class="job-meta">
                                                    <span><i class="bi bi-geo-alt"></i> {{ $job->location }}</span>
                                                    <span><i class="bi bi-clock"></i>
                                                        {{ $job->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="job-status">
                                            @if ($job->status == 'active')
                                                <span class="badge-status approved">Active</span>
                                            @elseif($job->status == 'pending')
                                                <span class="badge-status pending">Pending</span>
                                            @else
                                                <span class="badge-status inactive">{{ ucfirst($job->status) }}</span>
                                            @endif
                                            @if ($job->is_featured)
                                                <span class="featured-tag">
                                                    <i class="bi bi-star-fill"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-jobs">
                                <div class="empty-icon">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <p class="empty-text">No jobs posted</p>
                                <p class="empty-subtext">This user hasn't posted any jobs yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Activity Timeline --}}
                <div class="info-card mt-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-clock-history"></i>
                            <h5 class="fw-bold mb-0">Recent Activity</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="activity-timeline">
                            <div class="activity-item">
                                <div class="activity-dot bg-success"></div>
                                <div class="activity-content">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-semibold">Account Created</span>
                                        <span class="activity-time">{{ $user->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-muted small mb-0">User joined the platform</p>
                                </div>
                            </div>
                            @if ($user->jobs->count())
                                <div class="activity-item">
                                    <div class="activity-dot bg-primary"></div>
                                    <div class="activity-content">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-semibold">First Job Posted</span>
                                            <span
                                                class="activity-time">{{ $user->jobs->first()->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-muted small mb-0">Posted "{{ $user->jobs->first()->title }}"</p>
                                    </div>
                                </div>
                            @endif
                            @if ($user->subscription)
                                <div class="activity-item">
                                    <div class="activity-dot bg-warning"></div>
                                    <div class="activity-content">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-semibold">Subscription Activated</span>
                                            <span
                                                class="activity-time">{{ $user->subscription->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-muted small mb-0">Subscribed to
                                            {{ $user->subscription->plan->name ?? 'plan' }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($user->last_login_at)
                                <div class="activity-item">
                                    <div class="activity-dot bg-info"></div>
                                    <div class="activity-content">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-semibold">Last Login</span>
                                            <span
                                                class="activity-time">{{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-muted small mb-0">From IP {{ $user->last_login_ip ?? 'Unknown' }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium User Details Styles */

    /* Header */
    .user-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 32px;
        padding: 2rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .header-icon-wrapper {
        position: relative;
    }

    .header-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: white;
        position: relative;
        z-index: 2;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }

    .header-icon-glow {
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, transparent 70%);
        filter: blur(15px);
        opacity: 0.5;
        animation: pulse 2s infinite;
        z-index: 1;
    }

    .header-icon-ring {
        position: absolute;
        top: -15px;
        left: -15px;
        right: -15px;
        bottom: -15px;
        border: 2px solid rgba(16, 185, 129, 0.2);
        border-radius: 32px;
        animation: ring 3s infinite;
        z-index: 1;
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

    @keyframes ring {
        0% {
            transform: scale(1);
            opacity: 0.5;
        }

        50% {
            transform: scale(1.2);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 0.5;
        }
    }

    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .header-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-edit,
    .btn-back {
        padding: 12px 24px;
        border-radius: 60px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .btn-edit {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .btn-back {
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .btn-back:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateX(-5px);
    }

    /* Profile Card */
    .profile-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .profile-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 2rem;
        text-align: center;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .profile-avatar {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 1rem;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 30px;
        border: 4px solid white;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .avatar-initials {
        width: 100%;
        height: 100%;
        border-radius: 30px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        border: 4px solid white;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .avatar-status {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 3px solid white;
    }

    .avatar-status.online {
        background: #10b981;
        animation: blink 1.5s infinite;
    }

    .avatar-status.offline {
        background: #94a3b8;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e2937;
        margin-bottom: 0.25rem;
    }

    .profile-email {
        color: #64748b;
        margin-bottom: 0.75rem;
    }

    .profile-badge {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Profile Stats */
    .profile-stats {
        display: flex;
        justify-content: space-around;
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-align: left;
    }

    .stat-item i {
        font-size: 1.5rem;
        color: #10b981;
    }

    .stat-value {
        display: block;
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e2937;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #64748b;
    }

    /* Contact Info */
    .profile-contact {
        padding: 1.5rem;
    }

    .section-title {
        font-weight: 700;
        margin-bottom: 1rem;
        color: #1e2937;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-item i {
        width: 40px;
        height: 40px;
        background: #f8fafc;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        font-size: 1.2rem;
    }

    .contact-label {
        display: block;
        font-size: 0.7rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .contact-value {
        font-weight: 500;
        color: #1e2937;
    }

    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .info-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .info-card .card-header i {
        color: #10b981;
        font-size: 1.2rem;
    }

    .info-card .card-body {
        padding: 1.5rem;
    }

    /* Info Rows */
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #64748b;
        font-weight: 500;
    }

    .info-value {
        color: #1e2937;
        font-weight: 500;
    }

    .info-value.highlight {
        color: #10b981;
        font-weight: 700;
    }

    .info-link {
        color: #10b981;
        text-decoration: none;
    }

    .info-link:hover {
        text-decoration: underline;
    }

    /* Subscription Status */
    .subscription-status {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: 20px;
        margin-bottom: 1.5rem;
    }

    .subscription-status.active {
        background: #d1fae5;
    }

    .subscription-status.expired {
        background: #fee2e2;
    }

    .status-icon i {
        font-size: 2rem;
    }

    .subscription-status.active .status-icon i {
        color: #10b981;
    }

    .subscription-status.expired .status-icon i {
        color: #ef4444;
    }

    .status-label {
        display: block;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-value {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .subscription-status.active .status-value {
        color: #047857;
    }

    .subscription-status.expired .status-value {
        color: #b91c1c;
    }

    /* Info Grid */
    .info-grid {
        margin-bottom: 1.5rem;
    }

    /* Time Left Badges */
    .badge-expired {
        background: #fee2e2;
        color: #b91c1c;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-active {
        background: #d1fae5;
        color: #047857;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Usage Stats */
    .usage-stats {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .usage-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
        color: #475569;
    }

    .progress-bar-container {
        height: 8px;
        background: #e2e8f0;
        border-radius: 100px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 100px;
        transition: width 0.3s ease;
    }

    /* Company Logo */
    .company-logo img {
        max-width: 100px;
        border-radius: 16px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    /* Jobs List */
    .jobs-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .job-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .job-item:hover {
        background: #f8fafc;
    }

    .job-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .job-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .job-title {
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 0.25rem;
    }

    .job-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .job-meta i {
        color: #10b981;
        margin-right: 2px;
    }

    .job-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .badge-status {
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-status.approved {
        background: #d1fae5;
        color: #047857;
    }

    .badge-status.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-status.inactive {
        background: #fee2e2;
        color: #b91c1c;
    }

    .featured-tag {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 40px;
        font-size: 0.7rem;
    }

    .job-count {
        background: #f1f5f9;
        padding: 0.25rem 0.5rem;
        border-radius: 40px;
        font-size: 0.8rem;
        color: #1e2937;
        margin-left: 0.5rem;
    }

    /* Empty States */
    .empty-subscription,
    .empty-jobs {
        text-align: center;
        padding: 2rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f8fafc;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .empty-icon i {
        font-size: 2.5rem;
        color: #94a3b8;
    }

    .empty-text {
        font-weight: 500;
        color: #1e2937;
        margin-bottom: 0.25rem;
    }

    .empty-subtext {
        font-size: 0.85rem;
        color: #94a3b8;
    }

    /* Activity Timeline */
    .activity-timeline {
        position: relative;
        padding-left: 1.5rem;
    }

    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, #10b981 0%, #e2e8f0 100%);
    }

    .activity-item {
        position: relative;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 1rem;
    }

    .activity-dot {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        position: absolute;
        left: -1.5rem;
        top: 4px;
        border: 3px solid white;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
    }

    .activity-dot.bg-success {
        background: #10b981;
    }

    .activity-dot.bg-primary {
        background: #3b82f6;
    }

    .activity-dot.bg-warning {
        background: #f59e0b;
    }

    .activity-dot.bg-info {
        background: #0ea5e9;
    }

    .activity-content {
        flex: 1;
        background: #f8fafc;
        padding: 0.75rem 1rem;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .activity-content:hover {
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
    }

    .activity-time {
        color: #94a3b8;
        font-size: 0.75rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .profile-stats {
            flex-direction: column;
            gap: 1rem;
        }

        .header-actions {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }

        .job-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .job-status {
            width: 100%;
        }
    }
</style>

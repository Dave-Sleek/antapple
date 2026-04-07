@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- ============================= --}}
        {{-- PREMIUM DASHBOARD HEADER --}}
        {{-- ============================= --}}
        <div class="dashboard-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-grid"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-house-door me-2"></i>EMPLOYER PORTAL
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Welcome Back, <span
                                    class="text-success">{{ auth()->user()->name }}</span></h1>
                            <p class="text-muted lead mb-0">Manage your job listings and track performance</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-actions">
                        <a href="{{ route('employer.create') }}" class="btn-primary-premium">
                            <i class="bi bi-plus-circle me-2"></i>
                            <span>Post New Job</span>
                            <div class="btn-glow"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================= --}}
        {{-- PREMIUM SUBSCRIPTION CARD --}}
        {{-- ============================= --}}
        <div class="subscription-premium-card mb-5">
            @if (auth()->user()->hasActiveSubscription())
                <div class="subscription-content">
                    <div class="subscription-info">
                        <div class="status-badge active">
                            <span class="status-dot"></span>
                            Active
                        </div>
                        <h4 class="plan-name">{{ auth()->user()->subscription->plan->name }}</h4>
                        <div class="plan-meta">
                            <div class="meta-item">
                                <i class="bi bi-calendar-check"></i>
                                <span>Expires:
                                    <strong>{{ \Carbon\Carbon::parse(auth()->user()->subscription->ends_at)->format('d M, Y') }}</strong></span>
                            </div>
                            <div class="meta-item">
                                <i class="bi bi-briefcase"></i>
                                <span>Jobs Left:
                                    <strong>{{ auth()->user()->subscription->plan->job_limit - $totalJobs }}</strong></span>

                                {{-- @php
                                    $featuredUsed = auth()->user()->jobs()->where('is_featured', true)->count();
                                    $planLimit = auth()->user()->subscription->plan->featured_limit ?? 0;
                                @endphp

                                @if ($featuredUsed >= $planLimit)
                                    <small class="text-danger">
                                        Featured limit reached.
                                    </small>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                    <div class="subscription-actions">
                        <a href="{{ route('pricing') }}" class="btn-outline-premium">
                            <i class="bi bi-arrow-repeat me-2"></i>
                            Change Plan
                        </a>
                    </div>
                </div>
                <div class="subscription-progress">
                    <div class="progress-label">
                        <span>Usage this month</span>
                        <span
                            class="text-success">{{ round(($totalJobs / auth()->user()->subscription->plan->job_limit) * 100) }}%</span>
                    </div>
                    <div class="progress premium-progress">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ ($totalJobs / auth()->user()->subscription->plan->job_limit) * 100 }}%; background: linear-gradient(90deg, #10b981, #047857);"
                            aria-valuenow="{{ ($totalJobs / auth()->user()->subscription->plan->job_limit) * 100 }}"
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            @else
                <div class="subscription-content no-subscription">
                    <div class="subscription-info">
                        <div class="status-badge inactive">
                            <span class="status-dot"></span>
                            Inactive
                        </div>
                        <h4 class="plan-name">No Active Subscription</h4>
                        <p class="text-muted">Upgrade to start posting jobs and reach thousands of candidates</p>
                    </div>
                    <div class="subscription-actions">
                        <a href="{{ route('pricing') }}" class="btn-primary-premium">
                            <i class="bi bi-rocket me-2"></i>
                            Choose Plan
                            <div class="btn-glow"></div>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        {{-- Featured Limit --}}
        @if ($featuredLimit > 0)
            @php
                $percentage = $featuredLimit > 0 ? min(100, ($featuredUsed / $featuredLimit) * 100) : 0;
            @endphp

            @if ($percentage >= 80 && $percentage < 100)
                <small class="text-warning mt-2 d-block">
                    You're almost at your limit. Consider upgrading.
                </small>
            @endif

            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">
                            ⭐ Featured Jobs Usage
                        </h6>
                        <span class="fw-bold">
                            {{ $featuredUsed }} / {{ $featuredLimit }}
                        </span>
                    </div>

                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;">
                        </div>
                    </div>

                    @if ($featuredUsed >= $featuredLimit)
                        <small class="text-danger mt-2 d-block">
                            You’ve reached your featured job limit.
                        </small>
                    @endif
                </div>
            </div>

            <div class="modal fade" id="upgradeModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Upgrade Required</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body text-center">
                            <h6 class="fw-bold mb-3">
                                🚀 Want More Featured Jobs?
                            </h6>

                            <p>
                                Upgrade your subscription plan to feature more jobs
                                and get maximum visibility.
                            </p>

                            <a href="{{ route('pricing') }}" class="btn btn-primary">
                                View Upgrade Plans
                            </a>
                        </div>

                    </div>
                </div>
            </div>


            {{-- @if ($featuredUsed >= $featuredLimit)
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#upgradeModal">
                    <i class="bi bi-star-fill"></i> Mark as Featured
                </button>
            @else
                <form action="{{ route('employer.jobs.feature', $job) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm">
                        <i class="bi bi-star-fill"></i> Mark as Featured
                    </button>
                </form>
            @endif --}}

            {{--  End of Modal --}}
        @endif

        {{-- ============================= --}}
        {{-- PREMIUM ANALYTICS CARDS --}}
        {{-- ============================= --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="analytics-card">
                    <div class="card-icon purple">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="card-content">
                        <span class="card-label">Total Jobs</span>
                        <div class="card-value">{{ $totalJobs }}</div>
                        <span class="card-trend positive">
                            <i class="bi bi-arrow-up"></i> +12% vs last month
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="analytics-card">
                    <div class="card-icon purple">
                        <i class="bi bi-eye"></i>
                    </div>
                    <div class="card-content">
                        <span class="card-label">Total View</span>
                        <div class="card-value">{{ number_format($totalViews) }}</div>
                        <span class="card-trend positive">
                            <i class="bi bi-arrow-up"></i> +20%
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="analytics-card">
                    <div class="card-icon success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="card-content">
                        <span class="card-label">Approved Jobs</span>
                        <div class="card-value">{{ $approvedJobs }}</div>
                        <span class="card-trend positive">
                            <i class="bi bi-arrow-up"></i>
                            {{ $totalJobs > 0 ? round(($approvedJobs / $totalJobs) * 100) : 0 }}% approval rate
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="analytics-card">
                    <div class="card-icon gold">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="card-content">
                        <span class="card-label">Total Revenue</span>
                        <div class="card-value">₦{{ number_format($totalRevenue, 0) }}</div>
                        <span class="card-trend neutral">Lifetime earnings</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================= --}}
        {{-- PREMIUM JOB LISTINGS --}}
        {{-- ============================= --}}
        <div class="listings-premium-card">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Your Job Listings</h4>
                        <p class="header-subtitle">Manage and track all your posted jobs</p>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {{-- Premium Filter Bar --}}
                <div class="filter-bar mb-4">
                    <form method="GET" class="filter-form">
                        <div class="filter-grid">
                            <div class="filter-item">
                                <div class="premium-input">
                                    <i class="bi bi-search"></i>
                                    <input type="text" name="search" class="filter-input"
                                        placeholder="Search jobs..." value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="filter-item">
                                <div class="premium-select">
                                    <i class="bi bi-flag"></i>
                                    <select name="status" class="filter-select">
                                        <option value="">All Status</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                    </select>
                                </div>
                            </div>

                            <div class="filter-item">
                                <div class="premium-select">
                                    <i class="bi bi-star"></i>
                                    <select name="type" class="filter-select">
                                        <option value="">All Types</option>
                                        <option value="featured" {{ request('type') == 'featured' ? 'selected' : '' }}>
                                            Featured</option>
                                        <option value="standard" {{ request('type') == 'standard' ? 'selected' : '' }}>
                                            Standard</option>
                                    </select>
                                </div>
                            </div>

                            <div class="filter-item">
                                <div class="premium-input">
                                    <i class="bi bi-calendar"></i>
                                    <input type="date" name="from" class="filter-input"
                                        value="{{ request('from') }}">
                                </div>
                            </div>

                            <div class="filter-item">
                                <div class="premium-input">
                                    <i class="bi bi-calendar-check"></i>
                                    <input type="date" name="to" class="filter-input"
                                        value="{{ request('to') }}">
                                </div>
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn-filter">
                                    <i class="bi bi-funnel"></i>
                                    Filter
                                </button>
                                <a href="{{ route('employer.dashboard') }}" class="btn-reset">
                                    <i class="bi bi-x"></i>
                                </a>
                            </div>
                        </div>

                        <div class="filter-footer mt-3">
                            <div class="d-flex gap-2">
                                <a href="{{ route('employer.jobs.export') }}" class="btn-export">
                                    <i class="bi bi-download me-2"></i>
                                    Export Data
                                </a>

                                <a href="{{ route('employer.jobs.trash') }}"
                                    class="btn-trash {{ request()->routeIs('employer.jobs.trash') ? 'active' : '' }}">
                                    <i class="bi bi-trash me-2"></i>
                                    View Trash
                                    <span class="badge bg-danger me-2">
                                        {{ \App\Models\Job_post::onlyTrashed()->where('user_id', auth()->id())->count() }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Jobs Table --}}
                <div class="table-premium-wrapper">
                    <table class="table-premium">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Posted Date</th>
                                <th>Applications</th>
                                <th>Views</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $job)
                                <tr class="job-row">
                                    <td>
                                        <div class="job-info">
                                            <div class="job-icon">
                                                <i class="bi bi-file-text"></i>
                                            </div>
                                            <div>
                                                <div class="job-title">{{ $job->title }}</div>
                                                <div class="job-meta">
                                                    <span><i class="bi bi-geo-alt"></i> {{ $job->location }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($job->status == 'active')
                                            <span class="badge-status approved">
                                                <span class="dot"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="badge-status pending">
                                                <span class="dot"></span>
                                                Pending
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($job->is_featured)
                                            <span class="badge-featured">
                                                <i class="bi bi-star-fill"></i>
                                                Featured
                                            </span>
                                        @else
                                            <span class="badge-standard">Standard</span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="date">{{ $job->created_at->format('d M Y') }}</span>
                                    </td>

                                    <td>
                                        <span class="applications-count">{{ $job->applications_count ?? 0 }}</span>
                                    </td>

                                    <td>
                                        <span class="views-count">{{ number_format($job->job_views_count) }}</span>
                                    </td>

                                    <td class="text-end">
                                        <div class="action-buttons">
                                            <a href="{{ route('employer.edit', $job->id) }}" class="action-btn edit"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => Str::slug($job->title)]) }}"
                                                class="action-btn view" title="View" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <button type="button" class="action-btn stats" title="Statistics"
                                                onclick="showJobStats({{ $job->id }})">
                                                <i class="bi bi-bar-chart"></i>
                                            </button>

                                            <form
                                                action="{{ route('employer.destroy', ['job' => $job->uuid, 'slug' => Str::slug($job->title)]) }}"
                                                method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this job?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                            @if (auth()->user()->subscription && auth()->user()->subscription->status === 'active')
                                                @if (!$job->is_featured)
                                                    {{-- If limit reached, show modal button --}}
                                                    @if ($featuredUsed >= $featuredLimit)
                                                        <button type="button" class="action-btn stats"
                                                            data-bs-toggle="modal" data-bs-target="#upgradeModal"
                                                            title="Upgrade to Feature">
                                                            <i class="bi bi-star"></i>
                                                        </button>
                                                    @else
                                                        <form action="{{ route('employer.feature', $job) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="action-btn stats"
                                                                title="Mark as Featured">
                                                                <i class="bi bi-star"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <span class="badge bg-success"
                                                        title="Featured until {{ $job->featured_until->format('M d, Y') }}">
                                                        {{ $job->featured_until->format('M d, Y') }}
                                                    </span>

                                                    <form action="{{ route('employer.unfeature', $job) }}" method="POST"
                                                        class="mt-2">
                                                        @csrf
                                                        <button type="submit" class="action-btn delete"
                                                            title="Unfeature">
                                                            <i class="bi bi-star-fill"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="bi bi-briefcase"></i>
                                            </div>
                                            <h5 class="fw-bold mb-2">No Jobs Posted Yet</h5>
                                            <p class="text-muted mb-4">Get started by posting your first job listing</p>
                                            <a href="{{ route('employer.create') }}" class="btn-primary-premium">
                                                <i class="bi bi-plus-circle me-2"></i>
                                                Post Your First Job
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($jobs->hasPages())
                    <div class="pagination-premium mt-4">
                        {{ $jobs->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="quick-actions-grid mt-5">
            <div class="quick-action-card">
                <i class="bi bi-file-text"></i>
                <h6>Post a Job</h6>
                <p>Create a new job listing</p>
                <a href="{{ route('employer.create') }}" class="stretched-link"></a>
            </div>

            <div class="quick-action-card">
                <i class="bi bi-people"></i>
                <h6>View Applicants</h6>
                <p>Review job applications</p>
                <a href="{{ route('employer.applicants') }}" class="stretched-link"></a>
            </div>

            <div class="quick-action-card">
                <i class="bi bi-credit-card"></i>
                <h6>Billing</h6>
                <p>Manage subscription</p>
                <a href="{{ route('employer.subscription') }}" class="stretched-link"></a>
            </div>

            <div class="quick-action-card">
                <i class="bi bi-building"></i>
                <h6>Company Page</h6>
                <p>View public profile</p>
                <a href="{{ route('employer.company.page', auth()->user()->id) }}" target="_blank"
                    class="stretched-link"></a>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Dashboard Styles */

    /* Header */
    .dashboard-header {
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

    .header-actions {
        display: flex;
        justify-content: flex-end;
    }

    /* Premium Buttons */
    .btn-primary-premium {
        position: relative;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        padding: 16px 36px;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        border: none;
    }

    .btn-primary-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4);
        color: white;
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

    .btn-primary-premium:hover .btn-glow {
        opacity: 1;
    }

    .btn-outline-premium {
        display: inline-flex;
        align-items: center;
        padding: 14px 32px;
        background: white;
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-premium:hover {
        border-color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.02) 0%, rgba(4, 120, 87, 0.02) 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.1);
    }

    /* Subscription Card */
    .subscription-premium-card {
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
        border-radius: 28px;
        padding: 2rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .subscription-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }

    .status-badge.active {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #047857;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-badge.inactive {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #b91c1c;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-badge.active .status-dot {
        background: #10b981;
        animation: blink 2s infinite;
    }

    .status-badge.inactive .status-dot {
        background: #ef4444;
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

    .plan-name {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e2937;
        margin-bottom: 0.5rem;
    }

    .plan-meta {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #475569;
    }

    .meta-item i {
        color: #10b981;
    }

    .subscription-progress {
        margin-top: 1.5rem;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        color: #475569;
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

    /* Analytics Cards */
    .analytics-card {
        background: white;
        border-radius: 24px;
        padding: 1.8rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .analytics-card:hover {
        transform: translateY(-5px);
        border-color: #10b981;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.1);
    }

    .card-icon {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .card-icon.purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .card-icon.success {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .card-icon.gold {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .card-content {
        flex: 1;
    }

    .card-label {
        display: block;
        color: #64748b;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .card-value {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1e2937;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .card-trend {
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .card-trend.positive {
        color: #10b981;
    }

    .card-trend.neutral {
        color: #64748b;
    }

    /* Listings Card */
    .listings-premium-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .listings-premium-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 2rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .header-subtitle {
        color: #64748b;
        margin-bottom: 0;
    }

    /* Filter Bar */
    .filter-bar {
        background: #f8fafc;
        border-radius: 24px;
        padding: 1.5rem;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }

    .premium-input,
    .premium-select {
        position: relative;
    }

    .premium-input i,
    .premium-select i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        z-index: 2;
        pointer-events: none;
        transition: color 0.3s ease;
    }

    .premium-input:focus-within i,
    .premium-select:focus-within i {
        color: #10b981;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        height: 48px;
        padding: 0 16px 0 48px;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
    }

    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-filter {
        flex: 1;
        height: 48px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }


    .btn-trash {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background: #fee2e2;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 40px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-trash:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
    }

    .btn-reset {
        width: 48px;
        height: 48px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        border-color: #ef4444;
        color: #ef4444;
        transform: rotate(90deg);
    }

    .btn-export {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 40px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-export:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
    }

    /* Premium Table */
    .table-premium-wrapper {
        overflow-x: auto;
    }

    .table-premium {
        width: 100%;
        border-collapse: collapse;
    }

    .table-premium th {
        text-align: left;
        padding: 1.2rem 1rem;
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-premium td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .job-row {
        transition: all 0.3s ease;
    }

    .job-row:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
    }

    .job-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .job-icon {
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

    .job-title {
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 4px;
    }

    .job-meta {
        font-size: 0.8rem;
        color: #94a3b8;
        display: flex;
        gap: 12px;
    }

    .job-meta i {
        font-size: 0.7rem;
    }

    /* Status Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 60px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .badge-status .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .badge-status.approved {
        background: #d1fae5;
        color: #047857;
    }

    .badge-status.approved .dot {
        background: #10b981;
    }

    .badge-status.pending {
        background: #fed7aa;
        color: #92400e;
    }

    .badge-status.pending .dot {
        background: #f59e0b;
    }

    .badge-featured {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border-radius: 60px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .badge-standard {
        display: inline-block;
        padding: 6px 12px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 60px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s ease;
        background: white;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .action-btn.edit:hover {
        border-color: #10b981;
        color: #10b981;
        box-shadow: 0 5px 10px rgba(16, 185, 129, 0.1);
    }

    .action-btn.view:hover {
        border-color: #8b5cf6;
        color: #8b5cf6;
        box-shadow: 0 5px 10px rgba(139, 92, 246, 0.1);
    }

    .action-btn.stats:hover {
        border-color: #f59e0b;
        color: #f59e0b;
        box-shadow: 0 5px 10px rgba(245, 158, 11, 0.1);
    }

    .action-btn.delete:hover {
        border-color: #ef4444;
        color: #ef4444;
        box-shadow: 0 5px 10px rgba(239, 68, 68, 0.1);
    }

    /* .action-btn.secondary:hover {
        border-color: #ef4444;
        color: #ef4444;
        box-shadow: 0 5px 10px rgba(239, 68, 68, 0.1);
    } */

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #94a3b8;
        margin: 0 auto 1.5rem;
        border: 1px solid #e2e8f0;
    }

    /* Quick Actions */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .quick-action-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .quick-action-card:hover {
        transform: translateY(-5px);
        border-color: #10b981;
        box-shadow: 0 20px 30px rgba(16, 185, 129, 0.1);
    }

    .quick-action-card i {
        font-size: 2rem;
        color: #10b981;
        margin-bottom: 1rem;
    }

    .quick-action-card h6 {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .quick-action-card p {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 0;
    }

    /* Pagination */
    .pagination-premium {
        display: flex;
        justify-content: center;
    }

    .pagination-premium .pagination {
        gap: 0.5rem;
    }

    .pagination-premium .page-link {
        border: 1px solid #e2e8f0;
        border-radius: 12px !important;
        color: #475569;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }

    .pagination-premium .page-link:hover {
        border-color: #10b981;
        color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.02) 0%, rgba(4, 120, 87, 0.02) 100%);
    }

    .pagination-premium .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 5px 10px rgba(16, 185, 129, 0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .subscription-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .header-actions {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr 1fr;
        }

        .analytics-card {
            padding: 1.2rem;
        }

        .card-value {
            font-size: 1.8rem;
        }
    }
</style>

<script>
    function showJobStats(jobId) {
        // Implement job statistics modal or tooltip
        alert('Job statistics feature coming soon!');
    }

    // Delete form confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this job?')) {
                e.preventDefault();
            }
        });
    });
</script>

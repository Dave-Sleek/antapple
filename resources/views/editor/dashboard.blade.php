@extends('layouts.app')

@section('title', 'Editor Dashboard - Sproutplex Jobs')
@section('description', 'Manage jobs, categories, and content as an editor')

@section('content')
    <div class="container py-5">

        {{-- Premium Header --}}
        <div class="editor-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                            <div class="header-icon-ring"></div>
                        </div>
                        <div>
                            <span class="badge bg-primary-subtle text-primary px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-person-badge me-2"></i>EDITOR PORTAL
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Editor <span
                                    class="text-gradient">Dashboard</span></h1>
                            <p class="text-muted lead mb-0">Manage jobs, categories, and platform content</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="header-actions">
                        <div class="welcome-badge">
                            <i class="bi bi-person-circle"></i>
                            <span>Welcome, {{ auth()->user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-inline">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                                <div class="btn-glow"></div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Jobs</span>
                        <span class="stat-value">{{ $totalJobs }}</span>
                        <div class="stat-trend">
                            <i class="bi bi-bar-chart"></i> All time
                        </div>
                    </div>
                    <div class="stat-bg-icon">
                        <i class="bi bi-briefcase"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Active Jobs</span>
                        <span class="stat-value">{{ $activeJobs }}</span>
                        <div class="stat-trend positive">
                            <i class="bi bi-arrow-up"></i> Currently live
                        </div>
                    </div>
                    <div class="stat-bg-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="bi bi-tags"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Categories</span>
                        <span class="stat-value">{{ $categoriesCount }}</span>
                        <div class="stat-trend">
                            <i class="bi bi-folder"></i> Organized content
                        </div>
                    </div>
                    <div class="stat-bg-icon">
                        <i class="bi bi-tags"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions Grid --}}
        <div class="quick-actions-section mb-5">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-lightning-charge text-success me-2"></i>
                Quick Actions
            </h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <a href="{{ route('editor-jobs.index') }}" class="quick-action-card">
                        <div class="card-icon jobs">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Manage Jobs</h6>
                            <p class="text-muted small mb-0">Create, edit, and manage job postings</p>
                        </div>
                        <div class="card-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="card-glow"></div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('categories.index') }}" class="quick-action-card">
                        <div class="card-icon categories">
                            <i class="bi bi-tags"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Manage Categories</h6>
                            <p class="text-muted small mb-0">Organize job categories efficiently</p>
                        </div>
                        <div class="card-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="card-glow"></div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('editor-opportunities.index') }}" class="quick-action-card">
                        <div class="card-icon opportunities">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Manage Opportunities</h6>
                            <p class="text-muted small mb-0">Organize opportunity listings efficiently</p>
                        </div>
                        <div class="card-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="card-glow"></div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Jobs Card --}}
        <div class="recent-jobs-card">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Recent Jobs</h5>
                        <p class="header-subtitle">Latest job postings and their status</p>
                    </div>
                </div>
                <a href="{{ route('editor-jobs.index') }}" class="view-all-link">
                    View All Jobs
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="card-body p-0">
                @forelse($recentJobs as $job)
                    <div class="job-item">
                        <div class="job-info">
                            <div class="job-icon">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div>
                                <div class="job-title">{{ $job->title }}</div>
                                <div class="job-meta">
                                    <span><i class="bi bi-building"></i> {{ $job->company_name }}</span>
                                    <span><i class="bi bi-calendar"></i> {{ $job->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="job-status">
                            @if ($job->status == 'active')
                                <span class="status-badge active">
                                    <span class="status-dot"></span>
                                    Active
                                </span>
                            @elseif($job->status == 'pending')
                                <span class="status-badge pending">
                                    <span class="status-dot"></span>
                                    Pending
                                </span>
                            @else
                                <span class="status-badge inactive">
                                    <span class="status-dot"></span>
                                    {{ ucfirst($job->status) }}
                                </span>
                            @endif
                            @if ($job->is_featured)
                                <span class="featured-tag">
                                    <i class="bi bi-star-fill"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <p class="empty-text">No jobs created yet</p>
                        <p class="empty-subtext">Start by creating your first job posting</p>
                        <a href="{{ route('editor-jobs.create') }}" class="btn-create">
                            <i class="bi bi-plus-circle me-2"></i>
                            Create Job
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Editor Tips --}}
        <div class="editor-tips mt-4">
            <div class="tips-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="tips-icon">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Editor Tips</h6>
                        <p class="text-muted small mb-0">Regularly review pending jobs and keep categories organized for
                            better content management</p>
                    </div>
                    <a href="#" class="tips-link">
                        View Guide
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Editor Dashboard Styles */

    /* Header */
    .editor-header {
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
        align-items: center;
        gap: 1rem;
    }

    .welcome-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f1f5f9;
        border-radius: 40px;
        color: #1e2937;
        font-weight: 500;
    }

    .welcome-badge i {
        color: #10b981;
    }

    .logout-btn {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.25rem;
        background: white;
        color: #ef4444;
        border: 1px solid #fee2e2;
        border-radius: 40px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
    }

    .logout-btn:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
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

    .logout-btn:hover .btn-glow {
        opacity: 1;
    }

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: #10b981;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        margin-bottom: 1rem;
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .stat-icon.green {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .stat-icon.purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .stat-content {
        position: relative;
        z-index: 2;
    }

    .stat-label {
        display: block;
        color: #64748b;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .stat-value {
        display: block;
        font-size: 2.5rem;
        font-weight: 800;
        color: #1e2937;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .stat-trend {
        font-size: 0.8rem;
        color: #64748b;
    }

    .stat-trend.positive {
        color: #10b981;
    }

    .stat-bg-icon {
        position: absolute;
        bottom: -20px;
        right: -20px;
        font-size: 5rem;
        color: rgba(16, 185, 129, 0.05);
        z-index: 1;
    }

    /* Quick Actions Section */
    .quick-actions-section h5 {
        color: #1e2937;
    }

    .quick-action-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .quick-action-card:hover {
        transform: translateY(-5px);
        border-color: #10b981;
        box-shadow: 0 20px 30px rgba(16, 185, 129, 0.1);
    }

    .card-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
    }

    .card-icon.jobs {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .card-icon.categories {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .card-icon.categories {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .card-icon.opportunities {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .card-arrow {
        margin-left: auto;
        color: #94a3b8;
        transition: all 0.3s ease;
    }

    .quick-action-card:hover .card-arrow {
        transform: translateX(5px);
        color: #10b981;
    }

    .card-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .quick-action-card:hover .card-glow {
        opacity: 1;
    }

    /* Recent Jobs Card */
    .recent-jobs-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .recent-jobs-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.4rem;
    }

    .header-subtitle {
        color: #64748b;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .view-all-link {
        color: #10b981;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: gap 0.3s ease;
    }

    .view-all-link:hover {
        gap: 0.5rem;
    }

    /* Job Items */
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
        margin-bottom: 4px;
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

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-badge.active {
        background: #d1fae5;
        color: #047857;
    }

    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-badge.inactive {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .status-badge.active .status-dot {
        background: #10b981;
    }

    .status-badge.pending .status-dot {
        background: #f59e0b;
    }

    .status-badge.inactive .status-dot {
        background: #ef4444;
    }

    .featured-tag {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
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
        margin-bottom: 1rem;
    }

    .btn-create {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        color: white;
    }

    /* Editor Tips */
    .editor-tips {
        margin-top: 1.5rem;
    }

    .tips-card {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 20px;
        padding: 1rem 1.5rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .tips-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .tips-link {
        color: #10b981;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: gap 0.3s ease;
        white-space: nowrap;
    }

    .tips-link:hover {
        gap: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .header-actions {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .job-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .job-status {
            width: 100%;
        }

        .tips-card {
            flex-direction: column;
            text-align: center;
        }

        .tips-link {
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .stat-card {
            padding: 1rem;
        }

        .stat-value {
            font-size: 1.8rem;
        }

        .job-meta {
            flex-direction: column;
            gap: 0.25rem;
        }

        .quick-action-card {
            padding: 1rem;
        }
    }
</style>

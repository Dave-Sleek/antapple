@extends('layouts.app')

@section('title', 'Trashed Jobs - Recycle Bin')

@section('content')

    <div class="container-fluid py-5 px-4">

        {{-- Premium Header --}}
        <div class="trash-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-trash3"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                            <div class="header-icon-ring"></div>
                        </div>
                        <div>
                            <span class="badge bg-danger-subtle text-danger px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-recycle me-2"></i>RECYCLE BIN
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Trashed <span
                                    class="text-gradient">Jobs</span></h1>
                            <p class="text-muted lead mb-0">Manage and restore deleted job listings</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-actions">
                        <a href="{{ route('employer.dashboard') }}" class="btn-outline-premium">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="bi bi-trash"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Trashed</span>
                        <span class="stat-value">{{ $jobs->total() }}</span>
                        <span class="stat-trend">
                            <i class="bi bi-clock-history"></i> Last 30 days
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="bi bi-calendar"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Oldest Deleted</span>
                        <span class="stat-value">
                            @if ($jobs->count())
                                {{ $jobs->sortBy('deleted_at')->first()->deleted_at->diffForHumans() }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Restore Available</span>
                        <span class="stat-value">{{ $jobs->count() }}</span>
                        <span class="stat-trend">
                            <i class="bi bi-info-circle"></i> Auto-delete in 30 days
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if ($jobs->count())

            {{-- Search and Filter Bar --}}
            <div class="filter-premium-card mb-5">
                <div class="filter-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="filter-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Search Trashed Jobs</h5>
                            <p class="filter-subtitle">Find deleted jobs by title or location</p>
                        </div>
                    </div>
                </div>

                <div class="filter-body">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <div class="premium-input">
                                <i class="bi bi-search"></i>
                                <input type="text" id="searchTrash" class="filter-input"
                                    placeholder="Search by job title or location...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="premium-select">
                                <i class="bi bi-sort-alpha-down"></i>
                                <select id="sortTrash" class="filter-select">
                                    <option value="newest">Newest First</option>
                                    <option value="oldest">Oldest First</option>
                                    <option value="name_asc">Title A-Z</option>
                                    <option value="name_desc">Title Z-A</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Summary --}}
            <div class="stats-summary mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-0">
                        Showing <span class="fw-bold text-danger">{{ $jobs->firstItem() ?? 0 }}</span> to
                        <span class="fw-bold text-danger">{{ $jobs->lastItem() ?? 0 }}</span> of
                        <span class="fw-bold text-danger">{{ $jobs->total() }}</span> trashed jobs
                    </p>
                    <div class="bulk-actions">
                        <button class="btn-restore-all" onclick="restoreAll()" title="Restore All">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Restore All
                        </button>
                        <button class="btn-empty-trash" onclick="emptyTrash()" title="Empty Trash">
                            <i class="bi bi-trash"></i>
                            Empty Trash
                        </button>
                    </div>
                </div>
            </div>

            {{-- Trashed Jobs Cards --}}
            <div class="trash-grid" id="trashGrid">
                @foreach ($jobs as $job)
                    <div class="trash-card" data-title="{{ strtolower($job->title) }}"
                        data-location="{{ strtolower($job->location) }}" data-date="{{ $job->deleted_at }}">
                        <div class="card-status {{ $job->deleted_at->diffInDays(now()) > 20 ? 'warning' : 'normal' }}">
                            @if ($job->deleted_at->diffInDays(now()) > 20)
                                <i class="bi bi-exclamation-triangle"></i>
                                <span>Expires soon</span>
                            @else
                                <i class="bi bi-clock"></i>
                                <span>{{ $job->deleted_at->diffForHumans() }}</span>
                            @endif
                        </div>

                        <div class="card-body">
                            <div class="job-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>

                            <h5 class="job-title fw-bold">{{ $job->title }}</h5>

                            <div class="job-meta">
                                <div class="meta-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>{{ $job->location }}</span>
                                </div>
                                @if ($job->company_name)
                                    <div class="meta-item">
                                        <i class="bi bi-building"></i>
                                        <span>{{ $job->company_name }}</span>
                                    </div>
                                @endif
                                <div class="meta-item">
                                    <i class="bi bi-calendar-x"></i>
                                    <span>Deleted: {{ $job->deleted_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <div class="expiry-bar">
                                <div class="expiry-label">
                                    <span>Auto-delete in</span>
                                    <span class="fw-bold">{{ (int) max(0, 30 - $job->deleted_at->diffInDays(now())) }}
                                        days</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar"
                                        style="width: {{ min(100, ($job->deleted_at->diffInDays(now()) / 30) * 100) }}%;
                                                background: {{ $job->deleted_at->diffInDays(now()) > 20 ? '#f59e0b' : '#10b981' }};">
                                    </div>
                                </div>
                            </div>

                            <div class="card-actions">
                                {{-- Restore Form --}}
                                <form action="{{ route('employer.jobs.restore', $job->id) }}" method="POST"
                                    class="restore-form">
                                    @csrf
                                    <button type="submit" class="btn-restore">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                        <span>Restore Job</span>
                                    </button>
                                </form>

                                {{-- Permanent Delete Form --}}
                                <form action="{{ route('employer.jobs.forceDelete', $job->id) }}" method="POST"
                                    class="delete-form"
                                    onsubmit="return confirm('This action cannot be undone. This job will be permanently deleted. Continue?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-permanent">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-glow"></div>
                    </div>
                @endforeach
            </div>

            {{-- Premium Pagination --}}
            @if ($jobs->hasPages())
                <div class="pagination-premium mt-5">
                    {{ $jobs->withQueryString()->links() }}
                </div>
            @endif

            {{-- Warning Banner --}}
            <div class="warning-banner mt-4">
                <i class="bi bi-info-circle"></i>
                <span>Jobs are automatically permanently deleted after 30 days in trash.</span>
            </div>
        @else
            {{-- Premium Empty State --}}
            <div class="empty-state-premium">
                <div class="empty-state-glow"></div>
                <div class="empty-state-icon">
                    <i class="bi bi-trash"></i>
                </div>
                <h3 class="fw-bold mb-3">Trash is Empty</h3>
                <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">
                    Deleted jobs will appear here. You can restore them within 30 days before they're permanently removed.
                </p>
                <div class="empty-illustration">
                    <i class="bi bi-recycle"></i>
                    <span>30-day recovery period</span>
                </div>
                <a href="{{ route('employer.dashboard') }}" class="btn-browse mt-4">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Active Jobs
                </a>
            </div>
        @endif

        {{-- Info Card --}}
        <div class="info-card mt-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="info-icon">
                            <i class="bi bi-question-circle"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">About the Recycle Bin</h5>
                            <p class="text-muted mb-0">Jobs in trash are automatically deleted after 30 days. Restore them
                                anytime before that.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-light text-dark px-4 py-2 rounded-pill">
                        <i class="bi bi-clock me-2"></i>Auto-delete in 30 days
                    </span>
                </div>
            </div>
        </div>
    </div>

@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Trashed Jobs Styles */

    /* Header */
    .trash-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 32px;
        padding: 2rem;
        border: 1px solid rgba(239, 68, 68, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .header-icon-wrapper {
        position: relative;
    }

    .header-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: white;
        position: relative;
        z-index: 2;
        box-shadow: 0 15px 30px rgba(239, 68, 68, 0.3);
    }

    .header-icon-glow {
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        background: radial-gradient(circle, rgba(239, 68, 68, 0.4) 0%, transparent 70%);
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
        border: 2px solid rgba(239, 68, 68, 0.2);
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
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .header-actions {
        display: flex;
        justify-content: flex-end;
    }

    .btn-outline-premium {
        display: inline-flex;
        align-items: center;
        padding: 14px 32px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-premium:hover {
        border-color: #ef4444;
        color: #ef4444;
        transform: translateX(-5px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.1);
    }

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid rgba(239, 68, 68, 0.1);
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: #ef4444;
        box-shadow: 0 20px 40px rgba(239, 68, 68, 0.1);
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
    }

    .stat-icon.red {
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
    }

    .stat-icon.orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-icon.green {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .stat-content {
        flex: 1;
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
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e2937;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .stat-trend {
        font-size: 0.8rem;
        color: #64748b;
    }

    .stat-trend i {
        color: #ef4444;
    }

    /* Filter Bar */
    .filter-premium-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(239, 68, 68, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .filter-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(239, 68, 68, 0.1);
    }

    .filter-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.4rem;
    }

    .filter-subtitle {
        color: #64748b;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .filter-body {
        padding: 1.5rem;
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
        transition: color 0.3s ease;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        height: 52px;
        padding: 0 16px 0 48px;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        background: white;
    }

    /* Stats Summary */
    .stats-summary {
        padding: 0 1rem;
    }

    .bulk-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-restore-all,
    .btn-empty-trash {
        padding: 10px 20px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-restore-all {
        background: #d1fae5;
        color: #047857;
    }

    .btn-restore-all:hover {
        background: #10b981;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-empty-trash {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-empty-trash:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
    }

    /* Trash Grid */
    .trash-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .trash-card {
        background: white;
        border-radius: 28px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(239, 68, 68, 0.1);
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .trash-card:hover {
        transform: translateY(-5px);
        border-color: #ef4444;
        box-shadow: 0 30px 60px rgba(239, 68, 68, 0.1);
    }

    .card-status {
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .card-status.normal {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #475569;
    }

    .card-status.warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .card-status i {
        font-size: 1rem;
    }

    .trash-card .card-body {
        padding: 1.5rem;
    }

    .job-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin-bottom: 1rem;
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
    }

    .job-title {
        font-size: 1.3rem;
        margin-bottom: 1rem;
        color: #1e2937;
    }

    .job-meta {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        font-size: 0.95rem;
    }

    .meta-item i {
        color: #ef4444;
        width: 20px;
    }

    /* Expiry Bar */
    .expiry-bar {
        margin-bottom: 1.5rem;
    }

    .expiry-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #475569;
    }

    .expiry-label .fw-bold {
        color: #ef4444;
    }

    .progress {
        height: 8px;
        border-radius: 100px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .progress-bar {
        border-radius: 100px;
        transition: width 0.3s ease;
    }

    /* Card Actions */
    .card-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .restore-form {
        flex: 1;
    }

    .btn-restore {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-restore:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }

    .btn-delete-permanent {
        width: 48px;
        height: 48px;
        background: #fee2e2;
        color: #b91c1c;
        border: none;
        border-radius: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-delete-permanent:hover {
        background: #ef4444;
        color: white;
        transform: rotate(90deg) scale(1.1);
    }

    .card-glow {
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(239, 68, 68, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .trash-card:hover .card-glow {
        opacity: 1;
    }

    /* Warning Banner */
    .warning-banner {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 60px;
        padding: 1rem 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #92400e;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .warning-banner i {
        font-size: 1.5rem;
    }

    /* Pagination */
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
        border-color: #ef4444;
        color: #ef4444;
    }

    .pagination-premium .page-item.active .page-link {
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 5px 10px rgba(239, 68, 68, 0.3);
    }

    /* Empty State */
    .empty-state-premium {
        text-align: center;
        padding: 5rem 3rem;
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
        border-radius: 48px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(239, 68, 68, 0.1);
    }

    .empty-state-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(239, 68, 68, 0.05) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    .empty-state-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        border-radius: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: white;
        margin: 0 auto 2rem;
        position: relative;
        z-index: 2;
        box-shadow: 0 20px 40px rgba(239, 68, 68, 0.3);
    }

    .empty-illustration {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        color: #64748b;
        font-size: 1.1rem;
    }

    .empty-illustration i {
        font-size: 2rem;
        color: #ef4444;
    }

    .btn-browse {
        display: inline-flex;
        align-items: center;
        padding: 14px 36px;
        background: white;
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        z-index: 999;
    }

    .btn-browse:hover {
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(239, 68, 68, 0.2);
    }

    /* Info Card */
    .info-card {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 24px;
        padding: 1.5rem;
        border: 1px solid rgba(239, 68, 68, 0.1);
    }

    .info-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-actions {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .trash-grid {
            grid-template-columns: 1fr;
        }

        .bulk-actions {
            flex-direction: column;
        }

        .stats-summary .d-flex {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .info-card .col-md-4 {
            text-align: left;
            margin-top: 1rem;
        }
    }
</style>

<script>
    // Search functionality
    document.getElementById('searchTrash')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const cards = document.querySelectorAll('.trash-card');

        cards.forEach(card => {
            const title = card.dataset.title;
            const location = card.dataset.location;
            const matches = title.includes(searchTerm) || location.includes(searchTerm);
            card.style.display = matches ? 'block' : 'none';
        });
    });

    // Sort functionality
    document.getElementById('sortTrash')?.addEventListener('change', function() {
        const sortBy = this.value;
        const grid = document.getElementById('trashGrid');
        const cards = Array.from(document.querySelectorAll('.trash-card'));

        cards.sort((a, b) => {
            switch (sortBy) {
                case 'newest':
                    return new Date(b.dataset.date) - new Date(a.dataset.date);
                case 'oldest':
                    return new Date(a.dataset.date) - new Date(b.dataset.date);
                case 'name_asc':
                    return a.dataset.title.localeCompare(b.dataset.title);
                case 'name_desc':
                    return b.dataset.title.localeCompare(a.dataset.title);
                default:
                    return 0;
            }
        });

        grid.innerHTML = '';
        cards.forEach(card => grid.appendChild(card));
    });

    // Restore All function
    function restoreAll() {
        if (confirm('Are you sure you want to restore all trashed jobs?')) {
            // Here you would make an AJAX call to restore all jobs
            alert('All jobs restored successfully');
        }
    }

    // Empty Trash function
    function emptyTrash() {
        if (confirm('Are you sure you want to permanently delete all jobs in trash? This action cannot be undone.')) {
            // Here you would make an AJAX call to empty trash
            alert('Trash emptied successfully');
        }
    }

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm(
                    'This action cannot be undone. This job will be permanently deleted. Continue?')) {
                e.preventDefault();
            }
        });
    });

    // Animate counters
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.stat-value');
        counters.forEach(counter => {
            const value = parseInt(counter.innerText);
            if (!isNaN(value) && value > 0) {
                let current = 0;
                const increment = Math.ceil(value / 50);
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= value) {
                        counter.innerText = value;
                        clearInterval(timer);
                    } else {
                        counter.innerText = current;
                    }
                }, 20);
            }
        });
    });
</script>

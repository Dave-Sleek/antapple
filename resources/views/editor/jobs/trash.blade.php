@extends('layouts.app')

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
                                <i class="bi bi-recycle me-2"></i>Editor RECYCLE BIN
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Trashed <span
                                    class="text-gradient">Jobs</span></h1>
                            <p class="text-muted lead mb-0">Manage permanently deleted job listings across the platform</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-actions">
                        <span class="last-updated">
                            <i class="bi bi-clock-history"></i>
                            Auto-delete after 30 days
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert-premium-success mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="alert-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="flex-grow-1">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-premium-danger mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="alert-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="flex-grow-1">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            </div>
        @endif

        {{-- Premium Stats Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="bi bi-trash"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Deleted</span>
                        <span class="stat-value">{{ $jobs->total() }}</span>
                        <span class="stat-trend">
                            <i class="bi bi-calendar"></i> All time
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Expiring Soon</span>
                        <span
                            class="stat-value">{{ $jobs->filter(fn($job) => $job->deleted_at->diffInDays(now()) > 25)->count() }}</span>
                        <span class="stat-trend">
                            <i class="bi bi-exclamation-triangle"></i> 5 days left
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Restorable</span>
                        <span class="stat-value">{{ $jobs->count() }}</span>
                        <span class="stat-trend">
                            <i class="bi bi-check-circle"></i> Within 30 days
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Affected Employers</span>
                        <span class="stat-value">{{ $jobs->pluck('user_id')->unique()->count() }}</span>
                        <span class="stat-trend">
                            <i class="bi bi-people"></i> Unique employers
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- @if ($jobs->count()) --}}
        {{-- Search and Filter Bar --}}
        <div class="filter-premium-card mb-5">
            <div class="filter-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="filter-icon">
                        <i class="bi bi-sliders2"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Filter Trashed Jobs</h5>
                        <p class="filter-subtitle">Search and filter deleted job listings</p>
                    </div>
                </div>
            </div>

            <form method="GET" class="filter-body" id="filterForm">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-search"></i>
                            <input type="text" name="search" class="filter-input" value="{{ request('search') }}"
                                placeholder="Search by title or company">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="premium-select">
                            <i class="bi bi-tag"></i>
                            <select name="type" class="filter-select">
                                <option value="">All Types</option>
                                <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full
                                    Time</option>
                                <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part
                                    Time</option>
                                <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>Contract
                                </option>
                                <option value="internship" {{ request('type') == 'internship' ? 'selected' : '' }}>
                                    Internship</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="premium-select">
                            <i class="bi bi-calendar"></i>
                            <select name="deleted" class="filter-select">
                                <option value="">Deleted When</option>
                                <option value="today" {{ request('deleted') == 'today' ? 'selected' : '' }}>Today
                                </option>
                                <option value="week" {{ request('deleted') == 'week' ? 'selected' : '' }}>This Week
                                </option>
                                <option value="month" {{ request('deleted') == 'month' ? 'selected' : '' }}>This
                                    Month</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="premium-select">
                            <i class="bi bi-sort-alpha-down"></i>
                            <select name="sort" class="filter-select">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest
                                    First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest
                                    First</option>
                                <option value="expiring" {{ request('sort') == 'expiring' ? 'selected' : '' }}>
                                    Expiring Soon</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="filter-actions">
                            <button type="submit" class="btn-apply w-100">
                                <i class="bi bi-funnel me-2"></i>
                                Apply Filters
                            </button>
                            <a href="{{ route('editor-jobs.trash') }}" class="btn-reset">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Stats Summary with Bulk Actions --}}
        <div class="stats-summary mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <p class="text-muted mb-0">
                    Showing <span class="fw-bold text-danger">{{ $jobs->firstItem() ?? 0 }}</span> to
                    <span class="fw-bold text-danger">{{ $jobs->lastItem() ?? 0 }}</span> of
                    <span class="fw-bold text-danger">{{ $jobs->total() }}</span> trashed jobs
                </p>
                <div class="bulk-actions">
                    <button class="btn-restore-all" onclick="restoreAll()">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                        Restore All
                    </button>
                    <button class="btn-empty-trash" onclick="emptyTrash()">
                        <i class="bi bi-trash3 me-2"></i>
                        Empty Trash
                    </button>
                </div>
            </div>
        </div>


        @if ($jobs->count())
            {{-- Premium Table --}}
            <div class="table-premium-card">
                <div class="card-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon">
                            <i class="bi bi-list-check"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Deleted Jobs List</h5>
                            <p class="header-subtitle">Complete list of permanently deleted job listings</p>
                        </div>
                    </div>
                    <div class="table-search">
                        <i class="bi bi-search"></i>
                        <input type="text" id="tableSearch" class="search-input" placeholder="Quick search...">
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-premium-wrapper">
                        <table class="table-premium" id="trashTable">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="checkbox" id="selectAll" class="select-checkbox">
                                            Job Details
                                        </div>
                                    </th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th>Deleted At</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobs as $job)
                                    <tr class="job-row" data-deleted="{{ $job->deleted_at }}">
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="checkbox" class="select-checkbox job-select"
                                                    value="{{ $job->id }}">
                                                <div class="job-info">
                                                    <div class="job-icon">
                                                        <i class="bi bi-file-text"></i>
                                                    </div>
                                                    <div>
                                                        <div class="job-title">{{ $job->title }}</div>
                                                        <div class="job-id">ID: #{{ $job->id }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="company-info">
                                                <span class="company-name">{{ $job->company_name }}</span>
                                                @if ($job->user)
                                                    <span class="employer-name small text-muted">by
                                                        {{ $job->user->name }}</span>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <span class="location">
                                                <i class="bi bi-geo-alt"></i>
                                                {{ $job->location }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="job-type-badge">{{ ucfirst($job->job_type) }}</span>
                                        </td>

                                        <td>
                                            <div class="deleted-date">
                                                <span class="date">{{ $job->deleted_at->format('d M Y') }}</span>
                                                <span class="time">{{ $job->deleted_at->format('h:i A') }}</span>
                                            </div>
                                        </td>

                                        <td>
                                            @php
                                                $daysLeft = 30 - $job->deleted_at->diffInDays(now());
                                                $status =
                                                    $daysLeft > 20
                                                        ? 'normal'
                                                        : ($daysLeft > 10
                                                            ? 'warning'
                                                            : 'critical');
                                            @endphp
                                            <div class="expiry-status status-{{ $status }}">
                                                <div class="expiry-days">{{ (int) $daysLeft }} days left</div>
                                                <div class="expiry-bar">
                                                    <div class="progress">
                                                        <div class="progress-bar"
                                                            style="width: {{ min(100, ((30 - $daysLeft) / 30) * 100) }}%;
                                                                    background: {{ $status == 'normal' ? '#10b981' : ($status == 'warning' ? '#f59e0b' : '#ef4444') }};">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-end">
                                            <div class="action-buttons">
                                                {{-- Restore --}}
                                                <form method="POST"
                                                    action="{{ route('editor-jobs.restore', $job->id) }}"
                                                    class="d-inline restore-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="action-btn restore"
                                                        title="Restore Job">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                    </button>
                                                </form>

                                                {{-- Permanent Delete --}}
                                                <form method="POST"
                                                    action="{{ route('editor-jobs.forceDelete', $job->id) }}"
                                                    class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn delete"
                                                        onclick="return confirm('Are you sure? This cannot be undone!')"
                                                        title="Permanently Delete">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>

                                                {{-- View Details --}}
                                                <button class="action-btn view" title="View Details"
                                                    onclick="viewJobDetails({{ $job->id }})">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Bulk Actions Bar --}}
                    <div class="bulk-actions-bar" id="bulkActions" style="display: none;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <span class="selected-count" id="selectedCount">0</span>
                                <span class="selected-label">jobs selected</span>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn-bulk-restore" onclick="bulkRestore()">
                                    <i class="bi bi-arrow-counterclockwise me-2"></i>
                                    Restore Selected
                                </button>
                                <button class="btn-bulk-delete" onclick="bulkDelete()">
                                    <i class="bi bi-trash me-2"></i>
                                    Delete Permanently
                                </button>
                                <button class="btn-bulk-cancel" onclick="clearSelection()">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Premium Pagination --}}
                    @if ($jobs->hasPages())
                        <div class="pagination-premium mt-4">
                            {{ $jobs->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Warning Banner --}}
            <div class="warning-banner mt-4">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Jobs are automatically permanently deleted after 30 days in trash. Currently,
                        <strong>{{ $jobs->filter(fn($job) => $job->deleted_at->diffInDays(now()) > 25)->count() }}</strong>
                        jobs are expiring soon.</span>
                </div>
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
                    No deleted jobs found. All jobs are currently active or have been permanently removed.
                </p>
                <div class="empty-illustration">
                    <i class="bi bi-recycle"></i>
                    <span>30-day recovery period</span>
                </div>
                <a href="{{ route('editor-jobs.index') }}" class="btn-browse mt-4">
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
                            <h5 class="fw-bold mb-1">About Editor Trash</h5>
                            <p class="text-muted mb-0">As an editor, you can view all deleted jobs across the platform.
                                Restore them or permanently delete them. Jobs are automatically removed after 30 days.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-light text-dark px-4 py-2 rounded-pill">
                        <i class="bi bi-shield me-2"></i>Editor Access Only

                        <div class="col-md-4 text-md-end">
                            <a href="{{ auth()->user()->dashboardRoute() }}" class="btn-manage mt-3">
                                <i class="bi bi-sliders2 me-2"></i>
                                Dashboard Settings
                            </a>
                        </div>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* Premium Admin Trash Styles */

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

        .last-updated {
            padding: 10px 24px;
            background: white;
            border-radius: 60px;
            color: #475569;
            border: 1px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* Alert Premium */
        .alert-premium-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 20px;
            padding: 1.2rem;
            color: #047857;
        }

        .alert-premium-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 20px;
            padding: 1.2rem;
            color: #b91c1c;
        }

        .alert-icon {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .alert-premium-success .alert-icon {
            color: #10b981;
        }

        .alert-premium-danger .alert-icon {
            color: #ef4444;
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

        .stat-icon.purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
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
            font-size: 1.8rem;
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

        .filter-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-apply {
            height: 52px;
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            color: white;
            border: none;
            border-radius: 60px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
        }

        .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(239, 68, 68, 0.3);
        }

        .btn-reset {
            width: 52px;
            height: 52px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            border-color: #ef4444;
            color: #ef4444;
            transform: rotate(90deg);
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
            padding: 10px 24px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            display: inline-flex;
            align-items: center;
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

        /* Table Premium Card */
        .table-premium-card {
            background: white;
            border-radius: 28px;
            border: 1px solid rgba(239, 68, 68, 0.1);
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
        }

        .table-premium-card .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            padding: 1.5rem;
            border-bottom: 1px solid rgba(239, 68, 68, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-subtitle {
            color: #64748b;
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        .table-search {
            position: relative;
        }

        .table-search i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .search-input {
            height: 48px;
            width: 250px;
            padding: 0 16px 0 48px;
            border: 1px solid #e2e8f0;
            border-radius: 60px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
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
            background: #f8fafc;
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

        /* Select Checkbox */
        .select-checkbox {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .select-checkbox:checked {
            background: #ef4444;
            border-color: #ef4444;
        }

        /* Job Info */
        .job-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .job-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
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
            margin-bottom: 2px;
        }

        .job-id {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .company-info {
            display: flex;
            flex-direction: column;
        }

        .company-name {
            font-weight: 500;
            color: #1e2937;
        }

        .employer-name {
            font-size: 0.75rem;
        }

        .location {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #475569;
        }

        .location i {
            color: #ef4444;
        }

        .job-type-badge {
            background: #f1f5f9;
            color: #475569;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 0.8rem;
        }

        .deleted-date {
            text-align: center;
        }

        .deleted-date .date {
            display: block;
            font-weight: 500;
            color: #1e2937;
            margin-bottom: 2px;
        }

        .deleted-date .time {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* Expiry Status */
        .expiry-status {
            min-width: 100px;
        }

        .expiry-days {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .status-normal .expiry-days {
            color: #10b981;
        }

        .status-warning .expiry-days {
            color: #f59e0b;
        }

        .status-critical .expiry-days {
            color: #ef4444;
        }

        .expiry-bar .progress {
            height: 4px;
            border-radius: 100px;
            background: #e2e8f0;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 6px;
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
            cursor: pointer;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .action-btn.restore:hover {
            border-color: #10b981;
            color: #10b981;
            box-shadow: 0 5px 10px rgba(16, 185, 129, 0.1);
        }

        .action-btn.delete:hover {
            border-color: #ef4444;
            color: #ef4444;
            box-shadow: 0 5px 10px rgba(239, 68, 68, 0.1);
        }

        .action-btn.view:hover {
            border-color: #3b82f6;
            color: #3b82f6;
            box-shadow: 0 5px 10px rgba(59, 130, 246, 0.1);
        }

        /* Bulk Actions */
        .bulk-actions-bar {
            background: white;
            border-radius: 60px;
            padding: 1rem 1.5rem;
            border: 1px solid #ef4444;
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.15);
            position: sticky;
            bottom: 2rem;
            z-index: 100;
            margin-top: 2rem;
        }

        .selected-count {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ef4444;
        }

        .selected-label {
            color: #475569;
            font-size: 1rem;
        }

        .btn-bulk-restore,
        .btn-bulk-delete,
        .btn-bulk-cancel {
            padding: 10px 20px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-bulk-restore {
            background: #d1fae5;
            color: #047857;
        }

        .btn-bulk-restore:hover {
            background: #10b981;
            color: white;
            transform: translateY(-2px);
        }

        .btn-bulk-delete {
            background: #ef4444;
            color: white;
        }

        .btn-bulk-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
        }

        .btn-bulk-cancel {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-bulk-cancel:hover {
            background: #e2e8f0;
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
            border-color: #ef4444;
            color: #ef4444;
        }

        .pagination-premium .page-item.active .page-link {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            border-color: transparent;
            color: white;
            box-shadow: 0 5px 10px rgba(239, 68, 68, 0.3);
        }

        /* Warning Banner */
        .warning-banner {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 60px;
            padding: 1rem 2rem;
            color: #92400e;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .warning-banner i {
            font-size: 1.5rem;
            color: #f59e0b;
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
            z-index: 9999;
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

            .bulk-actions {
                flex-direction: column;
            }

            .stats-summary .d-flex {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-premium-card .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-input {
                width: 100%;
            }
        }

        /* Manage Preferences Button */

        .btn-manage {
            display: inline-flex;
            align-items: center;
            padding: 12px 28px;
            background: white;
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 60px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-manage:hover {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        }
    </style>

    <script>
        // Table search functionality
        document.getElementById('tableSearch')?.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#trashTable tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Select all functionality
        const selectAll = document.getElementById('selectAll');
        const jobCheckboxes = document.querySelectorAll('.job-select');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');

        selectAll?.addEventListener('change', function() {
            jobCheckboxes.forEach(cb => {
                cb.checked = this.checked;
            });
            updateBulkActions();
        });

        jobCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checked = document.querySelectorAll('.job-select:checked');
            const count = checked.length;

            if (count > 0) {
                selectedCount.textContent = count;
                bulkActions.style.display = 'block';

                if (selectAll) {
                    selectAll.checked = count === jobCheckboxes.length;
                    selectAll.indeterminate = count > 0 && count < jobCheckboxes.length;
                }
            } else {
                bulkActions.style.display = 'none';
                if (selectAll) {
                    selectAll.checked = false;
                    selectAll.indeterminate = false;
                }
            }
        }

        function clearSelection() {
            jobCheckboxes.forEach(cb => {
                cb.checked = false;
            });
            updateBulkActions();
        }

        function bulkRestore() {
            const selected = Array.from(document.querySelectorAll('.job-select:checked')).map(cb => cb.value);
            if (selected.length === 0) return;

            if (confirm(`Restore ${selected.length} selected job(s)?`)) {
                alert(`Restoring ${selected.length} jobs...`);
                clearSelection();
            }
        }

        function bulkDelete() {
            const selected = Array.from(document.querySelectorAll('.job-select:checked')).map(cb => cb.value);
            if (selected.length === 0) return;

            if (confirm(`Permanently delete ${selected.length} selected job(s)? This action cannot be undone.`)) {
                alert(`Deleting ${selected.length} jobs...`);
                clearSelection();
            }
        }

        function restoreAll() {
            if (confirm('Are you sure you want to restore all trashed jobs?')) {
                alert('All jobs restored successfully');
            }
        }

        function emptyTrash() {
            if (confirm('Are you sure you want to permanently delete all jobs in trash? This action cannot be undone.')) {
                alert('Trash emptied successfully');
            }
        }

        function viewJobDetails(jobId) {
            alert(`Viewing details for job #${jobId}`);
        }

        // Delete confirmation for individual forms
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure? This cannot be undone!')) {
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
@endsection

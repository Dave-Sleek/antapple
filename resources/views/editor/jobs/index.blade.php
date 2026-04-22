@extends('layouts.app')
@section('content')
    <div class="container-fluid py-5 px-4">

        {{-- Premium Header --}}
        <div class="jobs-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-grid me-2"></i>JOB MANAGEMENT
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Jobs <span
                                    class="text-success">Overview</span></h1>
                            <p class="text-muted lead mb-0">Manage and monitor all job listings on the platform</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-actions">
                        <a href="{{ route('editor.dashboard') }}" class="btn-outline-premium me-2">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('editor-jobs.create') }}" class="btn-primary-premium">
                            <i class="bi bi-plus-circle me-2"></i>
                            <span>Post New Job</span>
                            <div class="btn-glow"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Jobs</span>
                        <span class="stat-value">{{ $jobs->total() }}</span>
                        <span class="stat-trend positive">
                            <i class="bi bi-arrow-up"></i> +{{ $newJobsThisMonth ?? 0 }} this month
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Approved</span>
                        <span class="stat-value">{{ $approvedJobs ?? $jobs->where('status', 'active')->count() }}</span>
                        <span class="stat-trend">
                            {{ round((($approvedJobs ?? 0) / max($jobs->total(), 1)) * 100) }}% of total
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon yellow">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Pending</span>
                        <span class="stat-value">{{ $pendingJobs ?? $jobs->where('status', 'pending')->count() }}</span>
                        <span class="stat-trend warning">
                            Needs review
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="bi bi-eye"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Views</span>
                        <span class="stat-value">{{ number_format($totalViews ?? 0) }}</span>
                        <span class="stat-trend">
                            {{ $uniqueViewers ?? 0 }} unique viewers
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="filter-premium-card mb-5">
            <div class="filter-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="filter-icon">
                        <i class="bi bi-sliders2"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Filter Jobs</h5>
                        <p class="filter-subtitle">Refine job listings with advanced filters</p>
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
                            <i class="bi bi-flag"></i>
                            <select name="status" class="filter-select">
                                <option value="">All Status</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="premium-select">
                            <i class="bi bi-star"></i>
                            <select name="type" class="filter-select">
                                <option value="">All Types</option>
                                <option value="featured" {{ request('type') == 'featured' ? 'selected' : '' }}>Featured
                                </option>
                                <option value="standard" {{ request('type') == 'standard' ? 'selected' : '' }}>Standard
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="premium-select">
                            <i class="bi bi-building"></i>
                            <select name="employer" class="filter-select">
                                <option value="">All Employers</option>
                                @foreach ($employers ?? [] as $employer)
                                    <option value="{{ $employer->id }}"
                                        {{ request('employer') == $employer->id ? 'selected' : '' }}>
                                        {{ $employer->company_name ?? $employer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="filter-actions">
                            <button type="submit" class="btn-apply w-100">
                                <i class="bi bi-funnel me-2"></i>
                                Apply Filters
                            </button>
                            <a href="{{ route('jobs.index') }}" class="btn-reset">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Jobs Table --}}
        <div class="jobs-premium-card">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Job Listings</h5>
                        <p class="header-subtitle">Complete list of all jobs on the platform</p>
                    </div>
                </div>
                <div class="table-actions">

                    <a href="{{ route('editor-jobs.drafts') }}" class="btn-apply w-100">
                        <i class="bi bi-clipboard me-2"></i>
                        Drafts
                    </a>

                    <a href="{{ route('editor-jobs.trash') }}" class="btn-trash">
                        <i class="bi bi-trash me-2"></i>
                        View Trash
                        <span class="badge bg-danger me-2">
                            {{ \App\Models\Job_post::onlyTrashed()->count() }}
                        </span>
                    </a>

                    <div class="table-search">
                        <i class="bi bi-search"></i>
                        <input type="text" id="tableSearch" class="search-input" placeholder="Quick search...">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-premium-wrapper">
                    <table class="table-premium" id="jobsTable">
                        <thead>
                            <tr>
                                <th>Job Details</th>
                                <th>Company</th>
                                <th>Status</th>
                                <th>Ownership</th>
                                <th>Analytics</th>
                                <th>Posted Date</th>
                                <th>Draft</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobs as $job)
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
                                                    <span><i class="bi bi-clock"></i> {{ $job->job_type }}</span>
                                                    @if ($job->is_featured)
                                                        <span class="featured-tag"><i class="bi bi-star-fill"></i>
                                                            Featured</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="company-info">
                                            <div class="company-avatar">
                                                @if ($job->company_logo)
                                                    <img src="{{ asset('storage/' . $job->company_logo) }}"
                                                        alt="{{ $job->company_name }}">
                                                @else
                                                    <span class="avatar-initials">
                                                        {{ substr($job->company_name, 0, 1) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="company-name">{{ $job->company_name }}</div>
                                                <div class="company-email">{{ $job->employer->email ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            $statusClasses = [
                                                'approved' => [
                                                    'bg' => '#d1fae5',
                                                    'text' => '#047857',
                                                    'dot' => '#10b981',
                                                ],
                                                'pending' => [
                                                    'bg' => '#fef3c7',
                                                    'text' => '#92400e',
                                                    'dot' => '#f59e0b',
                                                ],
                                                'rejected' => [
                                                    'bg' => '#fee2e2',
                                                    'text' => '#b91c1c',
                                                    'dot' => '#ef4444',
                                                ],
                                            ];
                                            $status = $statusClasses[$job->status] ?? [
                                                'bg' => '#f1f5f9',
                                                'text' => '#475569',
                                                'dot' => '#94a3b8',
                                            ];
                                        @endphp
                                        <span class="status-badge"
                                            style="background: {{ $status['bg'] }}; color: {{ $status['text'] }};">
                                            <span class="status-dot" style="background: {{ $status['dot'] }};"></span>
                                            {{ ucfirst($job->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($job->user_id === auth()->id())
                                            <span class="badge bg-success">Your Job</span>
                                        @else
                                            <span class="badge bg-secondary">Team Job</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="analytics-stats">
                                            <div class="analytics-item" title="Clicks">
                                                <i class="bi bi-bar-chart"></i>
                                                <span>{{ $job->clicks_count ?? 0 }}</span>
                                            </div>
                                            <div class="analytics-item" title="Applications">
                                                <i class="bi bi-people"></i>
                                                <span>{{ $job->applications_count ?? 0 }}</span>
                                            </div>
                                            <div class="analytics-item" title="Views">
                                                <i class="bi bi-eye"></i>
                                                <span>{{ $job->job_views_count ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="posted-date">
                                            <span class="date">{{ $job->created_at->format('d M Y') }}</span>
                                            <span class="time">{{ $job->created_at->format('h:i A') }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($job->status === 'draft')
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="action-buttons">
                                            <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => Str::slug($job->title)]) }}"
                                                class="action-btn view" title="View Job" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('editor-jobs.edit', $job) }}" class="action-btn edit"
                                                title="Edit Job">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <div class="dropdown d-inline">
                                                <button class="action-btn more" type="button" data-bs-toggle="dropdown"
                                                    title="More Actions">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu premium-dropdown">
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="changeStatus({{ $job->id }}, 'approved')">
                                                            <i class="bi bi-check-circle me-2 text-success"></i>
                                                            Approve
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="changeStatus({{ $job->id }}, 'pending')">
                                                            <i class="bi bi-clock me-2 text-warning"></i>
                                                            Mark Pending
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="changeStatus({{ $job->id }}, 'rejected')">
                                                            <i class="bi bi-x-circle me-2 text-danger"></i>
                                                            Reject
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            onclick="toggleFeatured(event, '{{ route('admin.jobs.toggleFeatured', [$job->uuid, Str::slug($job->title)]) }}', '{{ $job->uuid }}')">

                                                            <i class="bi bi-star me-2 text-warning"></i>
                                                            <span id="featured-text-{{ $job->uuid }}">
                                                                {{ $job->is_featured ? 'Remove Featured' : 'Mark as Featured' }}
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('editor-jobs.destroy', $job) }}"
                                                            method="POST" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bi bi-trash me-2"></i>
                                                                Delete Job
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="bi bi-briefcase"></i>
                                            </div>
                                            <h5 class="fw-bold mb-2">No Jobs Found</h5>
                                            <p class="text-muted mb-4">No job listings match your current filters</p>
                                            <a href="{{ route('editor-jobs.create') }}" class="btn-primary-premium">
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

                {{-- Premium Pagination --}}
                @if ($jobs->hasPages())
                    <div class="pagination-premium mt-4">
                        {{ $jobs->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Bulk Actions Bar --}}
        <div class="bulk-actions-bar mt-4" id="bulkActions" style="display: none;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <span class="selected-count" id="selectedCount">0</span>
                    <span class="selected-label">jobs selected</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn-bulk-approve" onclick="bulkApprove()">
                        <i class="bi bi-check-circle me-2"></i>
                        Approve Selected
                    </button>
                    <button class="btn-bulk-delete" onclick="bulkDelete()">
                        <i class="bi bi-trash me-2"></i>
                        Delete Selected
                    </button>
                    <button class="btn-bulk-cancel" onclick="clearSelection()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFeatured(event, fullUrl, uuid) {
            event.preventDefault();

            fetch(fullUrl, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // We use the uuid passed separately to find the correct span
                        const textElement = document.getElementById(`featured-text-${uuid}`);
                        if (textElement) {
                            textElement.innerText = data.is_featured ? "Remove Featured" : "Mark as Featured";
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Admin Jobs Management Styles */

    /* Header */
    .jobs-header {
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

    .btn-primary-premium {
        position: relative;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        padding: 16px 36px;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
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

    .btn-outline-premium {
        display: inline-flex;
        align-items: center;
        padding: 16px 32px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-premium:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.1);
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

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
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
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .stat-icon.green {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .stat-icon.yellow {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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

    .stat-trend.positive {
        color: #10b981;
    }

    .stat-trend.warning {
        color: #f59e0b;
    }

    /* Filter Bar */
    .filter-premium-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .filter-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .filter-icon {
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
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        background: white;
    }

    .filter-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-apply {
        height: 52px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-apply:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
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

    /* Jobs Card */
    .jobs-premium-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .jobs-premium-card .card-header {
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

    .table-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .btn-export {
        padding: 12px 24px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-export:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
    }

    .btn-trash {
        padding: 12px 24px;
        background: #ef4444;
        color: white;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-trash:hover {
        border-color: #ef4444;
        color: white;
        background: #dc2626;
    }

    .btn-export:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
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
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .jobs-premium-card .card-body {
        padding: 1.5rem;
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

    /* Job Info */
    .job-info {
        display: flex;
        align-items: center;
        gap: 12px;
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
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.2);
    }

    .job-title {
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 4px;
    }

    .job-meta {
        display: flex;
        gap: 12px;
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .job-meta i {
        margin-right: 2px;
    }

    .featured-tag {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        padding: 2px 8px;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 2px;
    }

    /* Company Info */
    .company-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .company-avatar {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        overflow: hidden;
    }

    .company-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-initials {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .company-name {
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 2px;
    }

    .company-email {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 60px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    /* Analytics Stats */
    .analytics-stats {
        display: flex;
        gap: 1rem;
    }

    .analytics-item {
        display: flex;
        align-items: center;
        gap: 4px;
        color: #64748b;
        font-size: 0.9rem;
    }

    .analytics-item i {
        color: #10b981;
    }

    /* Posted Date */
    .posted-date {
        text-align: center;
    }

    .posted-date .date {
        display: block;
        font-weight: 500;
        color: #1e2937;
        margin-bottom: 2px;
    }

    .posted-date .time {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .action-btn {
        width: 38px;
        height: 38px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
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

    .action-btn.view:hover {
        border-color: #10b981;
        color: #10b981;
        box-shadow: 0 5px 10px rgba(16, 185, 129, 0.1);
    }

    .action-btn.edit:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        box-shadow: 0 5px 10px rgba(59, 130, 246, 0.1);
    }

    .action-btn.more:hover {
        border-color: #8b5cf6;
        color: #8b5cf6;
        box-shadow: 0 5px 10px rgba(139, 92, 246, 0.1);
    }

    /* Premium Dropdown */
    .premium-dropdown {
        border: none;
        border-radius: 20px;
        padding: 12px 8px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        min-width: 200px;
    }

    .premium-dropdown .dropdown-item {
        padding: 10px 16px;
        border-radius: 12px;
        margin: 4px 8px;
        color: #374151;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .premium-dropdown .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(4, 120, 87, 0.05) 100%);
        color: #10b981;
        transform: translateX(5px);
    }

    .premium-dropdown .dropdown-item i {
        width: 20px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f8fafc;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #94a3b8;
        margin: 0 auto 1.5rem;
        border: 1px solid #e2e8f0;
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
    }

    .pagination-premium .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 5px 10px rgba(16, 185, 129, 0.3);
    }

    /* Bulk Actions */
    .bulk-actions-bar {
        background: white;
        border-radius: 60px;
        padding: 1rem 1.5rem;
        border: 1px solid #10b981;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.15);
        position: sticky;
        bottom: 2rem;
        z-index: 100;
    }

    .selected-count {
        font-size: 1.5rem;
        font-weight: 700;
        color: #10b981;
    }

    .selected-label {
        color: #475569;
        font-size: 1rem;
    }

    .btn-bulk-approve,
    .btn-bulk-delete,
    .btn-bulk-cancel {
        padding: 10px 20px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-bulk-approve {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
    }

    .btn-bulk-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-bulk-delete {
        background: #ef4444;
        color: white;
    }

    .btn-bulk-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
    }

    .btn-bulk-cancel {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-bulk-cancel:hover {
        background: #e2e8f0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-actions {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .filter-actions {
            flex-direction: column;
        }

        .table-actions {
            flex-direction: column;
            width: 100%;
        }

        .search-input {
            width: 100%;
        }

        .jobs-premium-card .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .analytics-stats {
            flex-direction: column;
            gap: 0.25rem;
        }
    }
</style>

<script>
    // Table search functionality
    document.getElementById('tableSearch')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#jobsTable tbody tr:not(.empty-state-row)');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Bulk selection
    let selectedJobs = new Set();

    function toggleJobSelection(jobId, checkbox) {
        if (checkbox.checked) {
            selectedJobs.add(jobId);
        } else {
            selectedJobs.delete(jobId);
        }

        updateBulkActions();
    }

    function updateBulkActions() {
        const bulkBar = document.getElementById('bulkActions');
        const countSpan = document.getElementById('selectedCount');

        if (selectedJobs.size > 0) {
            countSpan.textContent = selectedJobs.size;
            bulkBar.style.display = 'block';
        } else {
            bulkBar.style.display = 'none';
        }
    }

    function clearSelection() {
        selectedJobs.clear();
        document.querySelectorAll('.job-select').forEach(cb => {
            cb.checked = false;
        });
        updateBulkActions();
    }

    function bulkApprove() {
        if (selectedJobs.size === 0) return;

        if (confirm(`Approve ${selectedJobs.size} selected job(s)?`)) {
            // Implement bulk approve logic
            console.log('Approving:', Array.from(selectedJobs));
            clearSelection();
        }
    }

    function bulkDelete() {
        if (selectedJobs.size === 0) return;

        if (confirm(`Delete ${selectedJobs.size} selected job(s)? This action cannot be undone.`)) {
            // Implement bulk delete logic
            console.log('Deleting:', Array.from(selectedJobs));
            clearSelection();
        }
    }

    // Change job status
    function changeStatus(jobId, status) {
        if (confirm(`Change job status to ${status}?`)) {
            // Implement status change via AJAX
            console.log('Changing status:', jobId, status);
            // Show success message
            alert(`Job status updated to ${status}`);
        }
    }

    // Export jobs
    function exportJobs() {
        // Implement export functionality
        alert('Exporting jobs...');
    }

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this job? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
</script>

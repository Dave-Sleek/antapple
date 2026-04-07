@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-5 px-4">

        {{-- Premium Header --}}
        <div class="users-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                            <div class="header-icon-ring"></div>
                        </div>
                        <div>
                            <span class="badge bg-primary-subtle text-primary px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-shield-lock me-2"></i>ADMIN PANEL
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">User <span
                                    class="text-gradient">Management</span></h1>
                            <p class="text-muted lead mb-0">Manage system users, roles, and permissions</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-actions">
                        <a href="{{ route('admin.users.create') }}" class="btn-primary-premium">
                            <i class="bi bi-plus-circle me-2"></i>
                            <span>Add New User</span>
                            <div class="btn-glow"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Success Alert --}}
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

        {{-- Stats Overview --}}
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Users</span>
                        {{-- <span class="stat-value">{{ $users->total() }}</span> --}}
                        <span class="stat-trend">
                            <i class="bi bi-arrow-up"></i> +{{ $newUsersThisMonth ?? 12 }} this month
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Employers</span>
                        <span class="stat-value">{{ $employerCount ?? $users->where('role', 'employer')->count() }}</span>
                        <span class="stat-trend">
                            {{-- {{ round((($employerCount ?? 0) / max($users->total(), 1)) * 100) }}% of users --}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Admins</span>
                        <span class="stat-value">{{ $adminCount ?? $users->where('role', 'admin')->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Job Seekers</span>
                        <span class="stat-value">{{ $seekerCount ?? $users->where('role', 'seeker')->count() }}</span>
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
                        <h5 class="fw-bold mb-1">Filter Users</h5>
                        <p class="filter-subtitle">Refine user list with advanced filters</p>
                    </div>
                </div>
            </div>

            <form method="GET" class="filter-body" id="filterForm">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-search"></i>
                            <input type="text" name="search" class="filter-input" value="{{ request('search') }}"
                                placeholder="Search by name or email">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="premium-select">
                            <i class="bi bi-tag"></i>
                            <select name="role" class="filter-select">
                                <option value="">All Roles</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="employer" {{ request('role') == 'employer' ? 'selected' : '' }}>Employer
                                </option>
                                <option value="seeker" {{ request('role') == 'seeker' ? 'selected' : '' }}>Job Seeker
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="premium-select">
                            <i class="bi bi-calendar"></i>
                            <select name="joined" class="filter-select">
                                <option value="">Join Date</option>
                                <option value="today" {{ request('joined') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ request('joined') == 'week' ? 'selected' : '' }}>This Week
                                </option>
                                <option value="month" {{ request('joined') == 'month' ? 'selected' : '' }}>This Month
                                </option>
                                <option value="year" {{ request('joined') == 'year' ? 'selected' : '' }}>This Year
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="premium-select">
                            <i class="bi bi-sort-alpha-down"></i>
                            <select name="sort" class="filter-select">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First
                                </option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First
                                </option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z
                                </option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="filter-actions">
                            <button type="submit" class="btn-apply w-100">
                                <i class="bi bi-funnel me-2"></i>
                                Apply Filters
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn-reset">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Users Table Card --}}
        <div class="users-table-card">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">System Users</h5>
                        <p class="header-subtitle">Complete list of all registered users</p>
                    </div>
                </div>
                <div class="table-actions">
                    <button class="btn-export" onclick="exportUsers()">
                        <i class="bi bi-download me-2"></i>
                        Export CSV
                    </button>
                    <div class="table-search">
                        <i class="bi bi-search"></i>
                        <input type="text" id="tableSearch" class="search-input" placeholder="Quick search...">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-premium-wrapper">
                    <table class="table-premium" id="usersTable">
                        <thead>
                            <tr>
                                <th>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="checkbox" id="selectAll" class="select-checkbox">
                                        User
                                    </div>
                                </th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Last Active</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="user-row">
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <input type="checkbox" class="select-checkbox user-select"
                                                value="{{ $user->id }}">
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    @if ($user->avatar)
                                                        <img src="{{ asset('storage/' . $user->avatar) }}"
                                                            alt="{{ $user->name }}">
                                                    @else
                                                        <span class="avatar-initials">
                                                            {{ collect(explode(' ', $user->name))->map(function ($part) {return strtoupper(substr($part, 0, 1));})->take(2)->join('') }}
                                                        </span>
                                                    @endif
                                                    <span
                                                        class="avatar-status {{ $user->is_online ? 'online' : 'offline' }}"></span>
                                                </div>
                                                <div>
                                                    <div class="user-name">{{ $user->name }}</div>
                                                    @if ($user->company_name)
                                                        <div class="user-company">{{ $user->company_name }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="user-email">
                                            <i class="bi bi-envelope"></i>
                                            {{ $user->email }}
                                            @if ($user->email_verified_at)
                                                <i class="bi bi-patch-check-fill text-success ms-1"
                                                    title="Verified Email"></i>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            $roleColors = [
                                                'admin' => ['bg' => '#fee2e2', 'text' => '#b91c1c', 'dot' => '#ef4444'],
                                                'employer' => [
                                                    'bg' => '#d1fae5',
                                                    'text' => '#047857',
                                                    'dot' => '#10b981',
                                                ],
                                                'seeker' => [
                                                    'bg' => '#dbeafe',
                                                    'text' => '#1e40af',
                                                    'dot' => '#3b82f6',
                                                ],
                                            ];
                                            $color = $roleColors[$user->role] ?? [
                                                'bg' => '#f1f5f9',
                                                'text' => '#475569',
                                                'dot' => '#94a3b8',
                                            ];
                                        @endphp
                                        <span class="role-badge"
                                            style="background: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                                            <span class="role-dot" style="background: {{ $color['dot'] }};"></span>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($user->is_active ?? true)
                                            <span class="status-badge active">
                                                <span class="status-dot"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="status-badge inactive">
                                                <span class="status-dot"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="joined-date">
                                            <span class="date">{{ $user->created_at->format('d M Y') }}</span>
                                            <span class="time">{{ $user->created_at->format('h:i A') }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="last-active">
                                            @if ($user->last_activity)
                                                {{ \Carbon\Carbon::parse($user->last_activity)->diffForHumans() }}
                                            @else
                                                <span class="text-muted">Never</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="text-end">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="action-btn view"
                                                title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn edit"
                                                title="Edit User">
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
                                                            onclick="impersonateUser({{ $user->id }})">
                                                            <i class="bi bi-person-badge me-2"></i>
                                                            Impersonate
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="sendPasswordReset({{ $user->id }})">
                                                            <i class="bi bi-key me-2"></i>
                                                            Reset Password
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                            method="POST" class="delete-form d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bi bi-trash me-2"></i>
                                                                Delete User
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
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
                            <span class="selected-label">users selected</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn-bulk-active" onclick="bulkAction('activate')">
                                <i class="bi bi-check-circle me-2"></i>
                                Activate
                            </button>
                            <button class="btn-bulk-deactivate" onclick="bulkAction('deactivate')">
                                <i class="bi bi-pause-circle me-2"></i>
                                Deactivate
                            </button>
                            <button class="btn-bulk-delete" onclick="bulkAction('delete')">
                                <i class="bi bi-trash me-2"></i>
                                Delete
                            </button>
                            <button class="btn-bulk-cancel" onclick="clearSelection()">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Pagination --}}
                {{-- @if ($users->hasPages()) --}}
                <div class="pagination-premium mt-4">
                    {{ $employers->withQueryString()->links() }}
                </div>
                {{-- @endif --}}
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="quick-actions-grid mt-5">
            <div class="quick-action-card">
                <i class="bi bi-envelope"></i>
                <h6>Email All Users</h6>
                <p>Send broadcast message</p>
                <button class="stretched-link" onclick="emailAllUsers()"></button>
            </div>

            <div class="quick-action-card">
                <i class="bi bi-download"></i>
                <h6>Export Reports</h6>
                <p>User activity report</p>
                <button class="stretched-link" onclick="exportReport()"></button>
            </div>

            <div class="quick-action-card">
                <i class="bi bi-shield"></i>
                <h6>Security Audit</h6>
                <p>Review user permissions</p>
                <button class="stretched-link" onclick="securityAudit()"></button>
            </div>

            <div class="quick-action-card">
                <i class="bi bi-graph-up"></i>
                <h6>Analytics</h6>
                <p>User growth metrics</p>
                <button class="stretched-link" onclick="viewAnalytics()"></button>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Admin Users Management Styles */

    /* Header */
    .users-header {
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
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: white;
        position: relative;
        z-index: 2;
        box-shadow: 0 15px 30px rgba(59, 130, 246, 0.3);
    }

    .header-icon-glow {
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.4) 0%, transparent 70%);
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
        border: 2px solid rgba(59, 130, 246, 0.2);
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
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .header-actions {
        display: flex;
        justify-content: flex-end;
    }

    .btn-primary-premium {
        position: relative;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
        box-shadow: 0 15px 30px rgba(59, 130, 246, 0.3);
        border: none;
    }

    .btn-primary-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(59, 130, 246, 0.4);
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

    /* Success Alert */
    .alert-premium-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 20px;
        padding: 1.2rem;
        color: #047857;
    }

    .alert-icon {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: #10b981;
        font-size: 1.1rem;
        flex-shrink: 0;
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
        border-color: #3b82f6;
        box-shadow: 0 20px 40px rgba(59, 130, 246, 0.1);
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

    .stat-icon.purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .stat-icon.orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
        color: #10b981;
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
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        background: white;
    }

    .filter-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-apply {
        height: 52px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
    }

    .btn-apply:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(59, 130, 246, 0.3);
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

    /* Users Table Card */
    .users-table-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .users-table-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
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
        border-color: #3b82f6;
        color: #3b82f6;
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
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
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

    .user-row {
        transition: all 0.3s ease;
    }

    .user-row:hover {
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
        background: #3b82f6;
        border-color: #3b82f6;
    }

    /* User Info */
    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        position: relative;
        overflow: hidden;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-initials {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .avatar-status {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .avatar-status.online {
        background: #10b981;
        animation: pulse 2s infinite;
    }

    .avatar-status.offline {
        background: #94a3b8;
    }

    .user-name {
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 2px;
    }

    .user-company {
        font-size: 0.75rem;
        color: #64748b;
    }

    .user-email {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #475569;
        font-size: 0.9rem;
    }

    .user-email i {
        color: #94a3b8;
    }

    /* Role Badge */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 60px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .role-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
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

    .status-badge.active {
        background: #d1fae5;
        color: #047857;
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

    .status-badge.inactive .status-dot {
        background: #ef4444;
    }

    /* Joined Date */
    .joined-date {
        text-align: center;
    }

    .joined-date .date {
        display: block;
        font-weight: 500;
        color: #1e2937;
        margin-bottom: 2px;
    }

    .joined-date .time {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .last-active {
        font-size: 0.9rem;
        color: #475569;
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

    .action-btn.view:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        box-shadow: 0 5px 10px rgba(59, 130, 246, 0.1);
    }

    .action-btn.edit:hover {
        border-color: #f59e0b;
        color: #f59e0b;
        box-shadow: 0 5px 10px rgba(245, 158, 11, 0.1);
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
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(29, 78, 216, 0.05) 100%);
        color: #3b82f6;
        transform: translateX(5px);
    }

    .premium-dropdown .dropdown-item.text-danger:hover {
        background: rgba(239, 68, 68, 0.05);
        color: #ef4444;
    }

    .premium-dropdown .dropdown-item i {
        width: 20px;
    }

    /* Bulk Actions */
    .bulk-actions-bar {
        background: white;
        border-radius: 60px;
        padding: 1rem 1.5rem;
        border: 1px solid #3b82f6;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.15);
        position: sticky;
        bottom: 2rem;
        z-index: 100;
        margin-top: 2rem;
    }

    .selected-count {
        font-size: 1.5rem;
        font-weight: 700;
        color: #3b82f6;
    }

    .selected-label {
        color: #475569;
        font-size: 1rem;
    }

    .btn-bulk-active,
    .btn-bulk-deactivate,
    .btn-bulk-delete,
    .btn-bulk-cancel {
        padding: 10px 20px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-bulk-active {
        background: #d1fae5;
        color: #047857;
    }

    .btn-bulk-active:hover {
        background: #10b981;
        color: white;
        transform: translateY(-2px);
    }

    .btn-bulk-deactivate {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-bulk-deactivate:hover {
        background: #ef4444;
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
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .pagination-premium .page-item.active .page-link {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 5px 10px rgba(59, 130, 246, 0.3);
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
        cursor: pointer;
    }

    .quick-action-card:hover {
        transform: translateY(-5px);
        border-color: #3b82f6;
        box-shadow: 0 20px 30px rgba(59, 130, 246, 0.1);
    }

    .quick-action-card i {
        font-size: 2rem;
        color: #3b82f6;
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

    .quick-action-card .stretched-link {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0;
        cursor: pointer;
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

        .users-table-card .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<script>
    // Table search functionality
    document.getElementById('tableSearch')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#usersTable tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Select all functionality
    const selectAll = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-select');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');

    selectAll?.addEventListener('change', function() {
        userCheckboxes.forEach(cb => {
            cb.checked = this.checked;
        });
        updateBulkActions();
    });

    userCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        const checked = document.querySelectorAll('.user-select:checked');
        const count = checked.length;

        if (count > 0) {
            selectedCount.textContent = count;
            bulkActions.style.display = 'block';

            // Update select all state
            if (selectAll) {
                selectAll.checked = count === userCheckboxes.length;
                selectAll.indeterminate = count > 0 && count < userCheckboxes.length;
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
        userCheckboxes.forEach(cb => {
            cb.checked = false;
        });
        updateBulkActions();
    }

    function bulkAction(action) {
        const selected = Array.from(document.querySelectorAll('.user-select:checked')).map(cb => cb.value);

        if (selected.length === 0) return;

        let message = '';
        let confirmMessage = '';

        switch (action) {
            case 'activate':
                message = `Activate ${selected.length} user(s)?`;
                confirmMessage = 'Users activated successfully';
                break;
            case 'deactivate':
                message = `Deactivate ${selected.length} user(s)?`;
                confirmMessage = 'Users deactivated successfully';
                break;
            case 'delete':
                message = `Delete ${selected.length} user(s)? This action cannot be undone.`;
                confirmMessage = 'Users deleted successfully';
                break;
        }

        if (confirm(message)) {
            // Here you would make an AJAX call to perform the bulk action
            console.log(`Bulk ${action}:`, selected);
            alert(confirmMessage);
            clearSelection();
        }
    }

    // Export users
    function exportUsers() {
        alert('Exporting users...');
    }

    // Impersonate user
    function impersonateUser(userId) {
        if (confirm('Impersonate this user? You can revert back from the admin panel.')) {
            alert(`Impersonating user ${userId}`);
        }
    }

    // Send password reset
    function sendPasswordReset(userId) {
        if (confirm('Send password reset email to this user?')) {
            alert(`Password reset email sent to user ${userId}`);
        }
    }

    // Quick actions
    function emailAllUsers() {
        alert('Email all users feature coming soon!');
    }

    function exportReport() {
        alert('Export report feature coming soon!');
    }

    function securityAudit() {
        alert('Security audit feature coming soon!');
    }

    function viewAnalytics() {
        alert('Analytics feature coming soon!');
    }

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
</script>

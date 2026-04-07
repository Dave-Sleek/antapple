@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-5 px-4">

        {{-- Premium Header --}}
        <div class="logs-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-activity"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                            <div class="header-icon-ring"></div>
                        </div>
                        <div>
                            <span class="badge bg-primary-subtle text-primary px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-shield-lock me-2"></i>SECURITY MONITORING
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">User Activity <span
                                    class="text-gradient">Logs</span></h1>
                            <p class="text-muted lead mb-0">Track and monitor all user activities across the platform</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-actions">
                        <div class="live-indicator">
                            <span class="live-dot"></span>
                            <span class="live-text">Live Monitoring</span>
                        </div>
                        <button class="btn-export" onclick="exportLogs()">
                            <i class="bi bi-download me-2"></i>
                            Export Logs
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Activities</span>
                        <span class="stat-value">{{ $logs->total() }}</span>
                        <span class="stat-trend">
                            <i class="bi bi-arrow-up"></i> Last 30 days
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Unique Users</span>
                        <span class="stat-value">{{ $logs->pluck('user_id')->unique()->count() }}</span>
                        <span class="stat-trend">Active users</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="bi bi-globe"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Unique IPs</span>
                        <span class="stat-value">{{ $logs->pluck('ip_address')->unique()->count() }}</span>
                        <span class="stat-trend">Different locations</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="bi bi-phone"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Devices</span>
                        <span class="stat-value">{{ $logs->pluck('user_agent')->unique()->count() }}</span>
                        <span class="stat-trend">Unique user agents</span>
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
                        <h5 class="fw-bold mb-1">Filter Activity Logs</h5>
                        <p class="filter-subtitle">Refine logs with advanced filters</p>
                    </div>
                </div>
            </div>

            <form method="GET" class="filter-body" id="filterForm">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-person"></i>
                            <input type="text" name="user_id" class="filter-input" value="{{ request('user_id') }}"
                                placeholder="User ID">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-ip"></i>
                            <input type="text" name="ip" class="filter-input" value="{{ request('ip') }}"
                                placeholder="IP Address">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-ip"></i>
                            <input type="text" name="endpoint" class="filter-input" value="{{ request('endpoint') }}"
                                placeholder="Endpoint">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="premium-select">
                            <i class="bi bi-grid"></i>
                            <select name="method" class="filter-select">
                                <option value="">All Methods</option>
                                <option value="GET" {{ request('method') == 'GET' ? 'selected' : '' }}>GET</option>
                                <option value="POST" {{ request('method') == 'POST' ? 'selected' : '' }}>POST</option>
                                <option value="PUT" {{ request('method') == 'PUT' ? 'selected' : '' }}>PUT</option>
                                <option value="DELETE" {{ request('method') == 'DELETE' ? 'selected' : '' }}>DELETE
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-calendar"></i>
                            <input type="date" name="from" class="filter-input" value="{{ request('from') }}"
                                placeholder="From Date">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-calendar-check"></i>
                            <input type="date" name="to" class="filter-input" value="{{ request('to') }}"
                                placeholder="To Date">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="filter-actions">
                            <button type="submit" class="btn-apply">
                                <i class="bi bi-funnel me-2"></i>
                                Apply Filters
                            </button>
                            <a href="{{ route('admin.user_logs.index') }}" class="btn-reset">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Stats Summary --}}
        <div class="stats-summary mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted mb-0">
                    Showing <span class="fw-bold text-primary">{{ $logs->firstItem() ?? 0 }}</span> to
                    <span class="fw-bold text-primary">{{ $logs->lastItem() ?? 0 }}</span> of
                    <span class="fw-bold text-primary">{{ $logs->total() }}</span> activity logs
                </p>
                <div class="view-toggle">
                    <button class="view-btn active" onclick="setView('table')">
                        <i class="bi bi-table"></i>
                    </button>
                    <button class="view-btn" onclick="setView('cards')">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Table View --}}
        <div class="table-view" id="tableView">
            <div class="logs-table-card">
                <div class="card-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon">
                            <i class="bi bi-list-check"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Activity Logs</h5>
                            <p class="header-subtitle">Detailed log of all user activities</p>
                        </div>
                    </div>
                    <div class="table-search">
                        <i class="bi bi-search"></i>
                        <input type="text" id="tableSearch" class="search-input" placeholder="Search logs...">
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-premium-wrapper">
                        <table class="table-premium">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>IP Address</th>
                                    <th>Endpoint</th>
                                    <th>Method</th>
                                    <th>Device</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody id="logsTableBody">
                                @include('admin.user_logs.partials.logs_table', ['logs' => $logs])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cards View --}}
        <div class="cards-view" id="cardsView" style="display: none;">
            <div class="logs-grid">
                @foreach ($logs as $log)
                    @php
                        $user = App\Models\User::find($log->user_id);
                    @endphp
                    <div class="log-card">
                        <div class="card-header">
                            <div class="method-indicator method-{{ strtolower($log->method) }}">
                                {{ $log->method }}
                            </div>
                            <span class="time-badge">{{ $log->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="card-body">
                            <div class="user-section">
                                <div class="user-avatar large">
                                    <span class="avatar-initials">{{ $user ? substr($user->name, 0, 1) : '?' }}</span>
                                </div>
                                <div class="user-details">
                                    <h6>{{ $user->name ?? 'Unknown User' }}</h6>
                                    <span class="user-id">ID: {{ $log->user_id }}</span>
                                </div>
                            </div>

                            <div class="log-details">
                                <div class="detail-item">
                                    <i class="bi bi-link"></i>
                                    <div class="detail-content">
                                        <span class="detail-label">Endpoint</span>
                                        <span class="detail-value">{{ $log->endpoint }}</span>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="bi bi-ip"></i>
                                    <div class="detail-content">
                                        <span class="detail-label">IP Address</span>
                                        <span class="detail-value">{{ $log->ip_address }}</span>
                                        <span
                                            class="detail-location">{{ getLocationFromIP($log->ip_address) ?? 'Unknown location' }}</span>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="bi bi-phone"></i>
                                    <div class="detail-content">
                                        <span class="detail-label">Device</span>
                                        <span class="detail-value">{{ getDeviceType($log->user_agent) }}</span>
                                        <span class="detail-browser">{{ getBrowser($log->user_agent) }}</span>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="bi bi-clock"></i>
                                    <div class="detail-content">
                                        <span class="detail-label">Timestamp</span>
                                        <span class="detail-value">{{ $log->created_at->format('M d, Y h:i:s A') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Premium Pagination --}}
        @if ($logs->hasPages())
            <div class="pagination-premium mt-5">
                {{ $logs->withQueryString()->links() }}
            </div>
        @endif

        {{-- Activity Chart Section --}}
        <div class="chart-section mt-5">
            <div class="chart-card">
                <div class="card-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Activity Timeline</h5>
                            <p class="header-subtitle">User activity distribution over time</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="activityChart" height="100"></canvas>
                </div>
            </div>
        </div>

    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Activity Logs Styles */

    /* Header */
    .logs-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 32px;
        padding: 2rem;
        border: 1px solid rgba(37, 99, 235, 0.1);
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
        gap: 1rem;
    }

    .live-indicator {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: #f1f5f9;
        border-radius: 60px;
    }

    .live-dot {
        width: 10px;
        height: 10px;
        background: #10b981;
        border-radius: 50%;
        animation: blink 1.5s infinite;
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

    .live-text {
        font-weight: 600;
        color: #1e2937;
    }

    .btn-export {
        padding: 10px 24px;
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

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid rgba(37, 99, 235, 0.1);
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

    .stat-icon.orange {
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

    .stat-trend i {
        color: #10b981;
    }

    /* Filter Bar */
    .filter-premium-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(37, 99, 235, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .filter-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
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
        gap: 1rem;
    }

    .btn-apply {
        height: 52px;
        padding: 0 32px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
    }

    .btn-apply:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(59, 130, 246, 0.3);
    }

    .btn-reset {
        height: 52px;
        padding: 0 32px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-reset:hover {
        border-color: #ef4444;
        color: #ef4444;
    }

    /* Stats Summary */
    .stats-summary {
        padding: 0 1rem;
    }

    .view-toggle {
        display: flex;
        gap: 0.5rem;
    }

    .view-btn {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .view-btn.active {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border-color: transparent;
    }

    .view-btn:hover {
        border-color: #3b82f6;
        color: #3b82f6;
    }

    /* Logs Table Card */
    .logs-table-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(37, 99, 235, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .logs-table-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
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
        width: 300px;
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

    .log-row {
        transition: all 0.3s ease;
    }

    .log-row:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
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
    }

    .user-avatar.large {
        width: 56px;
        height: 56px;
        font-size: 1.4rem;
    }

    .avatar-initials {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .user-name {
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 2px;
    }

    .user-id {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* IP Info */
    .ip-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .ip-address {
        font-weight: 500;
        color: #1e2937;
    }

    .location-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.75rem;
        color: #64748b;
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 40px;
        width: fit-content;
    }

    /* Endpoint */
    .endpoint-path {
        font-family: monospace;
        font-size: 0.9rem;
        color: #475569;
        background: #f8fafc;
        padding: 4px 8px;
        border-radius: 8px;
        display: inline-block;
    }

    /* Method Badge */
    .method-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Device Info */
    .device-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .device-info i {
        color: #3b82f6;
        margin-right: 4px;
    }

    .device-type {
        font-weight: 500;
        color: #1e2937;
    }

    .browser {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* Timestamp */
    .timestamp {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .timestamp .date {
        font-weight: 500;
        color: #1e2937;
    }

    .timestamp .time {
        font-size: 0.85rem;
        color: #475569;
    }

    .timestamp .time-ago {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* Cards View */
    .logs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .log-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(37, 99, 235, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .log-card:hover {
        transform: translateY(-5px);
        border-color: #3b82f6;
        box-shadow: 0 30px 60px rgba(59, 130, 246, 0.1);
    }

    .log-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .method-indicator {
        padding: 4px 16px;
        border-radius: 40px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .method-indicator.method-get {
        background: #d1fae5;
        color: #047857;
    }

    .method-indicator.method-post {
        background: #dbeafe;
        color: #1e40af;
    }

    .method-indicator.method-put {
        background: #fef3c7;
        color: #92400e;
    }

    .method-indicator.method-delete {
        background: #fee2e2;
        color: #b91c1c;
    }

    .time-badge {
        color: #64748b;
        font-size: 0.85rem;
    }

    .log-card .card-body {
        padding: 1.5rem;
    }

    .user-section {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .user-details h6 {
        font-weight: 600;
        margin-bottom: 2px;
    }

    .log-details {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        gap: 1rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .detail-item i {
        width: 24px;
        color: #3b82f6;
    }

    .detail-content {
        flex: 1;
    }

    .detail-label {
        display: block;
        font-size: 0.7rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .detail-value {
        display: block;
        font-weight: 500;
        color: #1e2937;
        margin-bottom: 2px;
    }

    .detail-location,
    .detail-browser {
        font-size: 0.75rem;
        color: #64748b;
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

    /* Chart Section */
    .chart-section {
        margin-top: 3rem;
    }

    .chart-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(37, 99, 235, 0.1);
        overflow: hidden;
    }

    .chart-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
    }

    .chart-card .card-body {
        padding: 1.5rem;
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

        .logs-table-card .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-input {
            width: 100%;
        }

        .logs-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Table search functionality
    document.getElementById('tableSearch')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#logsTable tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // View toggle
    function setView(view) {
        const tableView = document.getElementById('tableView');
        const cardsView = document.getElementById('cardsView');
        const buttons = document.querySelectorAll('.view-btn');

        buttons.forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');

        if (view === 'table') {
            tableView.style.display = 'block';
            cardsView.style.display = 'none';
        } else {
            tableView.style.display = 'none';
            cardsView.style.display = 'block';
        }
    }

    // Export logs
    function exportLogs() {

        window.location.href = "{{ route('admin.user_logs.export') }}";

    }

    // Activity Chart
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('activityChart')?.getContext('2d');
        if (!ctx) return;

        // Sample data - replace with actual data from your backend
        const data = {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Activity',
                data: [65, 72, 80, 78, 85, 45, 30],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#1d4ed8',
                pointHoverBorderColor: 'white',
                pointHoverBorderWidth: 2,
            }]
        };

        new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e2937',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} activities`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });

    function refreshLogs() {
        fetch("{{ route('admin.user_logs.index') }}?ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById("logsTableBody").innerHTML = html;
            })
            .catch(error => console.error("Error refreshing logs:", error));
    }

    setInterval(refreshLogs, 30000); // every 30 seconds
</script>

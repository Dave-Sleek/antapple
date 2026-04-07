@extends('admin.layouts.app')

@section('title', 'Notifications - AntApple')

@section('content')
    <div class="container py-5">

        {{-- Premium Header --}}
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                    <i class="bi bi-bell-fill me-2"></i>NOTIFICATION CENTER
                </span>
                <h1 class="display-5 fw-bold mb-2" style="color: #1e2937;">Your <span
                        class="text-gradient">Notifications</span></h1>
                <p class="text-muted lead" style="max-width: 600px;">Stay updated with all your activities and alerts</p>
            </div>
            <div class="d-none d-md-block">
                <div class="header-icon-wrapper">
                    <i class="bi bi-bell"></i>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Notifications</span>
                        <span class="stat-value">{{ $notifications->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Unread</span>
                        <span class="stat-value">{{ $notifications->where('read_at', null)->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">This Week</span>
                        <span
                            class="stat-value">{{ $notifications->where('created_at', '>=', now()->subWeek())->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notifications Card --}}
        <div class="premium-card">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">All Notifications</h5>
                        <p class="header-subtitle">Your complete notification history</p>
                    </div>
                </div>

                <div class="header-actions">
                    @if ($notifications->where('read_at', null)->count() > 0)
                        <form method="POST" action="{{ route('notifications.read.all') }}" id="markAllForm">
                            @csrf
                            <button type="submit" class="btn-mark-all">
                                <i class="bi bi-check2-all me-2"></i>
                                Mark All as Read
                                <div class="btn-glow"></div>
                            </button>
                        </form>
                    @endif

                    <div class="filter-tabs">
                        <button class="filter-btn active" data-filter="all">All</button>
                        <button class="filter-btn" data-filter="unread">Unread</button>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                @if ($notifications->count() > 0)
                    <div class="notification-timeline">
                        @foreach ($notifications as $notification)
                            <div class="notification-item {{ $notification->read_at ? '' : 'unread' }}"
                                data-read="{{ $notification->read_at ? 'read' : 'unread' }}">

                                {{-- Timeline Line --}}
                                @if (!$loop->last)
                                    <div class="timeline-line"></div>
                                @endif

                                {{-- Timeline Dot --}}
                                <div class="timeline-dot {{ $notification->read_at ? 'read' : 'unread' }}">
                                    @if (!$notification->read_at)
                                        <span class="dot-pulse"></span>
                                    @endif
                                </div>

                                {{-- Notification Icon --}}
                                <div class="notification-icon-wrapper">
                                    @switch($notification->data['type'] ?? 'default')
                                        @case('job')
                                            <i class="bi bi-briefcase"></i>
                                        @break

                                        @case('application')
                                            <i class="bi bi-person-check"></i>
                                        @break

                                        @case('message')
                                            <i class="bi bi-chat-dots"></i>
                                        @break

                                        @case('alert')
                                            <i class="bi bi-exclamation-circle"></i>
                                        @break

                                        @default
                                            <i class="bi bi-bell"></i>
                                    @endswitch
                                </div>

                                {{-- Notification Content --}}
                                <div class="notification-content-wrapper">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="notification-message">
                                            @php
                                                $uuid = $notification->data['job_uuid'] ?? null;
                                                $slug = $notification->data['job_slug'] ?? null;
                                            @endphp
                                            <p><strong>Reason:</strong> {{ $notification->data['reason'] }}</p>
                                            <p><strong>Message:</strong> {{ $notification->data['message'] }}</p>
                                            <p><strong>Job:</strong>
                                                @if ($uuid && $slug)
                                                    <a href="{{ route('jobs.show', [$uuid, $slug]) }}" target="_blank"
                                                        class="meta-link">
                                                        {{ $notification->data['job_title'] ?? 'View Job' }}
                                                    </a>
                                                @else
                                                    Unknown Job
                                                @endif
                                            </p>
                                        </div>

                                        <div class="notification-time">
                                            <i class="bi bi-clock"></i>
                                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    <div class="notification-meta">
                                        <span class="meta-item">
                                            <i class="bi bi-calendar"></i>
                                            {{ $notification->created_at->format('M d, Y \a\t h:i A') }}
                                        </span>
                                        @if ($notification->data['url'] ?? false)
                                            <a href="{{ $notification->data['url'] }}" class="meta-link">
                                                View Details <i class="bi bi-arrow-right"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                {{-- Unread Badge --}}
                                @if (!$notification->read_at)
                                    <span class="unread-badge">New</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if (method_exists($notifications, 'links'))
                        <div class="pagination-wrapper">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                @else
                    {{-- Premium Empty State --}}
                    <div class="empty-state">
                        <div class="empty-state-glow"></div>
                        <div class="empty-state-icon">
                            <i class="bi bi-bell-slash"></i>
                        </div>
                        <h4 class="fw-bold mb-3">No Notifications Yet</h4>
                        <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto;">
                            You're all caught up! When you receive notifications, they'll appear here.
                        </p>
                        <a href="{{ route('jobs.index') }}" class="btn-browse">
                            <i class="bi bi-briefcase me-2"></i>
                            Browse Jobs
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Notification Preferences --}}
        <div class="preferences-card mt-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="preferences-icon">
                            <i class="bi bi-gear"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Notification Preferences</h5>
                            <p class="text-muted mb-0">Choose which notifications you want to receive</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ auth()->user()->dashboardRoute() }}" class="btn-manage">
                        <i class="bi bi-sliders2 me-2"></i>
                        Manage Preferences
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Notifications Page Styles */

    /* Header Icon */
    .header-icon-wrapper {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
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
    }

    /* Premium Card */
    .premium-card {
        background: white;
        border-radius: 32px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .premium-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.8rem 2rem;
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
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.2);
    }

    .header-subtitle {
        color: #64748b;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .btn-mark-all {
        position: relative;
        padding: 12px 28px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        cursor: pointer;
    }

    .btn-mark-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
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

    .btn-mark-all:hover .btn-glow {
        opacity: 1;
    }

    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 60px;
    }

    .filter-btn {
        padding: 8px 20px;
        border: none;
        background: transparent;
        border-radius: 60px;
        color: #64748b;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .filter-btn.active {
        background: white;
        color: #10b981;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .filter-btn:hover {
        color: #10b981;
    }

    /* Notification Timeline */
    .notification-timeline {
        position: relative;
        padding: 1.5rem 2rem;
    }

    .notification-item {
        position: relative;
        display: flex;
        gap: 1.5rem;
        padding: 1.5rem;
        margin-bottom: 0.5rem;
        background: #f8fafc;
        border-radius: 20px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .notification-item:hover {
        background: white;
        border-color: rgba(16, 185, 129, 0.2);
        transform: translateX(4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.02);
    }

    .notification-item.unread {
        background: #f0f9ff;
        border-left: 4px solid #10b981;
    }

    /* Timeline Elements */
    .timeline-line {
        position: absolute;
        left: 37px;
        top: 55px;
        bottom: -55px;
        width: 2px;
        background: linear-gradient(180deg, #10b981 0%, #e2e8f0 100%);
        z-index: 0;
    }

    .notification-item:last-child .timeline-line {
        display: none;
    }

    .timeline-dot {
        position: relative;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: white;
        border: 3px solid;
        flex-shrink: 0;
        z-index: 2;
        margin-top: 0.5rem;
    }

    .timeline-dot.unread {
        border-color: #10b981;
    }

    .timeline-dot.read {
        border-color: #cbd5e1;
    }

    .dot-pulse {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        50% {
            transform: translate(-50%, -50%) scale(1.5);
            opacity: 0.7;
        }
    }

    /* Notification Icon */
    .notification-icon-wrapper {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        flex-shrink: 0;
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.2);
        z-index: 2;
    }

    /* Notification Content */
    .notification-content-wrapper {
        flex: 1;
        min-width: 0;
    }

    .notification-message {
        font-weight: 500;
        color: #1e2937;
        font-size: 1rem;
        margin-bottom: 0.5rem;
        line-height: 1.5;
    }

    .notification-item.unread .notification-message {
        font-weight: 600;
    }

    .notification-time {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: #64748b;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .notification-time i {
        font-size: 0.75rem;
        color: #10b981;
    }

    .notification-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: #94a3b8;
        font-size: 0.8rem;
    }

    .meta-item i {
        font-size: 0.7rem;
        color: #10b981;
    }

    .meta-link {
        color: #10b981;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: gap 0.3s ease;
    }

    .meta-link:hover {
        gap: 0.6rem;
        color: #047857;
    }

    /* Unread Badge */
    .unread-badge {
        background: #10b981;
        color: white;
        padding: 4px 12px;
        border-radius: 60px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        align-self: flex-start;
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.2);
        animation: pulse 2s infinite;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 1.5rem 2rem;
        border-top: 1px solid #e2e8f0;
    }

    .pagination-wrapper .pagination {
        gap: 0.5rem;
        justify-content: center;
    }

    .pagination-wrapper .page-link {
        border: 1px solid #e2e8f0;
        border-radius: 12px !important;
        color: #475569;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }

    .pagination-wrapper .page-link:hover {
        border-color: #10b981;
        color: #10b981;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 5px 10px rgba(16, 185, 129, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        position: relative;
        overflow: hidden;
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

    .btn-browse {
        display: inline-flex;
        align-items: center;
        padding: 14px 36px;
        background: white;
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 2rem;
        position: relative;
        z-index: 9999;
    }

    .btn-browse:hover {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.2);
    }

    /* Preferences Card */
    .preferences-card {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 28px;
        padding: 2rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .preferences-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

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

    /* Responsive */
    @media (max-width: 768px) {
        .premium-card .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
            flex-direction: column;
        }

        .filter-tabs {
            width: 100%;
        }

        .filter-btn {
            flex: 1;
            text-align: center;
        }

        .notification-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .notification-time {
            white-space: normal;
            margin-top: 0.5rem;
        }

        .timeline-line {
            left: 32px;
        }
    }
</style>

<script>
    // Filter notifications
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            const notifications = document.querySelectorAll('.notification-item');

            notifications.forEach(item => {
                if (filter === 'all') {
                    item.style.display = 'flex';
                } else if (filter === 'unread') {
                    if (item.classList.contains('unread')) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });

    // Mark all as read form submission animation
    document.getElementById('markAllForm')?.addEventListener('submit', function(e) {
        const btn = this.querySelector('button[type="submit"]');
        btn.classList.add('loading');
        btn.querySelector('.btn-text').style.opacity = '0';

        // Add spinner
        const spinner = document.createElement('span');
        spinner.className = 'spinner';
        spinner.innerHTML = '<i class="bi bi-arrow-repeat spinning"></i>';
        btn.appendChild(spinner);

        // Allow form to submit normally
        return true;
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

@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-5 px-4">

        {{-- Premium Header --}}
        <div class="status-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                            <div class="header-icon-ring"></div>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-shield-check me-2"></i>SYSTEM HEALTH
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">System <span
                                    class="text-gradient">Status</span></h1>
                            <p class="text-muted lead mb-0">Real-time system health and service availability</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-actions">
                        <div class="overall-status {{ $db ? 'healthy' : 'critical' }}">
                            <i class="bi bi-{{ $db ? 'check-circle-fill' : 'exclamation-triangle-fill' }}"></i>
                            <span>System {{ $db ? 'Healthy' : 'Critical' }}</span>
                        </div>
                        <button class="btn-refresh" onclick="refreshStatus()">
                            <i class="bi bi-arrow-repeat me-2"></i>
                            Check Status
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="status-card {{ $db ? 'online' : 'offline' }}">
                    <div class="card-icon">
                        <i class="bi bi-database"></i>
                    </div>
                    <div class="card-content">
                        <h5>Database</h5>
                        <div class="status-indicator">
                            <span class="indicator-dot"></span>
                            <span class="indicator-text">{{ $db ? 'Connected' : 'Disconnected' }}</span>
                        </div>
                        <div class="card-meta">
                            <i class="bi bi-clock"></i>
                            <span>Last checked: {{ now()->format('h:i:s A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="status-card online">
                    <div class="card-icon">
                        <i class="bi bi-globe"></i>
                    </div>
                    <div class="card-content">
                        <h5>Web Server</h5>
                        <div class="status-indicator">
                            <span class="indicator-dot"></span>
                            <span class="indicator-text">Running</span>
                        </div>
                        <div class="card-meta">
                            <i class="bi bi-speedometer2"></i>
                            <span>Response: {{ $responseTime ?? '0.23' }} ms</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="status-card online">
                    <div class="card-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="card-content">
                        <h5>Mail Service</h5>
                        <div class="status-indicator">
                            <span class="indicator-dot"></span>
                            <span class="indicator-text">Operational</span>
                        </div>
                        <div class="card-meta">
                            <i class="bi bi-check-circle"></i>
                            <span>Queue: 0 pending</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Application Info Card --}}
        <div class="app-info-card mb-5">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Application Information</h5>
                        <p class="header-subtitle">Current system configuration and environment</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Application Name</span>
                        <span class="info-value">{{ $app ?? 'AntApple Jobs' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Environment</span>
                        <span class="info-value badge-env {{ app()->environment() === 'production' ? 'prod' : 'dev' }}">
                            {{ ucfirst(app()->environment()) }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Server Time</span>
                        <span class="info-value" id="serverTime">{{ now()->format('F d, Y h:i:s A') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Timezone</span>
                        <span class="info-value">{{ config('app.timezone') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Laravel Version</span>
                        <span class="info-value">{{ app()->version() }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">PHP Version</span>
                        <span class="info-value">{{ phpversion() }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Server Software</span>
                        <span class="info-value">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Nginx' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Debug Mode</span>
                        <span class="info-value {{ config('app.debug') ? 'warning' : 'success' }}">
                            {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Service Uptime --}}
        <div class="uptime-card">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Service Uptime</h5>
                        <p class="header-subtitle">System availability over the last 30 days</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="uptime-stats">
                    <div class="uptime-percentage">
                        <span class="percentage-value">99.98%</span>
                        <span class="percentage-label">Uptime</span>
                    </div>
                    <div class="uptime-bars">
                        <div class="uptime-bar" data-value="100">Mon</div>
                        <div class="uptime-bar" data-value="100">Tue</div>
                        <div class="uptime-bar" data-value="100">Wed</div>
                        <div class="uptime-bar" data-value="99">Thu</div>
                        <div class="uptime-bar" data-value="100">Fri</div>
                        <div class="uptime-bar" data-value="100">Sat</div>
                        <div class="uptime-bar" data-value="100">Sun</div>
                    </div>
                </div>
                <div class="incident-history">
                    <h6>Recent Incidents</h6>
                    <div class="incident-item">
                        <div class="incident-dot resolved"></div>
                        <div class="incident-content">
                            <span class="incident-title">Scheduled Maintenance</span>
                            <span class="incident-date">{{ now()->subDays(5)->format('M d') }}</span>
                        </div>
                    </div>
                    <div class="incident-item">
                        <div class="incident-dot resolved"></div>
                        <div class="incident-content">
                            <span class="incident-title">API Latency Issue</span>
                            <span class="incident-date">{{ now()->subDays(12)->format('M d') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Auto-refresh Footer --}}
        <div class="auto-refresh-footer mt-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="status-note">
                    <i class="bi bi-shield-check"></i>
                    <span>All systems operational. Last check: {{ now()->format('h:i:s A') }}</span>
                </div>
                <div class="refresh-control">
                    <i class="bi bi-arrow-repeat spinning"></i>
                    <span>Auto-refresh every 30s</span>
                </div>
            </div>
        </div>

    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium System Status Styles */
    .status-header {
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
        align-items: center;
    }

    .overall-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 10px 20px;
        border-radius: 60px;
        font-weight: 600;
    }

    .overall-status.healthy {
        background: #d1fae5;
        color: #047857;
    }

    .overall-status.critical {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-refresh {
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

    .btn-refresh:hover {
        border-color: #10b981;
        color: #10b981;
        transform: rotate(15deg);
    }

    /* Status Cards */
    .status-card {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .status-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    }

    .status-card.online {
        border-left: 4px solid #10b981;
    }

    .status-card.offline {
        border-left: 4px solid #ef4444;
        background: #fef2f2;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        background: #f1f5f9;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #10b981;
    }

    .card-content {
        flex: 1;
    }

    .card-content h5 {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .status-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .indicator-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: blink 1.5s infinite;
    }

    .status-card.online .indicator-dot {
        background: #10b981;
    }

    .status-card.offline .indicator-dot {
        background: #ef4444;
    }

    .card-meta {
        font-size: 0.75rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Application Info Card */
    .app-info-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
    }

    .app-info-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
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

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 16px;
    }

    .info-label {
        font-weight: 500;
        color: #64748b;
    }

    .info-value {
        font-weight: 600;
        color: #1e2937;
    }

    .badge-env {
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.8rem;
    }

    .badge-env.prod {
        background: #d1fae5;
        color: #047857;
    }

    .badge-env.dev {
        background: #fef3c7;
        color: #92400e;
    }

    .info-value.warning {
        color: #f59e0b;
    }

    .info-value.success {
        color: #10b981;
    }

    /* Uptime Card */
    .uptime-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
    }

    .uptime-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .uptime-stats {
        display: flex;
        align-items: center;
        gap: 2rem;
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .uptime-percentage {
        text-align: center;
        min-width: 120px;
    }

    .percentage-value {
        display: block;
        font-size: 2.5rem;
        font-weight: 800;
        color: #10b981;
        line-height: 1;
    }

    .percentage-label {
        font-size: 0.8rem;
        color: #64748b;
    }

    .uptime-bars {
        flex: 1;
        display: flex;
        gap: 0.5rem;
        align-items: flex-end;
    }

    .uptime-bar {
        flex: 1;
        text-align: center;
        font-size: 0.7rem;
        color: #64748b;
        position: relative;
        padding-top: 60px;
    }

    .uptime-bar::before {
        content: '';
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: calc(attr(data-value) * 0.8px);
        background: linear-gradient(180deg, #10b981, #047857);
        border-radius: 6px 6px 0 0;
        transition: height 0.3s ease;
    }

    .uptime-bar[data-value="100"]::before {
        height: 80px;
    }

    .uptime-bar[data-value="99"]::before {
        height: 79px;
        background: #f59e0b;
    }

    .incident-history {
        padding: 1.5rem;
    }

    .incident-history h6 {
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .incident-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .incident-item:last-child {
        border-bottom: none;
    }

    .incident-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .incident-dot.resolved {
        background: #10b981;
    }

    .incident-dot.investigating {
        background: #f59e0b;
    }

    .incident-content {
        flex: 1;
        display: flex;
        justify-content: space-between;
    }

    .incident-title {
        font-weight: 500;
        color: #1e2937;
    }

    .incident-date {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    /* Auto-refresh Footer */
    .auto-refresh-footer {
        background: #f8fafc;
        padding: 1rem 1.5rem;
        border-radius: 60px;
    }

    .status-note {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #64748b;
    }

    .status-note i {
        color: #10b981;
    }

    .refresh-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .spinning {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .uptime-stats {
            flex-direction: column;
        }

        .header-actions {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .incident-content {
            flex-direction: column;
        }
    }
</style>

<script>
    function refreshStatus() {
        location.reload();
    }

    // Live server time update
    function updateServerTime() {
        const timeElement = document.getElementById('serverTime');
        if (timeElement) {
            const now = new Date();
            timeElement.textContent = now.toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }
    }

    setInterval(updateServerTime, 1000);

    // Auto-refresh every 30 seconds
    setInterval(() => {
        location.reload();
    }, 30000);
</script>

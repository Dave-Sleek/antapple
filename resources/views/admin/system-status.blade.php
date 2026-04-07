@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-5 px-4">

        {{-- Premium Header --}}
        <div class="monitoring-header mb-5">
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
                                <i class="bi bi-graph-up me-2"></i>LIVE MONITORING
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">System <span
                                    class="text-gradient">Monitoring</span></h1>
                            <p class="text-muted lead mb-0">Real-time server performance and metrics</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-actions">
                        <div class="live-indicator">
                            <span class="live-dot"></span>
                            <span class="live-text">Live Data</span>
                            <span class="live-badge">Auto-refresh: 10s</span>
                        </div>
                        <button class="btn-refresh" onclick="refreshData()">
                            <i class="bi bi-arrow-repeat me-2"></i>
                            Refresh Now
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="bi bi-cpu"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">CPU Load Average</span>
                        <span class="stat-value" id="cpuLoad">{{ $cpuLoad ?? '0.00' }}</span>
                        <div class="stat-trend" id="cpuTrend">
                            <i class="bi bi-arrow-up"></i> Normal
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-memory"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Memory Usage</span>
                        <span class="stat-value" id="memoryUsage">{{ round($memoryUsage / 1024 / 1024, 2) }}</span>
                        <span class="stat-unit">MB</span>
                        <div class="stat-trend">
                            Peak: {{ round($memoryPeak / 1024 / 1024, 2) }} MB
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Active Users</span>
                        <span class="stat-value" id="activeUsers">{{ $activeUsers }}</span>
                        <div class="stat-trend">
                            <i class="bi bi-clock"></i> Last 5 minutes
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="bi bi-tachometer"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Requests / Minute</span>
                        <span class="stat-value" id="requestsPerMin">{{ $rpm }}</span>
                        <div class="stat-trend">
                            <i class="bi bi-lightning-charge"></i> Live traffic
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detailed Metrics --}}
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="metrics-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon">
                                <i class="bi bi-bar-chart-line"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">CPU Usage History</h5>
                                <p class="header-subtitle">Last 10 minutes of CPU activity</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="cpuChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="metrics-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon">
                                <i class="bi bi-memory"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Memory Usage</h5>
                                <p class="header-subtitle">Real-time memory consumption</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="memory-gauge">
                            <div class="gauge-container">
                                <div class="gauge-value" id="memoryPercent">0%</div>
                                <svg class="gauge-svg" viewBox="0 0 200 120">
                                    <path class="gauge-bg" d="M20,100 A80,80 0 0,1 180,100" fill="none" stroke="#e2e8f0"
                                        stroke-width="20" />
                                    <path class="gauge-fill" id="gaugeFill" d="M20,100 A80,80 0 0,1 180,100" fill="none"
                                        stroke="#10b981" stroke-width="20" stroke-dasharray="0, 251.2" />
                                </svg>
                            </div>
                            <div class="memory-details">
                                <div class="detail-item">
                                    <span class="detail-label">Used</span>
                                    <span class="detail-value" id="memoryUsed">{{ round($memoryUsage / 1024 / 1024, 2) }}
                                        MB</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Peak</span>
                                    <span class="detail-value">{{ round($memoryPeak / 1024 / 1024, 2) }} MB</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Available</span>
                                    <span class="detail-value" id="memoryAvailable">-- MB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Additional Metrics --}}
        <div class="row g-4">
            <div class="col-md-4">
                <div class="metrics-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon small">
                                <i class="bi bi-database"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Database Performance</h5>
                                <p class="header-subtitle">Query execution time</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="performance-metric">
                            <div class="metric-value-large" id="dbQueryTime">0.23</div>
                            <div class="metric-unit">ms</div>
                            <div class="metric-status">
                                <span class="status-badge good">Excellent</span>
                            </div>
                            <div class="metric-progress">
                                <div class="progress-bar-container">
                                    <div class="progress-fill" style="width: 12%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metrics-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon small">
                                <i class="bi bi-hdd-stack"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Disk Usage</h5>
                                <p class="header-subtitle">Storage consumption</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="disk-usage">
                            <div class="disk-stats">
                                <div class="stat-item">
                                    <span class="stat-label">Used</span>
                                    <span class="stat-value">45.2 GB</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Free</span>
                                    <span class="stat-value">234.8 GB</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Total</span>
                                    <span class="stat-value">280 GB</span>
                                </div>
                            </div>
                            <div class="disk-progress">
                                <div class="progress-bar-container">
                                    <div class="progress-fill"
                                        style="width: 16%; background: linear-gradient(90deg, #f59e0b, #d97706);"></div>
                                </div>
                                <span class="progress-percent">16%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metrics-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon small">
                                <i class="bi bi-globe"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Network I/O</h5>
                                <p class="header-subtitle">Data transfer rate</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="network-stats">
                            <div class="stat-item">
                                <i class="bi bi-upload"></i>
                                <div>
                                    <span class="stat-label">Upload</span>
                                    <span class="stat-value">2.4 MB/s</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="bi bi-download"></i>
                                <div>
                                    <span class="stat-label">Download</span>
                                    <span class="stat-value">8.7 MB/s</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Auto-refresh Indicator --}}
        <div class="auto-refresh-indicator mt-4">
            <div class="d-flex align-items-center justify-content-end gap-2">
                <i class="bi bi-arrow-repeat spinning"></i>
                <span class="small text-muted">Auto-refreshing in <span id="countdown">10</span> seconds</span>
                <button class="btn-stop-refresh" onclick="toggleAutoRefresh()">
                    <i class="bi bi-pause-circle"></i>
                </button>
            </div>
        </div>

    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Monitoring Styles */
    .monitoring-header {
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

    .live-indicator {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
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

    .live-badge {
        background: white;
        padding: 2px 8px;
        border-radius: 40px;
        font-size: 0.7rem;
        color: #10b981;
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

    .stat-icon.purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .stat-icon.green {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
        display: inline-block;
        font-size: 2rem;
        font-weight: 700;
        color: #1e2937;
        line-height: 1.2;
    }

    .stat-unit {
        font-size: 0.9rem;
        color: #64748b;
        margin-left: 2px;
    }

    .stat-trend {
        font-size: 0.8rem;
        color: #64748b;
        margin-top: 4px;
    }

    /* Metrics Cards */
    .metrics-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .metrics-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .header-icon.small {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }

    .header-subtitle {
        color: #64748b;
        margin-bottom: 0;
        font-size: 0.85rem;
    }

    .metrics-card .card-body {
        padding: 1.5rem;
    }

    /* Memory Gauge */
    .memory-gauge {
        text-align: center;
    }

    .gauge-container {
        position: relative;
        width: 200px;
        margin: 0 auto;
    }

    .gauge-value {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.5rem;
        font-weight: 700;
        color: #10b981;
    }

    .gauge-svg {
        width: 100%;
        height: auto;
    }

    .memory-details {
        display: flex;
        justify-content: space-around;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .detail-item {
        text-align: center;
    }

    .detail-label {
        display: block;
        font-size: 0.7rem;
        color: #94a3b8;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-weight: 700;
        color: #1e2937;
    }

    /* Performance Metric */
    .performance-metric {
        text-align: center;
    }

    .metric-value-large {
        font-size: 3rem;
        font-weight: 800;
        color: #10b981;
        display: inline-block;
    }

    .metric-unit {
        font-size: 1rem;
        color: #64748b;
        margin-left: 4px;
    }

    .metric-status {
        margin: 0.5rem 0;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-badge.good {
        background: #d1fae5;
        color: #047857;
    }

    .metric-progress {
        margin-top: 1rem;
    }

    .progress-bar-container {
        height: 6px;
        background: #e2e8f0;
        border-radius: 100px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #10b981, #047857);
        border-radius: 100px;
        transition: width 0.3s ease;
    }

    /* Disk Usage */
    .disk-stats {
        display: flex;
        justify-content: space-around;
        margin-bottom: 1rem;
    }

    .disk-stats .stat-item {
        text-align: center;
    }

    .disk-stats .stat-label {
        font-size: 0.7rem;
        margin-bottom: 2px;
    }

    .disk-stats .stat-value {
        font-size: 1rem;
        font-weight: 700;
    }

    .disk-progress {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .disk-progress .progress-bar-container {
        flex: 1;
    }

    .progress-percent {
        font-size: 0.85rem;
        font-weight: 600;
        color: #f59e0b;
    }

    /* Network Stats */
    .network-stats {
        display: flex;
        justify-content: space-around;
    }

    .network-stats .stat-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .network-stats .stat-item i {
        font-size: 1.5rem;
        color: #10b981;
    }

    /* Auto-refresh Indicator */
    .auto-refresh-indicator {
        background: #f8fafc;
        padding: 0.75rem 1.5rem;
        border-radius: 60px;
        margin-top: 2rem;
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

    .btn-stop-refresh {
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .btn-stop-refresh:hover {
        color: #ef4444;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-actions {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .disk-stats {
            flex-direction: column;
            gap: 0.5rem;
        }

        .network-stats {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let autoRefresh = true;
    let countdown = 10;
    let countdownInterval;
    let refreshInterval;

    // CPU Chart
    const ctx = document.getElementById('cpuChart')?.getContext('2d');
    let cpuChart;

    if (ctx) {
        cpuChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Array.from({
                    length: 10
                }, (_, i) => `${10-i} min ago`).reverse(),
                datasets: [{
                    label: 'CPU Usage (%)',
                    data: [12, 15, 13, 18, 22, 25, 23, 28, 30, {{ $cpuLoad ?? 25 }}],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: 'white',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e2937',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        borderColor: '#10b981',
                        borderWidth: 1,
                        callbacks: {
                            label: (context) => `${context.raw}%`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            callback: (value) => value + '%'
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
    }

    // Memory Gauge
    const memoryUsed = {{ round($memoryUsage / 1024 / 1024, 2) }};
    const memoryTotal = 1024; // Assume 1GB total
    const memoryPercent = (memoryUsed / memoryTotal) * 100;

    const gaugeFill = document.getElementById('gaugeFill');
    const memoryPercentSpan = document.getElementById('memoryPercent');

    if (gaugeFill) {
        const circumference = 251.2;
        const offset = circumference * (1 - memoryPercent / 100);
        gaugeFill.style.strokeDasharray = `${circumference}, ${circumference}`;
        gaugeFill.style.strokeDashoffset = offset;
        memoryPercentSpan.textContent = `${Math.round(memoryPercent)}%`;
    }

    // Auto-refresh functionality
    function startCountdown() {
        if (countdownInterval) clearInterval(countdownInterval);
        countdownInterval = setInterval(() => {
            if (autoRefresh) {
                countdown--;
                document.getElementById('countdown').textContent = countdown;
                if (countdown <= 0) {
                    countdown = 10;
                    refreshData();
                }
            }
        }, 1000);
    }

    function refreshData() {
        if (!autoRefresh) return;
        location.reload();
    }

    function toggleAutoRefresh() {
        autoRefresh = !autoRefresh;
        const btn = document.querySelector('.btn-stop-refresh');
        if (autoRefresh) {
            btn.innerHTML = '<i class="bi bi-pause-circle"></i>';
            countdown = 10;
            startCountdown();
        } else {
            btn.innerHTML = '<i class="bi bi-play-circle"></i>';
            if (countdownInterval) clearInterval(countdownInterval);
            document.getElementById('countdown').textContent = 'paused';
        }
    }

    // Update CPU trend based on value
    function updateCpuTrend(cpuValue) {
        const trendEl = document.getElementById('cpuTrend');
        const cpuNum = parseFloat(cpuValue);
        if (cpuNum > 70) {
            trendEl.innerHTML = '<i class="bi bi-arrow-up text-danger"></i> Critical';
            trendEl.style.color = '#ef4444';
        } else if (cpuNum > 50) {
            trendEl.innerHTML = '<i class="bi bi-arrow-up text-warning"></i> High';
            trendEl.style.color = '#f59e0b';
        } else {
            trendEl.innerHTML = '<i class="bi bi-arrow-down text-success"></i> Normal';
            trendEl.style.color = '#10b981';
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        startCountdown();
        updateCpuTrend(document.getElementById('cpuLoad').textContent);
    });
</script>

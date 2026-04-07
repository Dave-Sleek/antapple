@extends('admin.layouts.app')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
    <div class="container-fluid py-5 px-4">

        {{-- Premium Header --}}
        <div class="revenue-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-pie-chart me-2"></i>FINANCIAL DASHBOARD
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Revenue <span
                                    class="text-success">Analytics</span></h1>
                            <p class="text-muted lead mb-0">Track, analyze, and manage your platform's financial performance
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-date">
                        <div class="date-badge">
                            <i class="bi bi-calendar3"></i>
                            <span>{{ now()->format('F d, Y') }}</span>
                        </div>
                        <div class="growth-badge {{ $growth >= 0 ? 'positive' : 'negative' }}">
                            <i class="bi bi-arrow-{{ $growth >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ number_format(abs($growth), 2) }}% MoM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Premium Revenue Summary Card --}}
        <div class="revenue-summary-card mb-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="summary-content">
                        <span class="summary-label">Total Revenue</span>
                        <div class="summary-value">₦{{ number_format($totalRevenue, 2) }}</div>
                        <div class="summary-trend">
                            <i class="bi bi-arrow-up"></i>
                            <span>+12.5% from last month</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="summary-stats">
                        <div class="stat">
                            <span class="stat-label">Transactions</span>
                            <span class="stat-value">{{ $payments->total() }}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-label">Avg. Order</span>
                            <span
                                class="stat-value">₦{{ number_format($totalRevenue / max($payments->total(), 1), 0) }}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-label">Success Rate</span>
                            <span class="stat-value">98.5%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Premium Plan Revenue Cards --}}
        <div class="row g-4 mb-5">
            @foreach ($revenuePerPlan as $plan => $amount)
                <div class="col-xl-3 col-md-6">
                    <div class="plan-revenue-card">
                        <div
                            class="card-icon {{ $loop->index % 4 == 0 ? 'primary' : ($loop->index % 4 == 1 ? 'success' : ($loop->index % 4 == 2 ? 'warning' : 'info')) }}">
                            <i
                                class="bi bi-{{ $loop->index % 4 == 0 ? 'gem' : ($loop->index % 4 == 1 ? 'star' : ($loop->index % 4 == 2 ? 'rocket' : 'crown')) }}"></i>
                        </div>
                        <div class="card-content">
                            <span class="plan-name">{{ $plan ?? 'Unknown Plan' }}</span>
                            <div class="plan-amount">₦{{ number_format($amount, 2) }}</div>
                            <div class="plan-meta">
                                <span class="subscriptions">
                                    <i class="bi bi-people"></i>
                                    {{ $subscriptionsPerPlan[$plan] ?? 0 }} subscriptions
                                </span>
                                <span class="percentage">
                                    {{ round(($amount / max($totalRevenue, 1)) * 100, 1) }}%
                                </span>
                            </div>
                        </div>
                        <div class="progress-bar-mini" style="width: {{ ($amount / max($totalRevenue, 1)) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Premium Filter Section --}}
        <div class="filter-premium-card mb-5">
            <div class="filter-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="filter-icon">
                        <i class="bi bi-sliders2"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Filter Transactions</h5>
                        <p class="filter-subtitle">Refine your payment data with advanced filters</p>
                    </div>
                </div>
            </div>

            <form method="GET" class="filter-body">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-calendar-start"></i>
                            <input type="date" name="start_date" class="filter-input"
                                value="{{ request('start_date') }}" placeholder="Start Date">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-calendar-end"></i>
                            <input type="date" name="end_date" class="filter-input" value="{{ request('end_date') }}"
                                placeholder="End Date">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="premium-select">
                            <i class="bi bi-tag"></i>
                            <select name="plan_id" class="filter-select">
                                <option value="">All Plans</option>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}"
                                        {{ request('plan_id') == $plan->id ? 'selected' : '' }}>
                                        {{ $plan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-person"></i>
                            <input type="text" name="employer" class="filter-input" value="{{ request('employer') }}"
                                placeholder="Employer name">
                        </div>
                    </div>
                </div>

                <div class="filter-actions mt-4">
                    <button type="submit" class="btn-apply">
                        <i class="bi bi-funnel me-2"></i>
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.revenue.payments') }}" class="btn-reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset
                    </a>
                    <a href="{{ route('admin.payments.export') }}" class="btn-export ms-auto">
                        <i class="bi bi-download me-2"></i>
                        Export CSV
                    </a>
                </div>
            </form>
        </div>

        {{-- Premium Chart Card --}}
        <div class="chart-premium-card mb-5">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Revenue Trend</h5>
                        <p class="header-subtitle">Monthly revenue performance over time</p>
                    </div>
                </div>
                <div class="chart-legend">
                    <span class="legend-item">
                        <span class="legend-dot" style="background: #10b981;"></span>
                        Revenue
                    </span>
                </div>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>

        {{-- Premium Transactions Table --}}
        <div class="transactions-premium-card">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Transaction History</h5>
                        <p class="header-subtitle">Complete list of all payment transactions</p>
                    </div>
                </div>
                <div class="table-search">
                    <i class="bi bi-search"></i>
                    <input type="text" id="tableSearch" placeholder="Search transactions..." class="search-input">
                </div>
            </div>

            <div class="card-body">
                <div class="table-premium-wrapper">
                    <table class="table-premium" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>Employer</th>
                                <th>Email</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date & Time</th>
                                <th>Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                <tr class="transaction-row">
                                    <td>
                                        <div class="employer-info">
                                            <div class="employer-avatar">
                                                @if ($payment->user && $payment->user->avatar)
                                                    <img src="{{ asset('storage/' . $payment->user->avatar) }}"
                                                        alt="{{ $payment->user->name }}">
                                                @else
                                                    <span class="avatar-initials">
                                                        {{ $payment->user ? substr($payment->user->name, 0, 1) : '?' }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="employer-name">{{ $payment->user->name ?? 'N/A' }}</div>
                                                <div class="employer-company">{{ $payment->user->company_name ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="employer-email">
                                            <i class="bi bi-envelope"></i>
                                            {{ $payment->user->email ?? 'N/A' }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="plan-badge">
                                            {{ optional(optional($payment->subscription)->plan)->name ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="amount">₦{{ number_format($payment->amount, 2) }}</span>
                                    </td>

                                    <td>
                                        <span class="status-badge {{ $payment->status }}">
                                            <span class="status-dot"></span>
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="date-time">
                                            <span class="date">{{ $payment->created_at->format('d M, Y') }}</span>
                                            <span class="time">{{ $payment->created_at->format('h:i A') }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="reference-wrapper">
                                            <span class="reference">{{ $payment->reference }}</span>
                                            <button class="copy-ref" onclick="copyReference('{{ $payment->reference }}')"
                                                title="Copy reference">
                                                <i class="bi bi-files"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="bi bi-cash-stack"></i>
                                            </div>
                                            <h5 class="fw-bold mb-2">No Transactions Found</h5>
                                            <p class="text-muted mb-0">No payments match your current filters</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Premium Pagination --}}
                @if ($payments->hasPages())
                    <div class="pagination-premium mt-4">
                        {{ $payments->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Stats Footer --}}
        <div class="quick-stats-footer mt-5">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="footer-stat">
                        <i class="bi bi-credit-card"></i>
                        <div>
                            <span class="stat-value">{{ $payments->total() }}</span>
                            <span class="stat-label">Total Transactions</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-stat">
                        <i class="bi bi-people"></i>
                        <div>
                            <span
                                class="stat-value">{{ $uniqueEmployers ?? $payments->pluck('user_id')->unique()->count() }}</span>
                            <span class="stat-label">Unique Employers</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-stat">
                        <i class="bi bi-calendar-check"></i>
                        <div>
                            <span class="stat-value">{{ $payments->where('status', 'successful')->count() }}</span>
                            <span class="stat-label">Successful</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-stat">
                        <i class="bi bi-calculator"></i>
                        <div>
                            <span
                                class="stat-value">₦{{ number_format($averageTransaction ?? $totalRevenue / max($payments->total(), 1), 0) }}</span>
                            <span class="stat-label">Avg. Transaction</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Premium Admin Revenue Styles */

        /* Header */
        .revenue-header {
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

        .header-date {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .date-badge {
            background: white;
            padding: 10px 20px;
            border-radius: 60px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-weight: 500;
        }

        .growth-badge {
            padding: 10px 20px;
            border-radius: 60px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .growth-badge.positive {
            background: #d1fae5;
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .growth-badge.negative {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Revenue Summary Card */
        .revenue-summary-card {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-radius: 28px;
            padding: 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(16, 185, 129, 0.3);
        }

        .revenue-summary-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        .summary-label {
            display: block;
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }

        .summary-value {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .summary-trend {
            display: flex;
            align-items: center;
            gap: 4px;
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 16px;
            border-radius: 60px;
            width: fit-content;
        }

        .summary-stats {
            display: flex;
            justify-content: space-around;
        }

        .stat {
            text-align: center;
        }

        .stat .stat-label {
            display: block;
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 4px;
        }

        .stat .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Plan Revenue Cards */
        .plan-revenue-card {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            border: 1px solid rgba(16, 185, 129, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        }

        .plan-revenue-card:hover {
            transform: translateY(-5px);
            border-color: #10b981;
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.1);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .card-icon.primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .card-icon.success {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        }

        .card-icon.warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .card-icon.info {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        }

        .plan-name {
            display: block;
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .plan-amount {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e2937;
            margin-bottom: 8px;
        }

        .plan-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
        }

        .subscriptions {
            color: #64748b;
        }

        .subscriptions i {
            color: #10b981;
            margin-right: 4px;
        }

        .percentage {
            font-weight: 600;
            color: #10b981;
        }

        .progress-bar-mini {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981 0%, #047857 100%);
            transition: width 0.3s ease;
        }

        /* Filter Card */
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
            gap: 1rem;
            align-items: center;
        }

        .btn-apply {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 60px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        }

        .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        }

        .btn-reset {
            width: 52px;
            height: 52px;
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

        .btn-export {
            padding: 12px 32px;
            background: white;
            color: #475569;
            border: 1px solid #e2e8f0;
            border-radius: 60px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .btn-export:hover {
            border-color: #10b981;
            color: #10b981;
            transform: translateY(-2px);
        }

        /* Chart Card */
        .chart-premium-card {
            background: white;
            border-radius: 28px;
            border: 1px solid rgba(16, 185, 129, 0.1);
            overflow: hidden;
        }

        .chart-premium-card .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            padding: 1.5rem;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-legend {
            display: flex;
            gap: 1rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .chart-premium-card .card-body {
            padding: 1.5rem;
        }

        /* Transactions Card */
        .transactions-premium-card {
            background: white;
            border-radius: 28px;
            border: 1px solid rgba(16, 185, 129, 0.1);
            overflow: hidden;
        }

        .transactions-premium-card .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            padding: 1.5rem;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
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
            padding: 0 16px 0 48px;
            border: 1px solid #e2e8f0;
            border-radius: 60px;
            width: 300px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
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

        .transaction-row {
            transition: all 0.3s ease;
        }

        .transaction-row:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        }

        /* Employer Info */
        .employer-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .employer-avatar {
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

        .employer-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-initials {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .employer-name {
            font-weight: 600;
            color: #1e2937;
            margin-bottom: 2px;
        }

        .employer-company {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .employer-email {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-size: 0.9rem;
        }

        .employer-email i {
            color: #94a3b8;
        }

        /* Plan Badge */
        .plan-badge {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            padding: 6px 16px;
            border-radius: 60px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        /* Amount */
        .amount {
            font-weight: 700;
            color: #1e2937;
            font-size: 1.1rem;
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

        .status-badge.success {
            background: #d1fae5;
            color: #047857;
        }

        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge.failed {
            background: #fee2e2;
            color: #b91c1c;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-badge.success .status-dot {
            background: #10b981;
        }

        .status-badge.pending .status-dot {
            background: #f59e0b;
        }

        .status-badge.failed .status-dot {
            background: #ef4444;
        }

        /* Date Time */
        .date-time {
            text-align: center;
        }

        .date-time .date {
            display: block;
            font-weight: 500;
            color: #1e2937;
            margin-bottom: 2px;
        }

        .date-time .time {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* Reference */
        .reference-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reference {
            font-family: monospace;
            font-size: 0.85rem;
            color: #475569;
            background: #f8fafc;
            padding: 4px 8px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .copy-ref {
            width: 30px;
            height: 30px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .copy-ref:hover {
            border-color: #10b981;
            color: #10b981;
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

        /* Quick Stats Footer */
        .quick-stats-footer {
            background: white;
            border-radius: 28px;
            padding: 2rem;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .footer-stat {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .footer-stat i {
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

        .footer-stat .stat-value {
            display: block;
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e2937;
            line-height: 1.2;
        }

        .footer-stat .stat-label {
            font-size: 0.85rem;
            color: #64748b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .summary-value {
                font-size: 2.5rem;
            }

            .summary-stats {
                margin-top: 1.5rem;
            }

            .header-date {
                justify-content: flex-start;
                margin-top: 1rem;
            }

            .filter-actions {
                flex-wrap: wrap;
            }

            .btn-export {
                margin-left: 0 !important;
            }

            .search-input {
                width: 100%;
            }

            .transactions-premium-card .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <script>
        // Chart initialization
        fetch("{{ route('admin.revenue.chart') }}")
            .then(res => res.json())
            .then(data => {
                const ctx = document.getElementById('revenueChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Revenue',
                            data: data.values,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#10b981',
                            pointBorderColor: 'white',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#047857',
                            pointHoverBorderColor: 'white',
                            pointHoverBorderWidth: 2,
                        }]
                    },
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
                                borderColor: '#10b981',
                                borderWidth: 1,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return '₦' + context.parsed.y.toLocaleString();
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
                                },
                                ticks: {
                                    callback: function(value) {
                                        return '₦' + value.toLocaleString();
                                    }
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

        // Table search functionality
        document.getElementById('tableSearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#transactionsTable tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Copy reference function
        function copyReference(ref) {
            navigator.clipboard.writeText(ref).then(() => {
                alert('Reference copied to clipboard!');
            });
        }
    </script>
@endsection

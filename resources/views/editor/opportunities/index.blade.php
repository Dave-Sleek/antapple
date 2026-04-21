@extends('layouts.app')

@section('title', 'Opportunities Analytics - Editor Dashboard')
@section('description', 'Manage and analyze opportunities performance metrics')

@section('content')
    <div class="container py-5">

        {{-- Premium Header --}}
        <div class="opportunities-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                            <div class="header-icon-ring"></div>
                        </div>
                        <div>
                            <span class="badge bg-primary-subtle text-primary px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-bar-chart-steps me-2"></i>OPPORTUNITY ANALYTICS
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Opportunity <span
                                    class="text-gradient">Management</span></h1>
                            <p class="text-muted lead mb-0">Track performance metrics and manage your opportunities</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="header-actions">
                        <a href="{{ auth()->user()->dashboardRoute() }}" class="btn-settings">
                            <i class="bi bi-sliders2 me-2"></i>
                            Dashboard Settings
                        </a>
                        <a href="{{ route('editor-opportunities.create') }}" class="btn-create">
                            <i class="bi bi-plus-circle me-2"></i>
                            <span>Add Opportunity</span>
                            <div class="btn-glow"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="bi bi-eye"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Views</span>
                        <span class="stat-value">{{ number_format($totalViews) }}</span>
                        <div class="stat-trend">
                            <i class="bi bi-arrow-up"></i> All time views
                        </div>
                    </div>
                    <div class="stat-bg-icon">
                        <i class="bi bi-eye"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-mouse"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Clicks</span>
                        <span class="stat-value">{{ number_format($totalClicks) }}</span>
                        <div class="stat-trend">
                            <i class="bi bi-cursor"></i> Apply clicks
                        </div>
                    </div>
                    <div class="stat-bg-icon">
                        <i class="bi bi-mouse"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="bi bi-percent"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Conversion Rate</span>
                        <span class="stat-value">{{ $conversionRate }}%</span>
                        <div class="stat-trend {{ $conversionRate > 10 ? 'positive' : 'warning' }}">
                            <i class="bi bi-arrow-{{ $conversionRate > 10 ? 'up' : 'down' }}"></i>
                            {{ $conversionRate > 10 ? 'Above average' : 'Needs improvement' }}
                        </div>
                    </div>
                    <div class="stat-bg-icon">
                        <i class="bi bi-percent"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Analytics Table Card --}}
        <div class="analytics-card mb-5">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-table"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Performance Analytics</h5>
                        <p class="header-subtitle">Detailed metrics for each opportunity</p>
                    </div>
                </div>
                <div class="table-search">
                    <i class="bi bi-search"></i>
                    <input type="text" id="tableSearch" class="search-input" placeholder="Search opportunities...">
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-premium-wrapper">
                    <table class="table-premium" id="opportunitiesTable">
                        <thead>
                            <tr>
                                <th>Opportunity Title</th>
                                <th>Type</th>
                                <th>Organization</th>
                                <th>Views</th>
                                <th>Clicks</th>
                                <th>Conversion</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($opportunities as $item)
                                <tr class="opportunity-row">
                                    <td class="fw-semibold">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="title-icon">
                                                <i class="bi bi-file-text"></i>
                                            </div>
                                            {{ $item->title }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="type-badge type-{{ $item->type }}">
                                            @switch($item->type)
                                                @case('internship')
                                                    <i class="bi bi-briefcase"></i> Internship
                                                @break

                                                @case('scholarship')
                                                    <i class="bi bi-trophy"></i> Scholarship
                                                @break

                                                @case('grant')
                                                    <i class="bi bi-cash-stack"></i> Grant
                                                @break

                                                @case('graduate_program')
                                                    <i class="bi bi-mortarboard"></i> Graduate
                                                @break

                                                @default
                                                    <i class="bi bi-star"></i> {{ ucfirst($item->type) }}
                                            @endswitch
                                        </span>
                                    </td>
                                    <td>
                                        <div class="organization-cell">
                                            <i class="bi bi-building"></i>
                                            {{ $item->organization }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="metric-cell">
                                            <i class="bi bi-eye"></i>
                                            <span class="metric-value">{{ number_format($item->views_count ?? 0) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="metric-cell">
                                            <i class="bi bi-mouse"></i>
                                            <span class="metric-value">{{ number_format($item->clicks_count ?? 0) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $conversion =
                                                $item->views_count > 0
                                                    ? round(($item->clicks_count / $item->views_count) * 100, 1)
                                                    : 0;
                                            $conversionClass =
                                                $conversion >= 10 ? 'high' : ($conversion >= 5 ? 'medium' : 'low');
                                        @endphp
                                        <div class="conversion-badge conversion-{{ $conversionClass }}">
                                            <span class="conversion-value">{{ $conversion }}%</span>
                                            <div class="conversion-bar">
                                                <div class="conversion-fill" style="width: {{ min($conversion, 100) }}%">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-buttons">
                                            <a href="{{ route('editor-opportunities.edit', $item) }}"
                                                class="action-btn edit" title="Edit Opportunity">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST"
                                                action="{{ route('editor-opportunities.destroy', $item) }}"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete"
                                                    title="Delete Opportunity"
                                                    onclick="return confirm('Are you sure you want to delete this opportunity?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            {{-- <a href="{{ route('opportunities.show', $item->uuid ?? $item->id) }}"
                                                class="action-btn view" title="View Opportunity" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($opportunities->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-star"></i>
                        </div>
                        <h5 class="fw-bold mb-2">No Opportunities Yet</h5>
                        <p class="text-muted mb-4">Get started by creating your first opportunity</p>
                        <a href="{{ route('editor-opportunities.create') }}" class="btn-create">
                            <i class="bi bi-plus-circle me-2"></i>
                            Create Opportunity
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Opportunities Grid --}}
        @if ($opportunities->count() > 0)
            <div class="opportunities-grid-section">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold">
                        <i class="bi bi-grid-3x3-gap-fill text-success me-2"></i>
                        All Opportunities
                    </h5>
                    <span class="total-count">{{ $opportunities->total() }} opportunities total</span>
                </div>

                <div class="opportunities-grid">
                    @foreach ($opportunities as $item)
                        <div class="opportunity-card">
                            <div class="card-badge type-{{ $item->type }}">
                                @switch($item->type)
                                    @case('internship')
                                        <i class="bi bi-briefcase"></i> Internship
                                    @break

                                    @case('scholarship')
                                        <i class="bi bi-trophy"></i> Scholarship
                                    @break

                                    @case('grant')
                                        <i class="bi bi-cash-stack"></i> Grant
                                    @break

                                    @case('graduate_program')
                                        <i class="bi bi-mortarboard"></i> Graduate Program
                                    @break

                                    @default
                                        <i class="bi bi-star"></i> {{ ucfirst($item->type) }}
                                @endswitch
                            </div>

                            <h6 class="card-title">{{ $item->title }}</h6>

                            <div class="card-meta">
                                <span><i class="bi bi-building"></i> {{ $item->organization }}</span>
                                @if ($item->location)
                                    <span><i class="bi bi-geo-alt"></i> {{ $item->location }}</span>
                                @endif
                            </div>

                            <div class="card-stats">
                                <div class="stat">
                                    <i class="bi bi-eye"></i>
                                    <span>{{ number_format($item->views_count ?? 0) }} views</span>
                                </div>
                                <div class="stat">
                                    <i class="bi bi-mouse"></i>
                                    <span>{{ number_format($item->clicks_count ?? 0) }} clicks</span>
                                </div>
                            </div>

                            <div class="card-actions">
                                <a href="{{ route('editor-opportunities.edit', $item) }}" class="btn-edit-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('editor-opportunities.destroy', $item) }}"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-sm"
                                        onclick="return confirm('Delete this opportunity?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Premium Pagination --}}
                @if ($opportunities->hasPages())
                    <div class="pagination-premium mt-5">
                        {{ $opportunities->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        @endif

        {{-- Export Section --}}
        <div class="export-section mt-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="export-icon">
                            <i class="bi bi-download"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Export Analytics Data</h6>
                            <p class="text-muted small mb-0">Download performance reports for further analysis</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn-export" onclick="exportData()">
                        <i class="bi bi-file-spreadsheet me-2"></i>
                        Export CSV
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Opportunities Management Styles */

    /* Header */
    .opportunities-header {
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

    .btn-settings {
        padding: 12px 24px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .btn-settings:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
    }

    .btn-create {
        position: relative;
        padding: 12px 28px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
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

    .btn-create:hover .btn-glow {
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

    .stat-trend.warning {
        color: #f59e0b;
    }

    .stat-bg-icon {
        position: absolute;
        bottom: -20px;
        right: -20px;
        font-size: 5rem;
        color: rgba(16, 185, 129, 0.05);
        z-index: 1;
    }

    /* Analytics Card */
    .analytics-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .analytics-card .card-header {
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
        height: 44px;
        width: 250px;
        padding: 0 16px 0 48px;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
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
        padding: 1rem 1rem;
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

    .opportunity-row {
        transition: all 0.3s ease;
    }

    .opportunity-row:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
    }

    .title-icon {
        width: 32px;
        height: 32px;
        background: rgba(16, 185, 129, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .type-internship {
        background: #d1fae5;
        color: #047857;
    }

    .type-scholarship {
        background: #fed7aa;
        color: #92400e;
    }

    .type-grant {
        background: #dbeafe;
        color: #1e40af;
    }

    .type-graduate_program {
        background: #e0e7ff;
        color: #3730a3;
    }

    .organization-cell {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #475569;
    }

    .metric-cell {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .metric-value {
        color: #1e2937;
    }

    /* Conversion Badge */
    .conversion-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
        min-width: 80px;
        text-align: center;
    }

    .conversion-high {
        background: #d1fae5;
        color: #047857;
    }

    .conversion-medium {
        background: #fef3c7;
        color: #92400e;
    }

    .conversion-low {
        background: #fee2e2;
        color: #b91c1c;
    }

    .conversion-bar {
        width: 100%;
        height: 3px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 3px;
        margin-top: 4px;
        overflow: hidden;
    }

    .conversion-fill {
        height: 100%;
        background: currentColor;
        border-radius: 3px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .action-btn.edit:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
    }

    .action-btn.delete:hover {
        border-color: #ef4444;
        color: #ef4444;
        transform: translateY(-2px);
    }

    .action-btn.view:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        transform: translateY(-2px);
    }

    /* Opportunities Grid Section */
    .opportunities-grid-section {
        margin-top: 2rem;
    }

    .total-count {
        color: #64748b;
        font-size: 0.9rem;
    }

    .opportunities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .opportunity-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .opportunity-card:hover {
        transform: translateY(-5px);
        border-color: #10b981;
        box-shadow: 0 20px 30px rgba(16, 185, 129, 0.1);
    }

    .card-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
    }

    .card-title {
        font-weight: 700;
        color: #1e2937;
        margin-bottom: 0.5rem;
    }

    .card-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 1rem;
    }

    .card-meta i {
        color: #10b981;
    }

    .card-stats {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        padding: 0.75rem 0;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }

    .card-stats .stat {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.85rem;
        color: #475569;
    }

    .card-stats i {
        color: #10b981;
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-edit-sm,
    .btn-delete-sm {
        flex: 1;
        padding: 0.5rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-edit-sm {
        background: white;
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .btn-edit-sm:hover {
        background: #10b981;
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete-sm {
        background: white;
        color: #ef4444;
        border: 1px solid #fee2e2;
    }

    .btn-delete-sm:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: #f8fafc;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-icon i {
        font-size: 3rem;
        color: #94a3b8;
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
        border-color: #10b981;
        color: #10b981;
    }

    .pagination-premium .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 5px 10px rgba(16, 185, 129, 0.3);
    }

    /* Export Section */
    .export-section {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 24px;
        padding: 1.5rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .export-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .btn-export {
        padding: 10px 24px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 40px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-export:hover {
        border-color: #8b5cf6;
        color: #8b5cf6;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .header-actions {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .opportunities-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .analytics-card .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .table-search {
            width: 100%;
        }

        .search-input {
            width: 100%;
        }

        .opportunity-row td:nth-child(2),
        .opportunity-row th:nth-child(2) {
            display: none;
        }
    }
</style>

<script>
    // Table search functionality
    document.getElementById('tableSearch')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#opportunitiesTable tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Export data function
    function exportData() {
        alert('Exporting analytics data to CSV...');
        // Implement actual export logic here
    }
</script>

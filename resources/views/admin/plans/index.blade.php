@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-5 px-4">

        {{-- Premium Header --}}
        <div class="plan-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-grid-3x3-gap-fill"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-tags me-2"></i>SUBSCRIPTION MANAGEMENT
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Manage <span
                                    class="text-success">Plans</span></h1>
                            <p class="text-muted lead mb-0">Create and manage subscription plans for employers</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-actions">
                        <button class="btn-primary-premium" data-bs-toggle="modal" data-bs-target="#createPlanModal">
                            <i class="bi bi-plus-circle me-2"></i>
                            <span>Create New Plan</span>
                            <div class="btn-glow"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Plans Overview Stats --}}
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="bi bi-tag"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Plans</span>
                        <span class="stat-value">{{ $plans->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Active Plans</span>
                        <span class="stat-value">{{ $plans->where('is_active', true)->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Subscribers</span>
                        <span class="stat-value">{{ $totalSubscribers ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon gold">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Monthly Revenue</span>
                        <span class="stat-value">₦{{ number_format($monthlyRevenue ?? 0, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Plans Grid --}}
        <div class="plans-grid">
            @foreach ($plans as $plan)
                <div class="plan-premium-card">
                    {{-- Popular Badge --}}
                    @if ($plan->is_popular ?? false)
                        <div class="popular-badge">
                            <i class="bi bi-star-fill"></i>
                            Most Popular
                        </div>
                    @endif

                    <div class="card-header">
                        <div
                            class="plan-icon {{ $loop->index % 4 == 0 ? 'primary' : ($loop->index % 4 == 1 ? 'success' : ($loop->index % 4 == 2 ? 'warning' : 'info')) }}">
                            <i
                                class="bi bi-{{ $loop->index % 4 == 0 ? 'gem' : ($loop->index % 4 == 1 ? 'rocket' : ($loop->index % 4 == 2 ? 'star' : 'crown')) }}"></i>
                        </div>
                        <div class="plan-status">
                            @if ($plan->is_active)
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
                        </div>
                    </div>

                    <div class="card-body">
                        <h4 class="plan-name">{{ $plan->name }}</h4>
                        <div class="plan-price">
                            <span class="currency">₦</span>
                            <span class="amount">{{ number_format($plan->price, 0) }}</span>
                            <span class="period">/{{ $plan->billing_cycle }}</span>
                        </div>

                        <p class="plan-description">{!! $plan->description ?? 'No description available' !!}</p>

                        <div class="plan-features">
                            <div class="feature-item">
                                <i class="bi bi-briefcase"></i>
                                <span><strong>{{ $plan->job_limit }}</strong> Job Posts</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-star"></i>
                                <span><strong>{{ $plan->featured_limit ?? 0 }}</strong> Featured Jobs</span>
                            </div>
                            <div class="feature-item">
                                @if ($plan->can_view_applicants)
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Can view applicants</span>
                                @else
                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                    <span>Cannot view applicants</span>
                                @endif
                            </div>
                        </div>

                        <div class="plan-stats">
                            <div class="stat">
                                <span class="stat-label">Subscribers</span>
                                <span class="stat-value">{{ $plan->subscriptions_count ?? 0 }}</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Revenue</span>
                                <span class="stat-value">₦{{ number_format($plan->revenue ?? 0, 0) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#editPlanModal{{ $plan->id }}">
                            <i class="bi bi-pencil"></i>
                            Edit Plan
                        </button>
                        <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST"
                            class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete"
                                onclick="return confirm('Are you sure you want to delete this plan? This action cannot be undone.')">
                                <i class="bi bi-trash"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Premium Edit Modal --}}
                <div class="modal fade premium-modal" id="editPlanModal{{ $plan->id }}" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="modal-header-icon">
                                        <i class="bi bi-pencil-square"></i>
                                    </div>
                                    <div>
                                        <h5 class="modal-title fw-bold">Edit Plan</h5>
                                        <p class="modal-subtitle">Update the details for {{ $plan->name }}</p>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form method="POST" action="{{ route('admin.plans.update', $plan->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Plan Name</label>
                                                <div class="input-wrapper">
                                                    <i class="bi bi-tag"></i>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ $plan->name }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Price (₦)</label>
                                                <div class="input-wrapper">
                                                    <i class="bi bi-currency-dollar"></i>
                                                    <input type="number" name="price" class="form-control"
                                                        value="{{ $plan->price }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-select">
                                                <label class="form-label">Billing Cycle</label>
                                                <div class="select-wrapper">
                                                    <i class="bi bi-calendar"></i>
                                                    <select name="billing_cycle" class="form-select" required>
                                                        <option value="monthly"
                                                            {{ $plan->billing_cycle == 'monthly' ? 'selected' : '' }}>
                                                            Monthly</option>
                                                        <option value="yearly"
                                                            {{ $plan->billing_cycle == 'yearly' ? 'selected' : '' }}>Yearly
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Job Limit</label>
                                                <div class="input-wrapper">
                                                    <i class="bi bi-briefcase"></i>
                                                    <input type="number" name="job_limit" class="form-control"
                                                        value="{{ $plan->job_limit }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Featured Limit</label>
                                                <div class="input-wrapper">
                                                    <i class="bi bi-star"></i>
                                                    <input type="number" name="featured_limit" class="form-control"
                                                        value="{{ $plan->featured_limit }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-toggle-group">
                                                <label class="form-label">Features</label>
                                                <div class="toggle-item">
                                                    <span>Can view applicants</span>
                                                    <div class="toggle-wrapper">
                                                        <input type="checkbox" name="can_view_applicants"
                                                            {{ $plan->can_view_applicants ? 'checked' : '' }}>
                                                        <span class="toggle-slider"></span>
                                                    </div>
                                                </div>
                                                <div class="toggle-item">
                                                    <span>Active Plan</span>
                                                    <div class="toggle-wrapper">
                                                        <input type="checkbox" name="is_active"
                                                            {{ $plan->is_active ? 'checked' : '' }}>
                                                        <span class="toggle-slider"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="premium-input">
                                                <label class="form-label">Plan Description</label>
                                                <div class="input-wrapper">
                                                    <i class="bi bi-text-paragraph" style="top: 20px;"></i>
                                                    <textarea name="description" id="aboutCompanyEditor" class="form-control" rows="4">{{ $plan->description }}</textarea>
                                                </div>
                                                <span
                                                    class="character-count">{{ strlen($plan->description ?? '') }}/500</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn-primary">
                                        <i class="bi bi-check2-circle me-2"></i>
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Premium Create Modal --}}
        <div class="modal fade premium-modal" id="createPlanModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modal-header-icon">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold">Create New Plan</h5>
                                <p class="modal-subtitle">Add a new subscription plan for employers</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form method="POST" action="{{ route('admin.plans.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="premium-input">
                                        <label class="form-label">Plan Name</label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-tag"></i>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="e.g. Professional Plan" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="premium-input">
                                        <label class="form-label">Price (₦)</label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-currency-dollar"></i>
                                            <input type="number" name="price" class="form-control"
                                                placeholder="50000" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="premium-select">
                                        <label class="form-label">Billing Cycle</label>
                                        <div class="select-wrapper">
                                            <i class="bi bi-calendar"></i>
                                            <select name="billing_cycle" class="form-select" required>
                                                <option value="monthly">Monthly</option>
                                                <option value="yearly">Yearly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="premium-input">
                                        <label class="form-label">Job Limit</label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-briefcase"></i>
                                            <input type="number" name="job_limit" class="form-control" placeholder="10"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="premium-input">
                                        <label class="form-label">Featured Limit</label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-star"></i>
                                            <input type="number" name="featured_limit" class="form-control"
                                                placeholder="3">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="premium-toggle-group">
                                        <label class="form-label">Features</label>
                                        <div class="toggle-item">
                                            <span>Can view applicants</span>
                                            <div class="toggle-wrapper">
                                                <input type="checkbox" name="can_view_applicants" checked>
                                                <span class="toggle-slider"></span>
                                            </div>
                                        </div>
                                        <div class="toggle-item">
                                            <span>Active Plan</span>
                                            <div class="toggle-wrapper">
                                                <input type="checkbox" name="is_active" checked>
                                                <span class="toggle-slider"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="premium-input">
                                        <label class="form-label">Plan Description</label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-text-paragraph" style="top: 20px;"></i>
                                            <textarea name="description" id="descriptionEditor" class="form-control" rows="4"
                                                placeholder="Describe the plan features and benefits..."></textarea>
                                        </div>
                                        <span class="character-count">0/500</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-primary">
                                <i class="bi bi-check2-circle me-2"></i>
                                Create Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Admin Plan Management Styles */

    /* Header */
    .plan-header {
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

    .stat-icon.purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .stat-icon.gold {
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

    /* Plans Grid */
    .plans-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    /* Plan Premium Card */
    .plan-premium-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .plan-premium-card:hover {
        transform: translateY(-5px);
        border-color: #10b981;
        box-shadow: 0 30px 60px rgba(16, 185, 129, 0.15);
    }

    .popular-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 6px 16px;
        border-radius: 60px;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        z-index: 2;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
    }

    .plan-premium-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.8rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .plan-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
    }

    .plan-icon.primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .plan-icon.success {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .plan-icon.warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .plan-icon.info {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

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

    .plan-premium-card .card-body {
        padding: 1.8rem;
    }

    .plan-name {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e2937;
        margin-bottom: 0.5rem;
    }

    .plan-price {
        margin-bottom: 1rem;
        display: flex;
        align-items: baseline;
        gap: 4px;
    }

    .currency {
        font-size: 1.2rem;
        font-weight: 600;
        color: #10b981;
        align-self: flex-start;
        margin-top: 4px;
    }

    .amount {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1e2937;
        line-height: 1;
    }

    .period {
        color: #64748b;
        font-size: 1rem;
        margin-left: 4px;
    }

    .plan-description {
        color: #475569;
        margin-bottom: 1.5rem;
        line-height: 1.6;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .plan-features {
        margin-bottom: 1.5rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 0;
        color: #475569;
    }

    .feature-item i {
        width: 24px;
        color: #10b981;
    }

    .plan-stats {
        display: flex;
        gap: 1.5rem;
        padding: 1rem 0;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }

    .plan-stats .stat {
        flex: 1;
        text-align: center;
    }

    .plan-stats .stat-label {
        display: block;
        color: #64748b;
        font-size: 0.8rem;
        margin-bottom: 4px;
    }

    .plan-stats .stat-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e2937;
    }

    .plan-premium-card .card-footer {
        background: #f8fafc;
        padding: 1.5rem 1.8rem;
        display: flex;
        gap: 1rem;
    }

    .btn-edit,
    .btn-delete {
        flex: 1;
        padding: 12px;
        border-radius: 60px;
        font-weight: 600;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-edit {
        background: white;
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
        text-decoration: none;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-delete {
        background: white;
        color: #ef4444;
        border: 1px solid #fee2e2;
        border: none;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
    }

    /* Premium Modal */
    .premium-modal .modal-content {
        border: none;
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
    }

    .premium-modal .modal-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 2rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .modal-header-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .modal-subtitle {
        color: #64748b;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .premium-modal .modal-body {
        padding: 2rem;
    }

    .premium-modal .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid #e2e8f0;
        gap: 1rem;
    }

    /* Premium Inputs */
    .premium-input,
    .premium-select {
        margin-bottom: 0;
    }

    .premium-input .form-label,
    .premium-select .form-label {
        color: #475569;
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .input-wrapper,
    .select-wrapper {
        position: relative;
    }

    .input-wrapper i,
    .select-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        z-index: 2;
        transition: color 0.3s ease;
    }

    .premium-input .form-control,
    .premium-select .form-select {
        height: 52px;
        padding: 0 16px 0 48px;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .premium-input textarea.form-control {
        height: auto;
        padding-top: 16px;
    }

    .premium-input .form-control:focus,
    .premium-select .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        background: white;
    }

    /* Toggle Group */
    .premium-toggle-group {
        background: #f8fafc;
        padding: 1.2rem;
        border-radius: 20px;
    }

    .toggle-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
    }

    .toggle-wrapper {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
    }

    .toggle-wrapper input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e2e8f0;
        transition: 0.3s;
        border-radius: 34px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .toggle-wrapper input:checked+.toggle-slider {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .toggle-wrapper input:checked+.toggle-slider:before {
        transform: translateX(24px);
    }

    /* Modal Buttons */
    .btn-secondary {
        padding: 12px 28px;
        border-radius: 60px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
    }

    .btn-primary {
        padding: 12px 32px;
        border-radius: 60px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }

    /* Character Count */
    .character-count {
        display: block;
        text-align: right;
        font-size: 0.8rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .plans-grid {
            grid-template-columns: 1fr;
        }

        .header-actions {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .plan-stats {
            flex-direction: column;
            gap: 0.5rem;
        }

        .plan-premium-card .card-footer {
            flex-direction: column;
        }
    }
</style>


<script>
    // Character counters
    document.querySelectorAll('textarea[name="description"]').forEach(textarea => {
        textarea.addEventListener('input', function() {
            const count = this.value.length;
            const counter = this.closest('.premium-input').querySelector('.character-count');
            if (counter) {
                counter.textContent = `${count}/500`;
            }
        });
    });

    // Delete form confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this plan? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
</script>

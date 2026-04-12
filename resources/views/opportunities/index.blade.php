@extends('layouts.app')

@section('title', 'Explore Opportunities - AntApple Jobs')
@section('description',
    'Discover internships, scholarships, grants, and graduate programs to accelerate your career
    journey.')

@section('content')
    <div class="container py-5">

        {{-- Premium Header --}}
        <div class="opportunities-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-compass"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                            <div class="header-icon-ring"></div>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-stars me-2"></i>DISCOVER MORE
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Explore <span
                                    class="text-gradient">Opportunities</span></h1>
                            <p class="text-muted lead mb-0">Find internships, scholarships, grants, and graduate programs
                                tailored for you</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="stats-bubbles">
                        <div class="stat-bubble">
                            <span class="stat-number">{{ $opportunities->total() }}</span>
                            <span class="stat-label">Opportunities</span>
                        </div>
                        <div class="stat-bubble">
                            <span class="stat-number">{{ $opportunities->where('type', 'internship')->count() }}</span>
                            <span class="stat-label">Internships</span>
                        </div>
                        <div class="stat-bubble">
                            <span class="stat-number">{{ $opportunities->where('type', 'scholarship')->count() }}</span>
                            <span class="stat-label">Scholarships</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Premium Filter Bar --}}
        <div class="filter-premium-card mb-5">
            <div class="filter-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="filter-icon">
                        <i class="bi bi-sliders2"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Find Your Perfect Opportunity</h5>
                        <p class="filter-subtitle">Use filters to narrow down your search</p>
                    </div>
                </div>
            </div>

            <form method="GET" class="filter-body" id="filterForm">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-search"></i>
                            <input type="text" name="search" class="filter-input" placeholder="Search opportunities..."
                                value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="premium-select">
                            <i class="bi bi-tag"></i>
                            <select name="type" class="filter-select">
                                <option value="">All Types</option>
                                <option value="internship" {{ request('type') == 'internship' ? 'selected' : '' }}>
                                    Internship</option>
                                <option value="scholarship" {{ request('type') == 'scholarship' ? 'selected' : '' }}>
                                    Scholarship</option>
                                <option value="grant" {{ request('type') == 'grant' ? 'selected' : '' }}>Grant</option>
                                <option value="graduate_program"
                                    {{ request('type') == 'graduate_program' ? 'selected' : '' }}>Graduate Program
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="premium-input">
                            <i class="bi bi-geo-alt"></i>
                            <input type="text" name="location" class="filter-input" placeholder="Location"
                                value="{{ request('location') }}">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="filter-actions">
                            <button type="submit" class="btn-apply w-100">
                                <i class="bi bi-funnel me-2"></i>
                                Filter
                            </button>
                            <a href="{{ route('opportunities.index') }}" class="btn-reset">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Active Filters Display --}}
                @if (request()->anyFilled(['search', 'type', 'location']))
                    <div class="active-filters mt-4">
                        <span class="active-label">Active Filters:</span>
                        @if (request('search'))
                            <span class="filter-tag">
                                Search: {{ request('search') }}
                                <a href="?{{ http_build_query(request()->except('search')) }}"
                                    class="remove-filter">&times;</a>
                            </span>
                        @endif
                        @if (request('type'))
                            <span class="filter-tag">
                                Type: {{ ucfirst(str_replace('_', ' ', request('type'))) }}
                                <a href="?{{ http_build_query(request()->except('type')) }}"
                                    class="remove-filter">&times;</a>
                            </span>
                        @endif
                        @if (request('location'))
                            <span class="filter-tag">
                                Location: {{ request('location') }}
                                <a href="?{{ http_build_query(request()->except('location')) }}"
                                    class="remove-filter">&times;</a>
                            </span>
                        @endif
                        <a href="{{ route('opportunities.index') }}" class="clear-all">Clear All</a>
                    </div>
                @endif
            </form>
        </div>

        {{-- Results Count --}}
        <div class="results-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="results-count">{{ $opportunities->total() }}</span>
                    <span class="results-label">opportunities found</span>
                </div>
                <div class="sort-options">
                    <label class="sort-label">Sort by:</label>
                    <select id="sortBy" class="sort-select">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="deadline_asc">Deadline (Earliest)</option>
                        <option value="deadline_desc">Deadline (Latest)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Opportunities Grid --}}
        @if ($opportunities->count())
            <div class="opportunities-grid">
                @foreach ($opportunities as $item)
                    <div class="opportunity-card animate__animated animate__fadeInUp"
                        style="animation-delay: {{ $loop->index * 0.05 }}s;">

                        {{-- Type Badge --}}
                        <div class="type-badge type-{{ $item->type }}">
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
                                    <i class="bi bi-star"></i> Opportunity
                            @endswitch
                        </div>

                        {{-- Featured Badge --}}
                        @if ($item->is_featured ?? false)
                            <div class="featured-badge">
                                <i class="bi bi-star-fill"></i>
                                Featured
                            </div>
                        @endif

                        @if ($item->image)
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/default.png') }}"
                                class="img-fluid rounded mb-2 w-100">
                        @endif

                        {{-- Content --}}
                        <div class="card-body">
                            <h3 class="opportunity-title">{{ $item->title }}</h3>

                            <div class="opportunity-meta">
                                @if ($item->organization)
                                    <div class="meta-item">
                                        <i class="bi bi-building"></i>
                                        <span>{{ $item->organization }}</span>
                                    </div>
                                @endif
                                @if ($item->location)
                                    <div class="meta-item">
                                        <i class="bi bi-geo-alt"></i>
                                        <span>{{ $item->location }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Description --}}
                            <p class="opportunity-description">
                                {{ Str::limit(strip_tags($item->description ?? $item->short_description), 200) }}
                            </p>

                            {{-- Details Row --}}
                            <div class="details-row">
                                @if ($item->deadline)
                                    <div
                                        class="deadline {{ \Carbon\Carbon::parse($item->deadline)->isPast() ? 'expired' : '' }}">
                                        <i class="bi bi-calendar-check"></i>
                                        <span>Deadline:
                                            {{ \Carbon\Carbon::parse($item->deadline)->format('M d, Y') }}</span>
                                        @if (!\Carbon\Carbon::parse($item->deadline)->isPast())
                                            <span class="days-left">
                                                ({{ \Carbon\Carbon::now()->diffInDays($item->deadline) }} days left)
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                @if ($item->funding ?? false)
                                    <div class="funding">
                                        <i class="bi bi-cash"></i>
                                        <span>Funding Available</span>
                                    </div>
                                @endif
                            </div>

                            {{-- View Button --}}
                            <a href="{{ route('opportunities.show', [$item->uuid, $item->slug]) }}" class="btn-view">
                                <span>View Details</span>
                                <i class="bi bi-arrow-right"></i>
                                <div class="btn-glow"></div>
                            </a>
                        </div>

                        {{-- Hover Pattern --}}
                        <div class="card-pattern"></div>
                    </div>
                @endforeach
            </div>

            {{-- Premium Pagination --}}
            @if ($opportunities->hasPages())
                <div class="pagination-premium mt-5">
                    {{ $opportunities->withQueryString()->links() }}
                </div>
            @endif

            {{-- Newsletter CTA --}}
            {{-- <div class="newsletter-cta mt-5">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="d-flex align-items-center gap-3">
                            <div class="cta-icon">
                                <i class="bi bi-envelope-paper"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Get New Opportunities Delivered</h5>
                                <p class="text-muted mb-0">Subscribe to receive weekly updates on new internships,
                                    scholarships, and grants</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <form class="newsletter-form">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email address">
                                <button class="btn-subscribe" type="submit">
                                    <i class="bi bi-bell"></i> Subscribe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
        @else
            {{-- Premium Empty State --}}
            <div class="empty-state-premium">
                <div class="empty-state-glow"></div>
                <div class="empty-state-icon">
                    <i class="bi bi-search"></i>
                </div>
                <h3 class="fw-bold mb-3">No Opportunities Found</h3>
                <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">
                    We couldn't find any opportunities matching your criteria. Try adjusting your filters or check back
                    later.
                </p>
                <div class="empty-suggestions">
                    <span>Try:</span>
                    <button onclick="removeFilter('search')" class="suggestion-btn">Clear search</button>
                    <button onclick="removeFilter('type')" class="suggestion-btn">Reset type filter</button>
                    <button onclick="window.location.href='{{ route('opportunities.index') }}'"
                        class="suggestion-btn primary">
                        View all opportunities
                    </button>
                </div>
            </div>
        @endif

        {{-- Browse by Category --}}
        <div class="category-section mt-5">
            <h5 class="fw-bold mb-4 text-center">Browse by Category</h5>
            <div class="category-grid">
                <a href="{{ route('opportunities.index', ['type' => 'internship']) }}" class="category-card">
                    <i class="bi bi-briefcase"></i>
                    <span>Internships</span>
                    <small>{{ $typeCounts['internship'] ?? 0 }} available</small>
                </a>
                <a href="{{ route('opportunities.index', ['type' => 'scholarship']) }}" class="category-card">
                    <i class="bi bi-trophy"></i>
                    <span>Scholarships</span>
                    <small>{{ $typeCounts['scholarship'] ?? 0 }} available</small>
                </a>
                <a href="{{ route('opportunities.index', ['type' => 'grant']) }}" class="category-card">
                    <i class="bi bi-cash-stack"></i>
                    <span>Grants</span>
                    <small>{{ $typeCounts['grant'] ?? 0 }} available</small>
                </a>
                <a href="{{ route('opportunities.index', ['type' => 'graduate_program']) }}" class="category-card">
                    <i class="bi bi-mortarboard"></i>
                    <span>Graduate Programs</span>
                    <small>{{ $typeCounts['graduate_program'] ?? 0 }} available</small>
                </a>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Opportunities Page Styles */

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

    /* Stats Bubbles */
    .stats-bubbles {
        display: flex;
        justify-content: flex-end;
        gap: 1.5rem;
    }

    .stat-bubble {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 1.8rem;
        font-weight: 800;
        color: #10b981;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #64748b;
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
        text-decoration: none;
    }

    .btn-reset:hover {
        border-color: #ef4444;
        color: #ef4444;
        transform: rotate(90deg);
    }

    /* Active Filters */
    .active-filters {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .active-label {
        font-size: 0.85rem;
        color: #64748b;
    }

    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f1f5f9;
        border-radius: 40px;
        font-size: 0.85rem;
        color: #1e2937;
    }

    .remove-filter {
        color: #94a3b8;
        text-decoration: none;
        font-size: 1.1rem;
        transition: color 0.3s ease;
    }

    .remove-filter:hover {
        color: #ef4444;
    }

    .clear-all {
        color: #ef4444;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .clear-all:hover {
        text-decoration: underline;
    }

    /* Results Header */
    .results-header {
        padding: 0 0.5rem;
    }

    .results-count {
        font-size: 1.5rem;
        font-weight: 700;
        color: #10b981;
    }

    .results-label {
        color: #64748b;
        margin-left: 0.5rem;
    }

    .sort-options {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .sort-label {
        font-size: 0.85rem;
        color: #64748b;
    }

    .sort-select {
        padding: 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 40px;
        background: white;
        color: #1e2937;
        font-size: 0.85rem;
        cursor: pointer;
    }

    /* Opportunities Grid */
    .opportunities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
    }

    .opportunity-card {
        background: white;
        border-radius: 28px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .opportunity-card:hover {
        transform: translateY(-8px);
        border-color: #10b981;
        box-shadow: 0 30px 60px rgba(16, 185, 129, 0.15);
    }

    /* Type Badge */
    .type-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        padding: 6px 16px;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        z-index: 2;
    }

    .type-internship {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #047857;
    }

    .type-scholarship {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #92400e;
    }

    .type-grant {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .type-graduate_program {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #3730a3;
    }

    /* Featured Badge */
    .featured-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 6px 16px;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        z-index: 2;
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
    }

    /* Card Body */
    .opportunity-card .card-body {
        padding: 1.5rem;
    }

    .opportunity-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e2937;
        margin: 2.5rem 0 0.75rem 0;
        line-height: 1.4;
    }

    .opportunity-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: #64748b;
        font-size: 0.85rem;
    }

    .meta-item i {
        color: #10b981;
        font-size: 0.8rem;
    }

    .opportunity-description {
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .details-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .deadline {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.85rem;
        color: #64748b;
    }

    .deadline i {
        color: #10b981;
    }

    .deadline.expired {
        color: #ef4444;
    }

    .deadline.expired i {
        color: #ef4444;
    }

    .days-left {
        color: #10b981;
        font-weight: 500;
    }

    .funding {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.85rem;
        color: #10b981;
        font-weight: 500;
    }

    /* View Button */
    .btn-view {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 12px;
        background: white;
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-view:hover {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        transform: translateX(5px);
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

    .btn-view:hover .btn-glow {
        opacity: 1;
    }

    .card-pattern {
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Newsletter CTA */
    .newsletter-cta {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 28px;
        padding: 2rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .cta-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
    }

    .newsletter-form .input-group {
        display: flex;
        gap: 0.5rem;
    }

    .newsletter-form input {
        flex: 1;
        height: 52px;
        border-radius: 60px;
        border: 1px solid #e2e8f0;
        padding: 0 1.5rem;
        background: white;
    }

    .newsletter-form input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .btn-subscribe {
        padding: 0 1.5rem;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-subscribe:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    /* Empty State */
    .empty-state-premium {
        text-align: center;
        padding: 5rem 3rem;
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
        border-radius: 48px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.1);
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

    .empty-suggestions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .suggestion-btn {
        padding: 0.75rem 1.5rem;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        z-index: 9999;
    }

    .suggestion-btn:hover {
        border-color: #10b981;
        color: #10b981;
    }

    .suggestion-btn.primary {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
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

    /* Category Section */
    .category-section {
        margin-top: 3rem;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }

    .category-card {
        text-align: center;
        padding: 1.5rem;
        background: white;
        border-radius: 24px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
        border-color: #10b981;
        box-shadow: 0 20px 30px rgba(16, 185, 129, 0.1);
    }

    .category-card i {
        font-size: 2rem;
        color: #10b981;
        margin-bottom: 0.5rem;
        display: block;
    }

    .category-card span {
        display: block;
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 0.25rem;
    }

    .category-card small {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .opportunities-grid {
            grid-template-columns: 1fr;
        }

        .category-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .stats-bubbles {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .newsletter-cta .row>div:first-child {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 768px) {
        .filter-actions {
            flex-direction: column;
        }

        .btn-reset {
            width: 100%;
            height: 52px;
            border-radius: 60px;
        }

        .results-header .d-flex {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .details-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .category-grid {
            grid-template-columns: 1fr;
        }

        .newsletter-form .input-group {
            flex-direction: column;
        }

        .btn-subscribe {
            width: 100%;
            justify-content: center;
            padding: 0.75rem;
        }
    }
</style>

<script>
    // Sort functionality
    document.getElementById('sortBy')?.addEventListener('change', function() {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', this.value);
        window.location.href = url.toString();
    });

    // Remove filter function
    function removeFilter(filterName) {
        const url = new URL(window.location.href);
        url.searchParams.delete(filterName);
        window.location.href = url.toString();
    }

    // Newsletter form submission
    document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input').value;
        if (email) {
            alert(`Thank you! We'll send opportunities to ${email}`);
            this.querySelector('input').value = '';
        }
    });
</script>

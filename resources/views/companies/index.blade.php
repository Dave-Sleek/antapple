@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Premium Header --}}
        <div class="companies-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <div class="header-icon-wrapper mb-4">
                        <div class="header-icon">
                            <i class="bi bi-buildings"></i>
                        </div>
                        <div class="header-icon-glow"></div>
                        <div class="header-icon-ring"></div>
                    </div>
                    <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                        <i class="bi bi-building me-2"></i>TOP EMPLOYERS
                    </span>
                    <h1 class="display-4 fw-bold mb-3">Browse <span class="text-gradient">Top Companies</span></h1>
                    <p class="lead text-muted mx-auto" style="max-width: 600px;">
                        Discover amazing companies hiring now. Find your next career opportunity with Nigeria's leading
                        employers.
                    </p>
                </div>
            </div>
        </div>

        {{-- Search and Filter Bar --}}
        <div class="search-filter-bar mb-5">
            <div class="row g-3">
                <div class="col-md-5">
                    <div class="search-wrapper">
                        <i class="bi bi-search"></i>
                        <input type="text" id="companySearch" class="form-control"
                            placeholder="Search companies by name..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-wrapper">
                        <i class="bi bi-sort-alpha-down"></i>
                        <select id="sortCompanies" class="form-select">
                            <option value="name_asc">Name (A-Z)</option>
                            <option value="name_desc">Name (Z-A)</option>
                            <option value="jobs_desc">Most Jobs</option>
                            <option value="jobs_asc">Least Jobs</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="filter-wrapper">
                        <i class="bi bi-grid"></i>
                        <select id="itemsPerPage" class="form-select">
                            <option value="12">12 per page</option>
                            <option value="24">24 per page</option>
                            <option value="36">36 per page</option>
                            <option value="48">48 per page</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn-filter w-100" onclick="applyFilters()">
                        <i class="bi bi-funnel me-2"></i>
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>

        {{-- Stats Summary --}}
        <div class="stats-summary mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted mb-0">
                    Showing <span class="fw-bold text-success">{{ $companies->firstItem() ?? 0 }}</span> to
                    <span class="fw-bold text-success">{{ $companies->lastItem() ?? 0 }}</span> of
                    <span class="fw-bold text-success">{{ $companies->total() }}</span> companies
                </p>
                <div class="view-toggle">
                    <button class="view-btn active" onclick="setView('grid')">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </button>
                    <button class="view-btn" onclick="setView('list')">
                        <i class="bi bi-list-ul"></i>
                    </button>
                </div>
            </div>
        </div>

        @if ($companies->count())
            {{-- Companies Grid --}}
            <div class="companies-grid" id="companiesGrid">
                @foreach ($companies as $index => $company)
                    <div class="company-card-wrapper animate__animated animate__fadeInUp"
                        style="animation-delay: {{ $index * 0.05 }}s;">
                        <div class="company-card h-100">

                            {{-- Popular Badge --}}
                            @if ($company->jobs()->where('status', 'active')->count() > 10)
                                <div class="popular-badge">
                                    <i class="bi bi-fire"></i>
                                    Hot Company
                                </div>
                            @endif

                            {{-- Verified Badge --}}
                            @if ($company->is_verified)
                                <div class="verified-badge">
                                    <i class="bi bi-patch-check-fill"></i>
                                </div>
                            @endif

                            <div class="card-body">
                                {{-- Company Logo with Animated Border --}}
                                <div class="logo-wrapper mb-3">
                                    <div class="logo-glow"></div>
                                    <img src="{{ $company->logo_url ?? 'https://placehold.co/200x200/10b981/white?text=' . urlencode(substr($company->company_name ?? $company->name, 0, 2)) }}"
                                        alt="{{ $company->company_name ?? $company->name }}" class="company-logo">
                                </div>

                                {{-- Company Name --}}
                                <h5 class="company-name fw-bold mb-2">{{ $company->company_name ?? $company->name }}</h5>

                                {{-- Location --}}
                                @if ($company->location)
                                    <div class="company-location mb-2">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <span>{{ $company->location }}</span>
                                    </div>
                                @endif

                                {{-- About Company --}}
                                @if ($company->about_company)
                                    <p class="company-about text-muted small mb-3">
                                        <i class="bi bi-buildings"></i> {{ Str::limit($company->about_company, 80) }}
                                    </p>
                                @endif

                                {{-- Company Stats --}}
                                <div class="company-stats mb-3">
                                    <div class="stat-item">
                                        <span
                                            class="stat-value">{{ $company->jobs()->where('status', 'active')->count() }}</span>
                                        <span class="stat-label">Active Jobs</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-value">{{ $company->created_at->format('Y') ?? '2020' }}</span>
                                        <span class="stat-label">Joined</span>
                                    </div>
                                </div>

                                {{-- Job Categories --}}
                                <div class="job-categories mb-3">
                                    @foreach ($company->jobs()->where('status', 'active')->limit(1)->get() as $job)
                                        <span class="category-badge"> <i class="bi bi-tag"></i>
                                            {{ $job->category->name ?? 'General' }}</span>
                                    @endforeach
                                </div>

                                {{-- View Company Button with Hover Effect --}}
                                <a href="{{ route('companies.show', $company->id) }}" class="btn-view-company">
                                    <span>View Company Page</span>
                                    <i class="bi bi-arrow-right"></i>
                                    <div class="btn-glow"></div>
                                </a>
                            </div>

                            {{-- Background Pattern --}}
                            <div class="card-pattern"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Premium Pagination --}}
            <div class="pagination-premium mt-5">
                {{ $companies->withQueryString()->links() }}
            </div>

            {{-- Featured Companies Section --}}
            <div class="featured-companies-section mt-5">
                <h3 class="fw-bold mb-4 text-center">Featured Employers</h3>
                <div class="featured-logos">
                    <div class="featured-logo-item">
                        <img src="https://placehold.co/100x100/10b981/white?text=COMPANY" alt="Company">
                    </div>
                    <div class="featured-logo-item">
                        <img src="https://placehold.co/100x100/047857/white?text=COMPANY" alt="Company">
                    </div>
                    <div class="featured-logo-item">
                        <img src="https://placehold.co/100x100/10b981/white?text=COMPANY" alt="Company">
                    </div>
                    <div class="featured-logo-item">
                        <img src="https://placehold.co/100x100/047857/white?text=COMPANY" alt="Company">
                    </div>
                    <div class="featured-logo-item">
                        <img src="https://placehold.co/100x100/10b981/white?text=COMPANY" alt="Company">
                    </div>
                    <div class="featured-logo-item">
                        <img src="https://placehold.co/100x100/047857/white?text=COMPANY" alt="Company">
                    </div>
                </div>
            </div>
        @else
            {{-- Premium Empty State --}}
            <div class="empty-state-premium">
                <div class="empty-state-glow"></div>
                <div class="empty-state-icon">
                    <i class="bi bi-building"></i>
                </div>
                <h3 class="fw-bold mb-3">No Companies Found</h3>
                <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">
                    We couldn't find any companies matching your criteria. Try adjusting your filters or check back later.
                </p>
                <a href="{{ route('companies.index') }}" class="btn-reset-filters">
                    <i class="bi bi-arrow-counterclockwise me-2"></i>
                    Reset Filters
                </a>
            </div>
        @endif

        {{-- Newsletter Section --}}
        <div class="newsletter-section mt-5">
            <div class="newsletter-card">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-2">Get Company Updates</h4>
                        <p class="text-muted mb-lg-0">Subscribe to receive alerts when top companies post new jobs</p>
                    </div>
                    <div class="col-lg-6">
                        <form class="newsletter-form">
                            <input type="email" placeholder="Your email address" class="form-control">
                            <button type="submit" class="btn-subscribe">
                                <i class="bi bi-bell"></i>
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Animate.css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Premium Companies Page Styles */

        /* Header */
        .companies-header {
            padding: 2rem 0;
        }

        .header-icon-wrapper {
            position: relative;
            width: fit-content;
            margin: 0 auto;
        }

        .header-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.8rem;
            color: white;
            position: relative;
            z-index: 2;
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
        }

        .header-icon-glow {
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, transparent 70%);
            filter: blur(20px);
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
            border-radius: 40px;
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

        /* Search & Filter Bar */
        .search-filter-bar {
            background: white;
            border-radius: 60px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .search-wrapper,
        .filter-wrapper {
            position: relative;
        }

        .search-wrapper i,
        .filter-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 2;
        }

        .search-wrapper input,
        .filter-wrapper select {
            height: 52px;
            padding-left: 48px;
            border-radius: 60px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .search-wrapper input:focus,
        .filter-wrapper select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            background: white;
        }

        .btn-filter {
            height: 52px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            border: none;
            border-radius: 60px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
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
        }

        .view-btn.active {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            border-color: transparent;
        }

        .view-btn:hover {
            border-color: #10b981;
            color: #10b981;
        }

        /* Companies Grid */
        .companies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .company-card {
            background: white;
            border-radius: 28px;
            padding: 2rem 1.5rem;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(16, 185, 129, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        }

        .company-card:hover {
            transform: translateY(-8px);
            border-color: #10b981;
            box-shadow: 0 30px 60px rgba(16, 185, 129, 0.15);
        }

        /* Popular Badge */
        .popular-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            z-index: 3;
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
        }

        .verified-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #10b981;
            font-size: 1.5rem;
            z-index: 3;
            filter: drop-shadow(0 4px 8px rgba(16, 185, 129, 0.3));
        }

        /* Logo */
        .logo-wrapper {
            position: relative;
            width: fit-content;
            margin: 0 auto 1rem;
        }

        .logo-glow {
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, transparent 70%);
            filter: blur(15px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .company-card:hover .logo-glow {
            opacity: 1;
        }

        .company-logo {
            width: 100px;
            height: 100px;
            border-radius: 24px;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .company-card:hover .company-logo {
            transform: scale(1.05);
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
        }

        /* Company Location */
        .company-location {
            display: flex;
            align-items: center;
            justify-content: left;
            gap: 4px;
            color: #64748b;
            font-size: 0.9rem;
        }

        .company-location i {
            color: #10b981;
        }

        .company-about {
            color: #64748b;
            line-height: 1.5;
        }

        /* Company Stats */
        .company-stats {
            display: flex;
            justify-content: space-around;
            background: #f8fafc;
            border-radius: 20px;
            padding: 1rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            display: block;
            font-weight: 700;
            color: #1e2937;
            font-size: 1.2rem;
        }

        .stat-label {
            font-size: 0.7rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Job Categories */
        .job-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: center;
        }

        .category-badge {
            background: #f1f5f9;
            color: #475569;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 0.75rem;
        }

        /* View Button */
        .btn-view-company {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
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

        .btn-view-company:hover {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            transform: translateX(5px);
        }

        .btn-view-company i {
            transition: transform 0.3s ease;
        }

        .btn-view-company:hover i {
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

        .btn-view-company:hover .btn-glow {
            opacity: 1;
        }

        /* Card Pattern */
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

        /* Pagination */
        .pagination-premium .pagination {
            gap: 0.5rem;
        }

        .pagination-premium .page-link {
            border: 1px solid #e2e8f0;
            border-radius: 14px !important;
            color: #475569;
            padding: 0.6rem 1rem;
            transition: all 0.3s ease;
        }

        .pagination-premium .page-link:hover {
            border-color: #10b981;
            color: #10b981;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.02) 0%, rgba(4, 120, 87, 0.02) 100%);
            transform: translateY(-2px);
        }

        .pagination-premium .page-item.active .page-link {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-color: transparent;
            color: white;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        /* Featured Companies */
        .featured-companies-section {
            padding: 3rem;
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            border-radius: 48px;
        }

        .featured-logos {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .featured-logo-item {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 24px;
            padding: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .featured-logo-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.15);
        }

        .featured-logo-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .featured-logo-item:hover img {
            filter: grayscale(0);
            opacity: 1;
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

        .btn-reset-filters {
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
        }

        .btn-reset-filters:hover {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.2);
        }

        /* Newsletter Section */
        .newsletter-section {
            margin-top: 4rem;
        }

        .newsletter-card {
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            border-radius: 32px;
            padding: 2.5rem;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .newsletter-form {
            display: flex;
            gap: 1rem;
        }

        .newsletter-form input {
            flex: 1;
            height: 56px;
            border-radius: 60px;
            border: 1px solid #e2e8f0;
            padding: 0 1.5rem;
            background: white;
        }

        .btn-subscribe {
            height: 56px;
            padding: 0 2rem;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            border: none;
            border-radius: 60px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        }

        .btn-subscribe:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        }

        /* List View */
        .companies-grid.list-view {
            grid-template-columns: 1fr;
        }

        .companies-grid.list-view .company-card {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 1.5rem;
        }

        .companies-grid.list-view .logo-wrapper {
            margin: 0 2rem 0 0;
        }

        .companies-grid.list-view .card-body {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .search-filter-bar {
                border-radius: 30px;
                padding: 1rem;
            }

            .companies-grid.list-view .card-body {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .featured-logos {
                gap: 1rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate job counters for each company
            const counters = document.querySelectorAll('.stat-value:first-child');
            counters.forEach(el => {
                const count = parseInt(el.innerText);
                if (!isNaN(count)) {
                    let current = 0;
                    const increment = Math.ceil(count / 50);
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= count) {
                            el.innerText = count;
                            clearInterval(timer);
                        } else {
                            el.innerText = current;
                        }
                    }, 20);
                }
            });

            // Search functionality
            const searchInput = document.getElementById('companySearch');
            if (searchInput) {
                searchInput.addEventListener('keyup', debounce(function() {
                    applyFilters();
                }, 500));
            }

            // Sort functionality
            const sortSelect = document.getElementById('sortCompanies');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    applyFilters();
                });
            }

            // Items per page
            const perPageSelect = document.getElementById('itemsPerPage');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function() {
                    applyFilters();
                });
            }
        });

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function applyFilters() {
            const search = document.getElementById('companySearch').value;
            const sort = document.getElementById('sortCompanies').value;
            const perPage = document.getElementById('itemsPerPage').value;

            // Build URL with query parameters
            let url = new URL(window.location.href);
            url.searchParams.set('search', search);
            url.searchParams.set('sort', sort);
            url.searchParams.set('per_page', perPage);

            window.location.href = url.toString();
        }

        function setView(view) {
            const grid = document.getElementById('companiesGrid');
            const buttons = document.querySelectorAll('.view-btn');

            buttons.forEach(btn => btn.classList.remove('active'));
            event.currentTarget.classList.add('active');

            if (view === 'list') {
                grid.classList.add('list-view');
            } else {
                grid.classList.remove('list-view');
            }

            // Save preference to localStorage
            localStorage.setItem('companiesView', view);
        }

        // Load saved view preference
        const savedView = localStorage.getItem('companiesView');
        if (savedView === 'list') {
            document.getElementById('companiesGrid')?.classList.add('list-view');
            document.querySelectorAll('.view-btn')[1]?.classList.add('active');
            document.querySelectorAll('.view-btn')[0]?.classList.remove('active');
        }
    </script>
@endsection

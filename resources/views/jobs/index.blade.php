@extends('layouts.app')

@section('title', 'Sproutplex – Verified Job Opportunities')

@section('content')

    <div class="container">

        {{-- Hero Header --}}
        {{-- <div class="text-center mb-5">
            <h1 class="fw-bold" style="color: green;">Find Your Next Opportunity</h1>
            <p class="text-muted">
                Hand-picked, verified jobs from trusted companies
            </p>
        </div> --}}

        {{-- Hero Header --}}
        <section class="hero-bg text-white d-flex align-items-center justify-content-center">
            <div class="container text-center position-relative z-1">

                {{-- Optional: Add logo back with animation --}}
                @if (false)
                    {{-- Set to true if you want to show the logo --}}
                    <img src="{{ asset('images/sprout_logo.png') }}" class="premium-logo mb-4"
                        style="height:70px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));">
                @endif

                {{-- Headline - larger display-1 --}}
                <h1 class="fw-bold display-1 mb-3" style="font-family: 'Open Sans', sans-serif;">
                    Discover Verified Opportunities That Move You {{-- <i class="fa fa-forward" aria-hidden="true"></i> --}}
                </h1>

                {{-- Subtext - larger fs-3 --}}
                <p class="fs-3 mb-4" style="font-family: 'Open Sans', sans-serif;">
                    Curated opportunities to help you grow faster.
                </p>

                <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-4 mt-3">
                    <a href="#jobs"
                        class="premium-button btn btn-success w-auto d-inline-flex align-items-center gap-3 px-4 py-3 rounded-pill shadow-sm">
                        <span class="button-text">Get Started</span>
                        <span class="button-icon"><i class="fas fa-briefcase"></i></span>
                        <div class="button-glow"></div>
                    </a>

                    <a href="{{ route('opportunities.index') }}"
                        class="btn btn-outline-primary w-auto text-white d-inline-flex align-items-center gap-2 px-4 py-3 rounded-pill shadow-sm">
                        <span class="button-text">Explore Opportunities</span>
                        <span class="button-icon">→</span>
                        <div class="button-glow"></div>
                    </a>

                </div>

                {{-- Trust signals --}}
                {{-- <div class="d-flex justify-content-center flex-wrap gap-4 mt-4 mb-4">
                    <span class="badge bg-dark text-white border border-success fs-6 py-2 px-4">
                        ✔ Verified Jobs Only
                    </span>
                    <span class="badge bg-light text-primary border border-primary fs-6 py-2 px-4">
                        🚀 Fast Alerts
                    </span>
                    <span class="badge bg-dark text-info border border-info fs-6 py-2 px-4">
                        🌍 Remote Friendly
                    </span>
                    <span class="badge bg-dark text-warning border border-warning fs-6 py-2 px-4">
                        💼 Top Companies
                    </span>
                </div> --}}

                {{-- Bottom text --}}
                <p class="fs-6 mt-4" style="font-family: 'Open Sans', sans-serif;">
                    Trusted by 1,000+ job seekers weekly <i class="bi bi-people-fill"></i>
                </p>

            </div>
        </section>


        {{-- Filters --}}
        <div class="card shadow-sm rounded-4 p-4">
            <div class="card-body">
                <form class="row g-3 align-items-end">

                    {{-- Category --}}
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Category</label>
                        <select name="category" class="form-select">
                            <option value="">All categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }} ({{ $category->jobs_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Location --}}
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Location</label>
                        <input name="location" class="form-control" placeholder="City, country or remote"
                            value="{{ request('location') }}">
                    </div>

                    {{-- Job Type --}}
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Job Type</label>
                        <select name="job_type" class="form-select">
                            <option value="">Any type</option>
                            <option value="full-time" @selected(request('job_type') == 'full-time')>Full Time</option>
                            <option value="part-time" @selected(request('job_type') == 'part-time')>Part Time</option>
                            <option value="contract" @selected(request('job_type') == 'contract')>Contract</option>
                            <option value="internship" @selected(request('job_type') == 'internship')>Internship</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted">Keyword</label>
                        <input name="keyword" class="form-control" placeholder="Job title or company"
                            value="{{ request('keyword') }}">
                    </div>


                    {{-- Remote --}}
                    <div class="col-md-2">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="remote" value="1" id="remoteCheck"
                                @checked(request('remote'))>
                            <label class="form-check-label" for="remoteCheck">
                                Remote only
                            </label>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-md btn-success">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>

                    @if (request()->hasAny(['category', 'location', 'job_type', 'remote']))
                        <div class="col-12">
                            <a href="{{ route('jobs.index') }}" class="small text-decoration-none text-muted">
                                Clear filters
                            </a>
                        </div>
                    @endif

                </form>
            </div>
        </div>

        @php
            $featuredJobs = $jobs->where('is_featured', true);
            $regularJobs = $jobs->where('is_featured', false);
        @endphp
        <br />
        {{-- Results Count --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="text-muted mb-0">
                Showing {{ $jobs->total() }} jobs
            </p>
        </div>

        <h3 class="fw-bold mb-4">
            @if (request('category'))
                {{ $category->firstWhere('id', request('category'))->name ?? 'Jobs' }}
            @else
                For You Jobs
            @endif
        </h3>

        {{-- Job Cards --}}

        {{-- @if ($featuredJobs->count())
            <h5 class="mb-3 text-success">🌟 Featured Jobs</h5>

            <div class="row g-4 mb-4">
                @foreach ($featuredJobs as $job)
                    <div class="col-lg-6">
                        <x-job-card :job="$job" />
                    </div>
                @endforeach
            </div>
        @endif --}}


        <div id="jobs" class="row g-4">
            @forelse($jobs as $job)
                <div class="col-lg-6">
                    <x-job-card :job="$job" />
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h5>No jobs found</h5>
                    <p class="text-muted">
                        Try adjusting your filters or check back later.
                    </p>
                </div>
                @foreach ($fallbackJobs as $job)
                    <div class="col-lg-6">
                        <x-job-card :job="$job" />
                    </div>
                @endforeach
                {{-- <div id="skeletons" class="row g-4">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="col-lg-6">
                            <div class="card shadow-sm p-4">
                                <div class="placeholder-glow">
                                    <div class="placeholder col-6 mb-2"></div>
                                    <div class="placeholder col-4 mb-3"></div>
                                    <div class="placeholder col-12"></div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div> --}}
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $jobs->links() }}
        </div>


        {{-- People also searched --}}
        @if (isset($peopleAlsoSearched) && $peopleAlsoSearched->count())
            <div class="mb-4 p-3 bg-light rounded-3 border">

                <small class="text-muted fw-semibold d-block mb-2">
                    🔍 People also searched
                </small>

                <div class="d-flex flex-wrap gap-2">

                    @foreach ($peopleAlsoSearched as $item)
                        <a href="{{ $item['url'] }}"
                            class="badge bg-white border text-dark text-decoration-none px-3 py-2 rounded-pill shadow-sm hover-shadow">
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                </div>
            </div>
        @endif


        {{-- 🔥 Hot Jobs Today --}}
        @if (isset($hotJobs) && $hotJobs->count())

            <div class="mb-5">

                <h5 class="fw-bold mb-3 text-danger">
                    🔥 Hot Jobs Today
                </h5>

                <div class="row g-3">

                    @foreach ($hotJobs as $job)
                        <div class="col-md-4">

                            <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                class="text-decoration-none">

                                <div class="card border-0 shadow-sm h-100 hover-shadow">

                                    <div class="card-body">

                                        <span class="badge bg-danger mb-2">
                                            🔥 Trending
                                        </span>

                                        <h6 class="fw-bold mb-1">
                                            @if ($job->company_logo)
                                                <img src="{{ asset($job->company_logo) }}" alt="{{ $job->company_name }}"
                                                    class="rounded-circle border border-success border-2"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                            @endif
                                            {{ $job->title }}
                                        </h6>

                                        <small class="text-muted d-block">
                                            {{ $job->company_name }}
                                            {{-- ✅ Verified Tick --}}
                                            @if ($job->is_verified)
                                                <i class="bi bi-patch-check-fill text-primary" title="Verified Company"
                                                    style="font-size: 14px;"></i>
                                            @endif
                                        </small>

                                        <small class="text-success">
                                            {{ $job->location }}
                                        </small>
                                        {{-- <small class="text-muted">
                                            <i class="bi bi-eye"></i>
                                            {{ $job->clicks }} views today</small> --}}

                                    </div>


                                </div>

                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        @endif

        @php
            $jobUrl = route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]);
            $shareText = $job->title . ' at ' . $job->company_name;
        @endphp

        {{-- Explore More Opportunities --}}
        @if ($recommendedJobs->count())
            <section class="pt-4 pb-5">
                <div class="container">

                    {{-- Section Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold mb-1">Explore More Opportunities</h2>
                            <p class="text-muted mb-0">
                                Hand-picked opportunities you might like
                            </p>
                        </div>
                    </div>

                    <div class="row g-4">
                        @foreach ($recommendedJobs as $job)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 shadow-soft rounded-4 h-100 hover-shadow">

                                    <div class="card-body p-4">

                                        {{-- Company Logo --}}
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            @if ($job->company_logo)
                                                <img src="{{ asset($job->company_logo) }}"
                                                    alt="{{ $job->company_name }}" class="rounded-3"
                                                    style="width:50px;height:50px;object-fit:contain;">
                                            @endif

                                            <div>
                                                <h6 class="mb-0 fw-bold">
                                                    <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                                        class="text-dark text-decoration-none">
                                                        {{ Str::limit($job->title, 45) }}
                                                    </a>
                                                </h6>

                                                <small class="text-muted">
                                                    {{ $job->company_name }}
                                                    @if ($job->is_verified)
                                                        <i class="bi bi-patch-check-fill text-primary"
                                                            title="Verified Company" style="font-size:13px;"></i>
                                                    @endif
                                                </small>
                                            </div>
                                        </div>

                                        {{-- Job Meta --}}
                                        <div class="d-flex flex-wrap gap-3 mb-3 small text-muted">
                                            <span>
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {{ $job->location }}
                                            </span>

                                            <span>
                                                <i class="bi bi-briefcase me-1"></i>
                                                {{ ucfirst($job->job_type) }}
                                            </span>
                                        </div>

                                        {{-- Salary --}}
                                        @if ($job->salary_range)
                                            <div class="mb-3">
                                                <span class="fw-semibold text-success">
                                                    <i class="bi bi-currency-dollar me-1"></i>
                                                    {{ $job->salary_range }}
                                                </span>
                                            </div>
                                        @endif

                                        {{-- CTA --}}
                                        {{-- <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                            class="btn btn-outline-success btn-sm rounded-pill px-3">
                                            View Details
                                        </a> --}}

                                        @if (!$job->isExpired())
                                            <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                                class="btn btn-success rounded-pill px-4 shadow-sm">
                                                View <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        @else
                                            <span class="badge bg-danger text-white rounded-pill px-3 py-2">
                                                <i class="bi bi-x-circle me-1"></i> Expired
                                            </span>
                                        @endif


                                        {{-- Share Row --}}
                                        <div class="share-row mt-3">

                                            <span class="share-label small text-muted me-2">
                                                <i class="bi bi-share me-1"></i> Share
                                            </span>

                                            <div class="share-icons">

                                                {{-- WhatsApp --}}
                                                <a href="https://wa.me/?text={{ urlencode($shareText . ' - Apply here: ' . $jobUrl) }}"
                                                    target="_blank" class="share-btn whatsapp">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>

                                                {{-- Facebook --}}
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($jobUrl) }}"
                                                    target="_blank" class="share-btn facebook">
                                                    <i class="bi bi-facebook"></i>
                                                </a>

                                                {{-- LinkedIn --}}
                                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($jobUrl) }}&title={{ urlencode($shareText) }}"
                                                    target="_blank" class="share-btn linkedin">
                                                    <i class="bi bi-linkedin"></i>
                                                </a>

                                                {{-- Twitter/X --}}
                                                <a href="https://x.com/intent/tweet?url={{ urlencode($jobUrl) }}&text={{ urlencode($shareText) }}"
                                                    target="_blank" class="share-btn x">
                                                    <i class="fab fa-x"></i>
                                                </a>

                                                {{-- Copy --}}
                                                <button onclick="copyLink('{{ $jobUrl }}', this)"
                                                    class="share-btn copy">
                                                    <i class="bi bi-link-45deg"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </section>
        @endif


        @php
            $jobUrl = route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]);
            $shareText = $job->title . ' at ' . $job->company_name;
        @endphp
        @if ($interestedJobs->count())
            <section class="pt-4 pb-5">
                <div class="container">

                    {{-- Section Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold mb-1">Jobs You Might Be Interested In</h2>
                            <p class="text-muted mb-0">
                                Based on your activity and trending roles
                            </p>
                        </div>
                    </div>

                    <div class="row g-4">
                        @foreach ($interestedJobs as $job)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 shadow-soft rounded-4 h-100 hover-shadow">

                                    <div class="card-body p-4">

                                        {{-- Company Logo --}}
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            @if ($job->company_logo)
                                                <img src="{{ asset($job->company_logo) }}"
                                                    alt="{{ $job->company_name }}" class="rounded-3"
                                                    style="width:50px;height:50px;object-fit:contain;">
                                            @endif

                                            <div>
                                                <h6 class="mb-0 fw-bold">
                                                    <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                                        class="text-dark text-decoration-none">
                                                        {{ Str::limit($job->title, 45) }}
                                                    </a>
                                                </h6>

                                                <small class="text-muted">
                                                    {{ $job->company_name }}
                                                    @if ($job->is_verified)
                                                        <i class="bi bi-patch-check-fill text-primary"
                                                            title="Verified Company" style="font-size:13px;"></i>
                                                    @endif
                                                </small>
                                            </div>
                                        </div>

                                        {{-- Job Meta --}}
                                        <div class="d-flex flex-wrap gap-3 mb-3 small text-muted">
                                            <span>
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {{ $job->location }}
                                            </span>

                                            <span>
                                                <i class="bi bi-briefcase me-1"></i>
                                                {{ ucfirst($job->job_type) }}
                                            </span>
                                        </div>

                                        {{-- Salary --}}
                                        @if ($job->salary_range)
                                            <div class="mb-3">
                                                <span class="fw-semibold text-success">
                                                    <i class="bi bi-currency-dollar me-1"></i>
                                                    {{ $job->salary_range }}
                                                </span>
                                            </div>
                                        @endif

                                        {{-- CTA --}}
                                        {{-- <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                            class="btn btn-outline-success btn-sm rounded-pill px-3">
                                            View Details
                                        </a> --}}
                                        @if (!$job->isExpired())
                                            <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                                class="btn btn-success rounded-pill px-4 shadow-sm">
                                                View <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        @else
                                            <span class="badge bg-danger text-white rounded-pill px-3 py-2">
                                                <i class="bi bi-x-circle me-1"></i> Expired
                                            </span>
                                        @endif

                                        {{-- Share Row --}}
                                        <div class="share-row mt-3">

                                            <span class="share-label small text-muted me-2">
                                                <i class="bi bi-share me-1"></i> Share
                                            </span>

                                            <div class="share-icons">

                                                {{-- WhatsApp --}}
                                                <a href="https://wa.me/?text={{ urlencode($shareText . ' - Apply here: ' . $jobUrl) }}"
                                                    target="_blank" class="share-btn whatsapp">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>

                                                {{-- Facebook --}}
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($jobUrl) }}"
                                                    target="_blank" class="share-btn facebook">
                                                    <i class="bi bi-facebook"></i>
                                                </a>

                                                {{-- LinkedIn --}}
                                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($jobUrl) }}&title={{ urlencode($shareText) }}"
                                                    target="_blank" class="share-btn linkedin">
                                                    <i class="bi bi-linkedin"></i>
                                                </a>

                                                {{-- Twitter/X --}}
                                                <a href="https://x.com/intent/tweet?url={{ urlencode($jobUrl) }}&text={{ urlencode($shareText) }}"
                                                    target="_blank" class="share-btn x">
                                                    <i class="fab fa-x"></i>
                                                </a>

                                                {{-- Copy --}}
                                                <button onclick="copyLink('{{ $jobUrl }}', this)"
                                                    class="share-btn copy">
                                                    <i class="bi bi-link-45deg"></i>
                                                </button>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </section>
        @endif


        @php
            $jobUrl = route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]);
            $shareText = $job->title . ' at ' . $job->company_name;
        @endphp

        @if ($abujaJobs->count())
            <section class="pt-4 pb-5">
                <div class="container">

                    {{-- Section Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold mb-1">Jobs In Abuja, Nigeria</h2>
                            <p class="text-muted mb-0">
                                Explore active opportunities currently available in Abuja, Nigeria.
                            </p>
                        </div>
                    </div>

                    <div class="row g-4">
                        @foreach ($abujaJobs as $job)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 shadow-soft rounded-4 h-100 hover-shadow">

                                    <div class="card-body p-4">

                                        {{-- Company Logo --}}
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            @if ($job->company_logo)
                                                <img src="{{ asset($job->company_logo) }}"
                                                    alt="{{ $job->company_name }}" class="rounded-3"
                                                    style="width:50px;height:50px;object-fit:contain;">
                                            @endif

                                            <div>
                                                <h6 class="mb-0 fw-bold">
                                                    <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                                        class="text-dark text-decoration-none">
                                                        {{ Str::limit($job->title, 45) }}
                                                    </a>
                                                </h6>

                                                <small class="text-muted">
                                                    {{ $job->company_name }}
                                                    @if ($job->is_verified)
                                                        <i class="bi bi-patch-check-fill text-primary"
                                                            title="Verified Company" style="font-size:13px;"></i>
                                                    @endif
                                                </small>
                                            </div>
                                        </div>

                                        {{-- Job Meta --}}
                                        <div class="d-flex flex-wrap gap-3 mb-3 small text-muted">
                                            <span>
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {{ $job->location }}
                                            </span>

                                            <span>
                                                <i class="bi bi-briefcase me-1"></i>
                                                {{ ucfirst($job->job_type) }}
                                            </span>
                                        </div>

                                        {{-- Salary --}}
                                        @if ($job->salary_range)
                                            <div class="mb-3">
                                                <span class="fw-semibold text-success">
                                                    <i class="bi bi-currency-dollar me-1"></i>
                                                    {{ $job->salary_range }}
                                                </span>
                                            </div>
                                        @endif

                                        {{-- CTA --}}
                                        {{-- <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                            class="btn btn-outline-success btn-sm rounded-pill px-3">
                                            View Details
                                        </a> --}}
                                        @if (!$job->isExpired())
                                            <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                                class="btn btn-success rounded-pill px-4 shadow-sm">
                                                View <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        @else
                                            <span class="badge bg-danger text-white rounded-pill px-3 py-2">
                                                <i class="bi bi-x-circle me-1"></i> Expired
                                            </span>
                                        @endif


                                        {{-- Share Row --}}
                                        <div class="share-row mt-3">

                                            <span class="share-label small text-muted me-2">
                                                <i class="bi bi-share me-1"></i> Share
                                            </span>

                                            <div class="share-icons">

                                                {{-- WhatsApp --}}
                                                <a href="https://wa.me/?text={{ urlencode($shareText . ' - Apply here: ' . $jobUrl) }}"
                                                    target="_blank" class="share-btn whatsapp">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>

                                                {{-- Facebook --}}
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($jobUrl) }}"
                                                    target="_blank" class="share-btn facebook">
                                                    <i class="bi bi-facebook"></i>
                                                </a>

                                                {{-- LinkedIn --}}
                                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($jobUrl) }}&title={{ urlencode($shareText) }}"
                                                    target="_blank" class="share-btn linkedin">
                                                    <i class="bi bi-linkedin"></i>
                                                </a>

                                                {{-- Twitter/X --}}
                                                <a href="https://x.com/intent/tweet?url={{ urlencode($jobUrl) }}&text={{ urlencode($shareText) }}"
                                                    target="_blank" class="share-btn x">
                                                    <i class="fab fa-x"></i>
                                                </a>

                                                {{-- Copy --}}
                                                <button onclick="copyLink('{{ $jobUrl }}', this)"
                                                    class="share-btn copy">
                                                    <i class="bi bi-link-45deg"></i>
                                                </button>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </section>
        @endif

        @php
            $jobUrl = route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]);
            $shareText = $job->title . ' at ' . $job->company_name;
        @endphp

        @if ($lagosJobs->count())
            <section class="pt-4 pb-5">
                <div class="container">

                    {{-- Section Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold mb-1">Jobs In Lagos, Nigeria</h2>
                            <p class="text-muted mb-0">
                                Explore active opportunities currently available in Lagos, Nigeria.
                            </p>
                        </div>
                    </div>

                    <div class="row g-4">
                        @foreach ($lagosJobs as $job)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 shadow-soft rounded-4 h-100 hover-shadow">

                                    <div class="card-body p-4">

                                        {{-- Company Logo --}}
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            @if ($job->company_logo)
                                                <img src="{{ asset($job->company_logo) }}"
                                                    alt="{{ $job->company_name }}" class="rounded-3"
                                                    style="width:50px;height:50px;object-fit:contain;">
                                            @endif

                                            <div>
                                                <h6 class="mb-0 fw-bold">
                                                    <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                                        class="text-dark text-decoration-none">
                                                        {{ Str::limit($job->title, 45) }}
                                                    </a>
                                                </h6>

                                                <small class="text-muted">
                                                    {{ $job->company_name }}
                                                    @if ($job->is_verified)
                                                        <i class="bi bi-patch-check-fill text-primary"
                                                            title="Verified Company" style="font-size:13px;"></i>
                                                    @endif
                                                </small>
                                            </div>
                                        </div>

                                        {{-- Job Meta --}}
                                        <div class="d-flex flex-wrap gap-3 mb-3 small text-muted">
                                            <span>
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {{ $job->location }}
                                            </span>

                                            <span>
                                                <i class="bi bi-briefcase me-1"></i>
                                                {{ ucfirst($job->job_type) }}
                                            </span>
                                        </div>

                                        {{-- Salary --}}
                                        @if ($job->salary_range)
                                            <div class="mb-3">
                                                <span class="fw-semibold text-success">
                                                    <i class="bi bi-currency-dollar me-1"></i>
                                                    {{ $job->salary_range }}
                                                </span>
                                            </div>
                                        @endif

                                        {{-- CTA --}}
                                        {{-- <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                            class="btn btn-outline-success btn-sm rounded-pill px-3">
                                            View Details
                                        </a> --}}
                                        @if (!$job->isExpired())
                                            <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                                                class="btn btn-success rounded-pill px-4 shadow-sm">
                                                View <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        @else
                                            <span class="badge bg-danger text-white rounded-pill px-3 py-2">
                                                <i class="bi bi-x-circle me-1"></i> Expired
                                            </span>
                                        @endif

                                        {{-- Share Row --}}
                                        <div class="share-row mt-3">

                                            <span class="share-label small text-muted me-2">
                                                <i class="bi bi-share me-1"></i> Share
                                            </span>

                                            <div class="share-icons">

                                                {{-- WhatsApp --}}
                                                <a href="https://wa.me/?text={{ urlencode($shareText . ' - Apply here: ' . $jobUrl) }}"
                                                    target="_blank" class="share-btn whatsapp">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>

                                                {{-- Facebook --}}
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($jobUrl) }}"
                                                    target="_blank" class="share-btn facebook">
                                                    <i class="bi bi-facebook"></i>
                                                </a>

                                                {{-- LinkedIn --}}
                                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($jobUrl) }}&title={{ urlencode($shareText) }}"
                                                    target="_blank" class="share-btn linkedin">
                                                    <i class="bi bi-linkedin"></i>
                                                </a>

                                                {{-- Twitter/X --}}
                                                <a href="https://x.com/intent/tweet?url={{ urlencode($jobUrl) }}&text={{ urlencode($shareText) }}"
                                                    target="_blank" class="share-btn x">
                                                    <i class="fab fa-x"></i>
                                                </a>

                                                {{-- Copy --}}
                                                <button onclick="copyLink('{{ $jobUrl }}', this)"
                                                    class="share-btn copy">
                                                    <i class="bi bi-link-45deg"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </section>
        @endif

    </div>
@endsection

<script>
    window.addEventListener('load', () => {
        document.getElementById('skeletons')?.remove();
    });
</script>

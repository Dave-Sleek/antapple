@extends('layouts.app')

@section('title', $job->title . ' at ' . $job->company_name)
@section('description', Str::limit(strip_tags($job->short_description), 160))


@section('canonical')
    <link rel="canonical" href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}">
@endsection


@section('meta')
    @php
        $jobUrl = route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]);
        $title = $job->title . ' at ' . $job->company_name;
        $description = Str::limit(strip_tags($job->short_description), 160);
        $image = $job->company_logo ? asset($job->company_logo) : asset('images/job-default-share.png');
    @endphp

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $jobUrl }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $image }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $image }}">
@endsection


@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'JobPosting',
        'title' => $job->title,
        'description' => strip_tags($job->short_description),
        'datePosted' => $job->created_at->toDateString(),
        'employmentType' => strtoupper($job->job_type),
        'directApply' => true,
        'hiringOrganization' => [
            '@type' => 'Organization',
            'name' => $job->company_name,
        ],
        'experienceRequirements' => [
            '@type' => 'OccupationalExperienceRequirements',
            'monthsOfExperience' =>
                $job->experience_level === 'entry' ? 0 : ($job->experience_level === 'mid' ? 24 : 60),
        ],
    ];

    if ($job->deadline) {
        $schema['validThrough'] = $job->deadline->toDateString();
    }

    if ($job->company_logo) {
        $schema['hiringOrganization']['logo'] = $job->company_logo;
    }

    if (Str::contains(strtolower($job->location), 'remote')) {
        $schema['jobLocationType'] = 'TELECOMMUTE';
        $schema['applicantLocationRequirements'] = [
            '@type' => 'Country',
            'name' => 'Anywhere',
        ];
    } else {
        $schema['jobLocation'] = [
            '@type' => 'Place',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $job->location,
            ],
        ];
    }

    if ($job->salary_range) {
        $schema['baseSalary'] = [
            '@type' => 'MonetaryAmount',
            'currency' => 'USD',
            'value' => [
                '@type' => 'QuantitativeValue',
                'value' => $job->salary_range,
                'unitText' => 'MONTH',
            ],
        ];
    }
@endphp


<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>


@section('content')
    <div class="container py-5 py-lg-6">
        {{-- Hero Section --}}
        <div class="mb-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}" class="text-decoration-none">Home</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}" class="text-decoration-none">Jobs</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($job->title, 30) }}</li>
                </ol>
            </nav>
        </div>

        <div class="row g-5">
            {{-- Main Content --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-soft rounded-4 overflow-hidden">
                    {{-- Header with Green Accent --}}
                    <div class="bg-success-gradient-light py-4 px-5 border-bottom border-success border-2">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="flex-grow-1 pe-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    @if ($job->company_logo)
                                        <div class="bg-white rounded-3 p-2 shadow-sm">
                                            <img src="{{ asset('storage/' . $job->company_logo) }}"
                                                alt="{{ $job->company_name }} logo" class="rounded-2"
                                                style="width: 64px; height: 64px; object-fit: contain;">
                                        </div>
                                    @endif
                                    <div>
                                        <h1 class="h2 fw-bold text-dark mb-1">{{ $job->title }}</h1>
                                        <div class="d-flex align-items-center gap-2 text-success-dark">
                                            <i class="bi bi-building fs-5"></i>
                                            <span class="fs-5 fw-medium">{{ $job->company_name }}</span>
                                            {{-- Verified Tick --}}
                                            @if ($job->is_verified)
                                                <i class="bi bi-patch-check-fill text-primary" title="Verified Company"
                                                    style="font-size: 14px;"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-shrink-0">
                                @if ($job->is_featured)
                                    <span class="badge bg-success text-white rounded-pill px-4 py-2 shadow-sm">
                                        <i class="bi bi-award me-2"></i>Featured
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body p-5">
                        {{-- Status Indicator --}}
                        <div class="mb-4">
                            @if ($job->isExpired())
                                <div class="alert alert-danger border-0 rounded-3 py-3 px-4 bg-danger-soft">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-x-circle-fill fs-4 text-danger me-3"></i>
                                        <div>
                                            <h6 class="fw-bold text-danger mb-1">This position is no longer accepting
                                                applications</h6>
                                            <p class="text-muted mb-0 small">The application deadline has passed</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-success border-0 rounded-3 py-3 px-4 bg-success-soft">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill fs-4 text-success me-3"></i>
                                        <div>
                                            <h6 class="fw-bold text-success mb-1">Accepting Applications</h6>
                                            <p class="text-muted mb-0 small">Apply before
                                                {{ $job->deadline ? $job->deadline->format('F d, Y') : 'the deadline' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Key Information Grid --}}
                        <div class="row g-4 mb-5">
                            <div class="col-md-6 col-lg-3">
                                <div class="bg-success-soft rounded-3 p-3 h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="bg-success rounded-circle p-2">
                                            <i class="bi bi-briefcase text-white"></i>
                                        </div>
                                        <h6 class="mb-0 fw-semibold text-dark">Job Type</h6>
                                    </div>
                                    <p class="text-success fw-bold mb-0">{{ ucfirst($job->job_type) }}</p>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="bg-success-soft rounded-3 p-3 h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="bg-success rounded-circle p-2">
                                            <i class="bi bi-bar-chart text-white"></i>
                                        </div>
                                        <h6 class="mb-0 fw-semibold text-dark">Experience</h6>
                                    </div>
                                    <p class="text-success fw-bold mb-0">{{ ucfirst($job->experience_level) }}</p>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="bg-success-soft rounded-3 p-3 h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="bg-success rounded-circle p-2">
                                            <i class="bi bi-geo-alt text-white"></i>
                                        </div>
                                        <h6 class="mb-0 fw-semibold text-dark">Location</h6>
                                    </div>
                                    <p class="text-success fw-bold mb-0">{{ $job->location }}</p>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="bg-success-soft rounded-3 p-3 h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="bg-success rounded-circle p-2">
                                            <i class="bi bi-folder text-white"></i>
                                        </div>
                                        <h6 class="mb-0 fw-semibold text-dark">Category</h6>
                                    </div>
                                    <p class="text-success fw-bold mb-0">{{ $job->category->name ?? 'General' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Salary & Deadline Highlight --}}
                        <div class="row g-4 mb-5">
                            @if ($job->salary_range)
                                <div class="col-md-6">
                                    <div class="bg-success border border-success border-2 rounded-4 p-4 shadow-sm">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="text-white mb-1 fw-semibold">Salary Range </h6>
                                                <h3 class="text-white fw-bold mb-0">
                                                    {{-- <span class="text-white fs-5">&#8358;</span> --}}
                                                    {{ $job->salary_range }}
                                                </h3>
                                                <small class="text-white-75">Monthly compensation</small>
                                            </div>
                                            <div class="bg-white rounded-circle p-3">
                                                <i class="bi bi-cash-coin text-success fs-3"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($job->deadline)
                                <div class="col-md-6">
                                    <div class="bg-white border border-success border-2 rounded-4 p-4 shadow-sm">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="text-success mb-1 fw-semibold">Application Deadline</h6>
                                                <h3 class="text-dark fw-bold mb-0">{{ $job->deadline->format('M d, Y') }}
                                                </h3>
                                                <small class="text-muted">
                                                    @php
                                                        $daysLeft = now()->diff($job->deadline)->days;
                                                    @endphp

                                                    @if ($daysLeft > 0)
                                                        <span class="text-success fw-semibold">{{ $daysLeft }} days
                                                            left</span>
                                                    @else
                                                        <span class="text-danger fw-semibold">Deadline passed</span>
                                                    @endif

                                                </small>
                                            </div>
                                            <div class="bg-success-soft rounded-circle p-3">
                                                <i class="bi bi-calendar-check text-success fs-3"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Job Description --}}
                        <div class="mb-5">
                            <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom">
                                <div class="bg-success rounded-circle p-2">
                                    <i class="bi bi-file-text text-white"></i>
                                </div>
                                <h3 class="h4 fw-bold text-dark mb-0">Job Description</h3>
                            </div>

                            <div class="prose">
                                {!! $job->short_description !!}
                            </div>
                        </div>

                        {{-- Application CTA --}}
                        <div class="text-center py-4">
                            @if (!$job->isExpired())
                                <a href="{{ route('jobs.external.apply', $job) }}"
                                    class="btn btn-success btn-lg rounded-pill px-6 py-3 shadow-lg hover-lift"
                                    target="_blank" rel="nofollow noopener">
                                    <i class="bi bi-send-check me-2"></i>Apply on company website
                                </a>

                                <p class="text-muted mt-3 small">
                                    <i class="bi bi-shield-check text-success me-1"></i>
                                    You'll be redirected to the company's official application portal
                                </p>
                            @else
                                <div class="alert alert-light border py-4">
                                    <i class="bi bi-info-circle-fill text-secondary fs-3 d-block mb-2"></i>
                                    <h4 class="h5 text-secondary mb-2">Applications Closed</h4>
                                    <p class="text-muted mb-0">
                                        This position is no longer accepting applications. Check out similar opportunities
                                        below.
                                    </p>
                                </div>
                            @endif
                        </div>

                        {{-- Report Section --}}
                        <div class="mt-5 pt-4 border-top">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted fw-semibold mb-1">
                                        <i class="bi bi-flag me-2"></i>Notice something wrong?
                                    </h6>
                                    <p class="text-muted small mb-0">Help maintain job quality by reporting issues</p>
                                </div>
                                <button type="button" class="btn btn-outline-success rounded-pill px-4"
                                    data-bs-toggle="modal" data-bs-target="#reportModal">
                                    Report Job
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Company Info Card --}}
                <div class="card border-0 shadow-soft rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-dark">
                            <i class="bi bi-building text-success me-2"></i>About the Company
                        </h5>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            @if ($job->company_logo)
                                <img src="{{ asset('storage/' . $job->company_logo) }}" alt="{{ $job->company_name }}"
                                    class="rounded-3"
                                    style="width: 60px; height: 60px; object-fit: contain; background: #f8f9fa; padding: 8px;">
                            @endif
                            <div>
                                <h6 class="fw-bold mb-1">{{ $job->company_name }}
                                    {{-- ✅ Verified Tick --}}
                                    @if ($job->is_verified)
                                        <i class="bi bi-patch-check-fill text-primary" title="Verified Company"
                                            style="font-size: 14px;"></i>
                                    @endif
                                </h6>
                                <p class="text-muted small mb-0">{{ $job->location }}</p>
                                <p class="text-muted mb-0">
                                    {!! $job->about_company !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Job Details Card --}}
                <div class="card border-0 shadow-soft rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-dark">
                            <i class="bi bi-info-circle text-success me-2"></i>Job Details
                        </h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3 d-flex align-items-center">
                                <i class="bi bi-clock text-success me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Posted</small>
                                    <span class="fw-semibold">{{ $job->created_at->diffForHumans() }}</span>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="bi bi-link-45deg text-success me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Source</small>
                                    <span class="fw-semibold">{{ ucfirst($job->source ?? 'Company Website') }}</span>
                                </div>
                            </li>
                            @if ($job->isExpired())
                                <li class="d-flex align-items-center">
                                    <i class="bi bi-x-circle text-danger me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Status</small>
                                        <span class="fw-semibold text-danger">Position Closed</span>
                                    </div>
                                </li>
                            @endif

                            {{-- Views --}}
                            <li class="mb-3 d-flex align-items-center">
                                <i class="bi bi-eye text-success me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Views</small>
                                    <span class="fw-semibold">{{ number_format($job->job_views_count) }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Share Job --}}
                @php
                    $jobUrl = route('jobs.show', [
                        'job' => $job->uuid,
                        'slug' => $job->slug,
                    ]);
                    $shareText = $job->title . ' at ' . $job->company_name;
                @endphp

                {{-- Share Job --}}
                <div class="card border-0 shadow-soft rounded-4 mb-4">
                    <div class="card-body p-4">

                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-share-fill text-success me-2"></i>
                            Share this job
                        </h6>

                        <div class="share-big">

                            {{-- Native share (mobile first) --}}
                            <button class="share-circle share-native"
                                onclick="nativeShare('{{ $shareText }}','{{ $jobUrl }}')">
                                <i class="bi bi-upload"></i>
                            </button>

                            {{-- WhatsApp --}}
                            <a href="https://wa.me/?text={{ urlencode($shareText . ' - ' . $jobUrl) }}" target="_blank"
                                class="share-circle whatsapp">
                                <i class="bi bi-whatsapp"></i>
                            </a>

                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($jobUrl) }}"
                                target="_blank" class="share-circle facebook">
                                <i class="bi bi-facebook"></i>
                            </a>

                            {{-- LinkedIn --}}
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($jobUrl) }}&title={{ urlencode($shareText) }}"
                                target="_blank" class="share-circle linkedin">
                                <i class="bi bi-linkedin"></i>
                            </a>

                            {{-- Twitter/X --}}
                            <a href="https://x.com/intent/tweet?url={{ urlencode($jobUrl) }}&text={{ urlencode($shareText) }}"
                                target="_blank" class="share-circle twitter">
                                <i class="fab fa-x"></i>
                            </a>

                            {{-- Copy --}}
                            <button class="share-circle copy" onclick="copyLink('{{ $jobUrl }}', this)">
                                <i class="bi bi-link-45deg"></i>
                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Similar Jobs --}}
        @if ($similarJobs->count())
            <div class="mt-6 pt-5">

                @if ($similarJobs->count())
                    @include('jobs.partials.job-section', [
                        'title' => 'Similar Opportunities',
                        'jobs' => $similarJobs,
                    ])
                    {{-- Pagination --}}
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $similarJobs->links() }}</div>
                @endif


                @if ($companyJobs->count())
                    @include('jobs.partials.job-section', [
                        'title' => 'More from this company',
                        'jobs' => $companyJobs,
                    ])
                    {{-- Pagination --}}
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $companyJobs->links() }}</div>
                @endif


                @if ($recentJobs->count())
                    @include('jobs.partials.job-section', [
                        'title' => 'Recently viewed',
                        'jobs' => $recentJobs,
                    ])
                    {{-- Pagination --}}
                @endif

                @if ($recommendedJobs->count())
                    @include('jobs.partials.job-section', [
                        'title' => 'Recommended for you',
                        'jobs' => $recommendedJobs,
                    ])
                    {{-- Pagination --}}
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $recommendedJobs->links() }}</div>
                @endif



                {{-- View all button --}}
                <div class="col-12 text-center mt-4">
                    <a href="{{ route('jobs.index') }}" class="btn btn-outline-success rounded-pill px-4">
                        <i class="bi bi-search me-2"></i>
                        View All Jobs
                    </a>
                </div>

            </div>
    </div>
    @endif
    </div>

    {{-- Report Modal --}}
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-flag text-success me-2"></i>Report This Job
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('jobs.report', $job) }}">
                    <input type="hidden" name="job_post_id" value="{{ $job->id }}">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted mb-4">
                            Please select the reason for reporting this job listing:
                        </p>

                        <div class="mb-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="reason" id="reason1"
                                    value="Scam" required>
                                <label class="form-check-label" for="reason1">
                                    <span class="fw-semibold">Suspected Scam</span>
                                    <small class="text-muted d-block">Fraudulent or misleading information</small>
                                </label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="reason" id="reason2"
                                    value="Expired">
                                <label class="form-check-label" for="reason2">
                                    <span class="fw-semibold">Position Expired</span>
                                    <small class="text-muted d-block">Job is no longer available</small>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reason" id="reason3"
                                    value="Incorrect info">
                                <label class="form-check-label" for="reason3">
                                    <span class="fw-semibold">Inaccurate Information</span>
                                    <small class="text-muted d-block">Details don't match the actual position</small>
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="additionalInfo" class="form-label small text-muted">Additional details
                                (optional)</label>
                            <textarea class="form-control" id="additionalInfo" name="message" rows="3"
                                placeholder="Please provide any additional information..."></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="bi bi-send me-2"></i>Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


<script>
    function copyLink(url, btn) {
        navigator.clipboard.writeText(url);
        btn.innerHTML = '<i class="bi bi-check-lg"></i>';

        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-link-45deg"></i>';
        }, 1200);
    }

    function nativeShare(title, url) {
        if (navigator.share) {
            navigator.share({
                title: title,
                url: url
            });
        }
    }
</script>


<style>
    .bg-success-gradient-light {
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.05) 0%, rgba(25, 135, 84, 0.1) 100%);
    }

    .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .text-success-dark {
        color: #198754;
    }

    .shadow-soft {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .prose {
        line-height: 1.7;
        color: #374151;
        font-size: 1.05rem;
    }

    .prose p {
        margin-bottom: 1.2rem;
    }

    .prose ul,
    .prose ol {
        padding-left: 1.5rem;
        margin-bottom: 1.2rem;
    }

    .prose li {
        margin-bottom: 0.5rem;
    }

    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(25, 135, 84, 0.3) !important;
    }

    .border-success {
        border-color: #198754 !important;
    }

    .text-white-75 {
        color: rgba(255, 255, 255, 0.75);
    }

    /* Custom colors for better green theme */
    .btn-success {
        background: linear-gradient(135deg, #198754, #157347);
        border-color: #198754;
    }

    .btn-outline-success:hover {
        background: linear-gradient(135deg, #198754, #157347);
        border-color: #198754;
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #198754, #20c997);
    }

    .hover-shadow {
        transition: all 0.2s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .hover-shadow {
        transition: all .2s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, .08);
    }
</style>

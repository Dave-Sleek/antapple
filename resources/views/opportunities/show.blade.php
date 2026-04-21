@extends('layouts.app')
<meta name="robots" content="index, follow">
{{-- <link rel="canonical" href="{{ $url }}"> --}}

@section('title', $opportunity->title . ' - Sproutplex Opportunities')
@section('description', Str::limit(strip_tags($opportunity->description), 160))


@section('meta')
    @php
        $url = route('opportunities.show', [
            'uuid' => $opportunity->uuid,
            'slug' => $opportunity->slug,
        ]);

        $title = $opportunity->title;
        $description = Str::limit(strip_tags($opportunity->description), 160);
        $image = $opportunity->image ? asset($opportunity->image) : asset('images/opportunity-default.png');
    @endphp

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $url }}">
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
        '@type' => 'CreativeWork', // flexible for all opportunity types
        'name' => $opportunity->title,
        'description' => strip_tags($opportunity->description),
        'url' => $url,
        'datePublished' => $opportunity->created_at->toDateString(),
        'provider' => [
            '@type' => 'Organization',
            'name' => $opportunity->provider_name ?? config('app.name'),
        ],
    ];

    // Deadline (very important for opportunities)
    if ($opportunity->deadline) {
        $schema['validThrough'] = $opportunity->deadline->toDateString();
    }

    // Location logic
    if ($opportunity->is_remote) {
        $schema['eventAttendanceMode'] = 'https://schema.org/OnlineEventAttendanceMode';
    } elseif ($opportunity->location) {
        $schema['location'] = [
            '@type' => 'Place',
            'name' => $opportunity->location,
        ];
    }

    // Add image if exists
    if ($opportunity->image) {
        $schema['image'] = asset($opportunity->image);
    }

    // Optional: category/type
    if ($opportunity->type) {
        $schema['keywords'] = $opportunity->type;
    }

    if ($opportunity->type === 'internship') {
        $schema['@type'] = 'JobPosting';
    } elseif ($opportunity->type === 'scholarship') {
        $schema['@type'] = 'EducationalOccupationalProgram';
    }
@endphp

<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

@section('content')
    <div class="container py-5">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('opportunities.index') }}"
                        class="text-decoration-none">Opportunities</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($opportunity->title, 50) }}</li>
            </ol>
        </nav>

        <div class="row g-4">

            {{-- Main Content --}}
            <div class="col-lg-8">

                {{-- Premium Header Card --}}
                <div class="premium-header-card mb-4">
                    {{-- Type Badge --}}
                    <div class="type-badge type-{{ $opportunity->type }}">
                        @switch($opportunity->type)
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
                                <i class="bi bi-star"></i> {{ ucfirst(str_replace('_', ' ', $opportunity->type)) }}
                        @endswitch
                    </div>

                    {{-- Featured Badge --}}
                    @if ($opportunity->is_featured ?? false)
                        <div class="featured-badge">
                            <i class="bi bi-star-fill"></i>
                            Featured
                        </div>
                    @endif


                    @if ($opportunity->image)
                        {{-- <img src="{{ asset('storage/' . $opportunity->image) }}" class="img-fluid rounded mb-3"> --}}
                        <img src="{{ $opportunity->image ? asset('storage/' . $opportunity->image) : asset('images/default.png') }}"
                            class="img-fluid rounded mb-2 w-100">
                    @endif
                    <h1 class="opportunity-title">{{ $opportunity->title }}</h1>

                    <div class="opportunity-meta">
                        @if ($opportunity->organization)
                            <div class="meta-item">
                                <i class="bi bi-building"></i>
                                <span>{{ $opportunity->organization }}</span>
                            </div>
                        @endif
                        @if ($opportunity->location)
                            <div class="meta-item">
                                <i class="bi bi-geo-alt"></i>
                                <span>{{ $opportunity->location }}</span>
                            </div>
                        @endif
                        @if ($opportunity->is_remote)
                            <div class="meta-item remote">
                                <i class="bi bi-wifi"></i>
                                <span>Remote</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Description Section --}}
                <div class="premium-content-card mb-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-file-text"></i>
                            <h5 class="fw-bold mb-0">Description</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="opportunity-description">
                            {!! $opportunity->description !!}
                        </div>
                    </div>
                </div>

                {{-- Requirements Section (if available) --}}
                @if ($opportunity->requirements)
                    <div class="premium-content-card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle"></i>
                                <h5 class="fw-bold mb-0">Requirements</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="requirements-list">
                                {!! $opportunity->requirements !!}
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Benefits Section (if available) --}}
                @if ($opportunity->benefits)
                    <div class="premium-content-card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-gift"></i>
                                <h5 class="fw-bold mb-0">Benefits</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="benefits-list">
                                {!! $opportunity->benefits !!}
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Apply Button --}}
                {{-- Apply Button --}}
                @if ($opportunity->apply_url)
                    <div class="apply-section">
                        <a href="{{ route('opportunities.apply', $opportunity->uuid) }}" target="_blank"
                            rel="noopener noreferrer" class="btn-apply"
                            onclick="this.innerHTML='Redirecting...'; this.style.pointerEvents='none';">

                            <span>Apply Now</span>
                            <i class="bi bi-arrow-right"></i>
                            <div class="btn-glow"></div>
                        </a>

                        <p class="apply-note">
                            <i class="bi bi-shield-check"></i>
                            Secure redirect to official application page
                        </p>

                        @if ($opportunity->clicks)
                            <small class="text-muted d-block mt-2">
                                {{ $opportunity->clicks }} people have applied
                            </small>
                        @endif

                        @if ($opportunity->views > 0)
                            <small class="text-success">
                                {{ round(($opportunity->clicks / $opportunity->views) * 100, 1) }}% applied
                            </small>
                        @endif
                    </div>
                @endif

                {{-- Share Section --}}
                <div class="share-section mt-4">
                    <span class="share-label">Share this opportunity:</span>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            target="_blank" class="share-btn facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($opportunity->title) }}"
                            target="_blank" class="share-btn twitter">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                            target="_blank" class="share-btn linkedin">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($opportunity->title . ' - ' . url()->current()) }}"
                            target="_blank" class="share-btn whatsapp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <button class="share-btn copy" onclick="copyLink()">
                            <i class="bi bi-link"></i>
                        </button>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- Details Card --}}
                <div class="sidebar-card mb-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-info-circle"></i>
                            <h6 class="fw-bold mb-0">Opportunity Details</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="detail-list">
                            @if ($opportunity->salary_range)
                                <div class="detail-item">
                                    <div class="detail-icon salary">
                                        <i class="bi bi-cash"></i>
                                    </div>
                                    <div class="detail-content">
                                        <span class="detail-label">Salary / Stipend</span>
                                        <span class="detail-value">{{ $opportunity->salary_range }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($opportunity->funding_type)
                                <div class="detail-item">
                                    <div class="detail-icon funding">
                                        <i class="bi bi-gift"></i>
                                    </div>
                                    <div class="detail-content">
                                        <span class="detail-label">Funding Type</span>
                                        <span class="detail-value">{{ $opportunity->funding_type }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($opportunity->deadline)
                                <div class="detail-item">
                                    <div
                                        class="detail-icon deadline {{ $opportunity->deadline->isPast() ? 'expired' : '' }}">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <div class="detail-content">
                                        <span class="detail-label">Application Deadline</span>
                                        <span
                                            class="detail-value {{ $opportunity->deadline->isPast() ? 'expired' : '' }}">
                                            {{ $opportunity->deadline->format('F d, Y') }}
                                            @if (!$opportunity->deadline->isPast())
                                                {{-- <span class="days-left">
                                                    ({{ \Carbon\Carbon::now()->diffInDays($opportunity->deadline) }} days
                                                    left)
                                                </span> --}}
                                                <span class="days-left">
                                                    ({{ round(\Carbon\Carbon::now()->diffInDays($opportunity->deadline)) }}
                                                    days left)
                                                </span>
                                            @else
                                                <span class="expired-badge">Expired</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif

                            @if ($opportunity->duration)
                                <div class="detail-item">
                                    <div class="detail-icon duration">
                                        <i class="bi bi-hourglass-split"></i>
                                    </div>
                                    <div class="detail-content">
                                        <span class="detail-label">Duration</span>
                                        <span class="detail-value">{{ $opportunity->duration }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($opportunity->start_date)
                                <div class="detail-item">
                                    <div class="detail-icon start">
                                        <i class="bi bi-calendar-plus"></i>
                                    </div>
                                    <div class="detail-content">
                                        <span class="detail-label">Start Date</span>
                                        <span
                                            class="detail-value">{{ \Carbon\Carbon::parse($opportunity->start_date)->format('F d, Y') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Organization Card --}}
                @if ($opportunity->organization)
                    <div class="sidebar-card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-building"></i>
                                <h6 class="fw-bold mb-0">About the Organization</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="organization-info">
                                <div class="org-name">{{ $opportunity->organization }}</div>
                                @if ($opportunity->organization_website)
                                    <a href="{{ $opportunity->organization_website }}" target="_blank"
                                        class="org-website">
                                        <i class="bi bi-globe"></i>
                                        {{ parse_url($opportunity->organization_website, PHP_URL_HOST) }}
                                    </a>
                                @endif
                                @if ($opportunity->organization_description)
                                    <p class="org-description">
                                        {{ Str::limit($opportunity->organization_description, 150) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Tags Section --}}
                @if ($opportunity->tags)
                    <div class="sidebar-card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-tags"></i>
                                <h6 class="fw-bold mb-0">Tags</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tags-list">
                                @foreach (explode(',', $opportunity->tags) as $tag)
                                    <span class="tag">{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- <h5>🔥 Trending Opportunities</h5> --}}

                {{-- @foreach ($trending as $item)
                    <p>
                        {{ $item->title }} — {{ $item->viewsRelation_count }} views
                    </p>
                @endforeach --}}

                {{-- Similar Opportunities --}}
                @if (isset($similarOpportunities) && $similarOpportunities->count())
                    <div class="sidebar-card">
                        <div class="card-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-star"></i>
                                <h6 class="fw-bold mb-0">Similar Opportunities</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="similar-list">
                                @foreach ($similarOpportunities->take(5) as $similar)
                                    <a href="{{ route('opportunities.show', [$similar->uuid, $similar->slug]) }}"
                                        class="similar-item">
                                        <div>
                                            <div class="similar-title">{{ $similar->title }}</div>
                                            <div class="similar-org">{{ $similar->organization }}</div>
                                        </div>
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- Related Opportunities Section (full width) --}}
        @if (isset($relatedOpportunities) && $relatedOpportunities->count() > 3)
            <div class="related-section mt-5">
                <h4 class="fw-bold mb-4">You Might Also Like</h4>
                <div class="related-grid">
                    @foreach ($relatedOpportunities->take(3) as $related)
                        <div class="related-card">
                            <div class="related-badge type-{{ $related->type }}">
                                {{ ucfirst(str_replace('_', ' ', $related->type)) }}
                            </div>
                            <h6 class="related-title">{{ $related->title }}</h6>
                            <p class="related-org">{{ $related->organization }}</p>
                            <a href="{{ route('opportunities.show', [$related->uuid, $related->slug]) }}"
                                class="related-link">
                                View Details <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Opportunity Detail Styles */

    /* Breadcrumb */
    .breadcrumb {
        background: transparent;
        padding: 0;
    }

    .breadcrumb-item a {
        color: #10b981;
        transition: color 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: #047857;
    }

    .breadcrumb-item.active {
        color: #64748b;
    }

    /* Premium Header Card */
    .premium-header-card {
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
        border-radius: 32px;
        padding: 2rem;
        position: relative;
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 60px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
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

    .featured-badge {
        position: absolute;
        top: 2rem;
        right: 2rem;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 60px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
    }

    .opportunity-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1e2937;
        margin: 1rem 0 1rem 0;
        line-height: 1.3;
    }

    .opportunity-meta {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        font-size: 0.95rem;
    }

    .meta-item i {
        color: #10b981;
    }

    .meta-item.remote {
        background: #d1fae5;
        padding: 0.25rem 0.75rem;
        border-radius: 60px;
        color: #047857;
    }

    /* Premium Content Card */
    .premium-content-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .premium-content-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .premium-content-card .card-header i {
        color: #10b981;
        font-size: 1.2rem;
    }

    .premium-content-card .card-body {
        padding: 1.5rem;
    }

    .opportunity-description {
        color: #475569;
        line-height: 1.8;
    }

    .opportunity-description p {
        margin-bottom: 1rem;
    }

    .opportunity-description ul,
    .opportunity-description ol {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }

    .opportunity-description li {
        margin: 0.5rem 0;
    }

    .requirements-list,
    .benefits-list {
        color: #475569;
        line-height: 1.7;
    }

    /* Apply Button */
    .apply-section {
        text-align: center;
        margin-top: 2rem;
    }

    .btn-apply {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 1rem 2.5rem;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 700;
        font-size: 1.1rem;
        text-decoration: none;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        cursor: pointer;
    }

    .btn-apply:hover {
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

    .btn-apply:hover .btn-glow {
        opacity: 1;
    }

    .apply-note {
        margin-top: 1rem;
        font-size: 0.85rem;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Share Section */
    .share-section {
        padding: 1rem;
        background: #ffffff;
        border-radius: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .share-label {
        color: #ffffff;
        font-size: 0.9rem;
    }

    .share-buttons {
        display: flex;
        gap: 0.75rem;
    }

    .share-btn {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
    }

    .share-btn.facebook {
        background: #1877F2;
        color: ffffff;
    }

    .share-btn.twitter {
        background: #000000;
        color: ffffff;
    }

    .share-btn.linkedin {
        background: #0A66C2;
        color: ffffff;

    }

    .share-btn.whatsapp {
        background: #25D366;
        color: ffffff;
    }

    .share-btn.copy {
        background: #64748b;
        color: ffffff;
    }

    .share-btn:hover {
        transform: translateY(-3px);
        filter: brightness(1.1);
    }

    /* Sidebar Cards */
    .sidebar-card {
        background: white;
        border-radius: 24px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .sidebar-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .sidebar-card .card-header i {
        color: #10b981;
    }

    .sidebar-card .card-body {
        padding: 1.25rem;
    }

    /* Detail List */
    .detail-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        gap: 1rem;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .detail-item:hover {
        transform: translateX(5px);
        background: white;
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.1);
    }

    .detail-icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
    }

    .detail-icon.salary {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .detail-icon.funding {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .detail-icon.deadline {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .detail-icon.deadline.expired {
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
    }

    .detail-icon.duration {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .detail-icon.start {
        background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
    }

    .detail-content {
        flex: 1;
    }

    .detail-label {
        display: block;
        font-size: 0.7rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        display: block;
        font-weight: 600;
        color: #1e2937;
        font-size: 0.95rem;
    }

    .detail-value.expired {
        color: #ef4444;
    }

    .days-left {
        font-size: 0.8rem;
        color: #10b981;
        font-weight: normal;
    }

    .expired-badge {
        display: inline-block;
        background: #fee2e2;
        color: #b91c1c;
        padding: 0.25rem 0.5rem;
        border-radius: 40px;
        font-size: 0.7rem;
        margin-left: 0.5rem;
        font-weight: normal;
    }

    /* Organization Info */
    .org-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e2937;
        margin-bottom: 0.5rem;
    }

    .org-website {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        color: #10b981;
        text-decoration: none;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    .org-website:hover {
        text-decoration: underline;
    }

    .org-description {
        color: #64748b;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-top: 0.5rem;
    }

    /* Tags */
    .tags-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .tag {
        background: #f1f5f9;
        color: #475569;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }

    .tag:hover {
        background: #10b981;
        color: white;
    }

    /* Similar List */
    .similar-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .similar-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .similar-item:hover {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(4, 120, 87, 0.05) 100%);
        transform: translateX(5px);
    }

    .similar-title {
        font-weight: 600;
        color: #1e2937;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }

    .similar-org {
        font-size: 0.75rem;
        color: #64748b;
    }

    .similar-item i {
        color: #10b981;
    }

    /* Related Section */
    .related-section {
        padding: 2rem 0;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .related-card {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
    }

    .related-card:hover {
        transform: translateY(-5px);
        border-color: #10b981;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.1);
    }

    .related-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .related-title {
        font-weight: 700;
        color: #1e2937;
        margin-bottom: 0.5rem;
    }

    .related-org {
        color: #64748b;
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }

    .related-link {
        color: #10b981;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        transition: gap 0.3s ease;
    }

    .related-link:hover {
        gap: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .opportunity-title {
            font-size: 1.8rem;
        }

        .related-grid {
            grid-template-columns: 1fr;
        }

        .share-section {
            flex-direction: column;
            border-radius: 28px;
        }
    }

    @media (max-width: 768px) {
        .premium-header-card {
            padding: 1.5rem;
        }

        .opportunity-title {
            font-size: 1.5rem;
        }

        .featured-badge {
            position: static;
            margin-top: 1rem;
            width: fit-content;
        }

        .opportunity-meta {
            gap: 1rem;
        }
    }
</style>

<script>
    function copyLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            const btn = document.querySelector('.share-btn.copy');
            const originalIcon = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg"></i>';
            setTimeout(() => {
                btn.innerHTML = originalIcon;
            }, 2000);
        });
    }
</script>

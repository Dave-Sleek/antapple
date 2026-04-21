@props(['job'])

@if (isset($job))
    @section('meta')
        @php
            $jobUrl = route('jobs.show', [$job->uuid, $job->slug]);
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
@endif


<div class="card border-0 overflow-hidden rounded-4 position-relative">
    {{-- Gradient Background --}}
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-success opacity-5"></div>

    {{-- Featured Ribbon --}}
    @if ($job->is_featured)
        <div class="position-absolute top-0 end-0">
            <div class="bg-success text-white px-3 py-2 rounded-bottom-start shadow-sm">
                <i class="bi bi-star-fill me-1"></i> Featured
            </div>
        </div>
    @endif

    <div class="card-body p-4 position-relative z-1 d-flex flex-column">
        {{-- Company & Title --}}
        <div class="mb-3">
            <div class="d-flex align-items-start gap-2">

                {{-- Logo --}}
                @if ($job->company_logo)
                    {{-- <img src="{{ asset($job->company_logo) }}" alt="{{ $job->company_name }}"
                        class="rounded-circle border border-success border-2"
                        style="width: 40px; height: 40px; object-fit: cover;"> --}}
                    <img src="{{ asset('storage/' . $job->company_logo) }}" alt="{{ $job->company_name }}"
                        class="rounded-circle border border-success border-2"
                        style="width: 40px; height: 40px; object-fit: cover;">
                @endif

                {{-- Name + Time --}}
                <div class="d-flex flex-column lh-sm">

                    <div class="d-flex align-items-center gap-1">

                        <h6 class="text-success fw-bold mb-0">
                            {{ $job->company_name }}

                            {{-- <a href="{{ route('employer.company.page', $job->user_id) }}" class="text-primary">
                                {{ $job->user->company_name ?? $job->user->name }}
                            </a> --}}
                        </h6>

                        {{-- ✅ Verified Tick --}}
                        @if ($job->is_verified)
                            <i class="bi bi-patch-check-fill text-primary" title="Verified Company"
                                style="font-size: 14px;"></i>
                        @endif

                    </div>

                    <small class="text-muted" style="font-size: 12px;">
                        <i class="bi bi-clock me-1"></i>
                        {{ $job->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>

            {{-- Job Title --}}
            <h5 class="fw-bold text-dark mt-2 mb-2">
                {{ $job->title }}
            </h5>
        </div>


        @php
            $jobUrl = route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]);
            $shareText = $job->title . ' at ' . $job->company_name;
        @endphp

        {{-- Location Badge --}}
        {{-- Meta Badges --}}
        <div class="mb-3 d-flex flex-wrap gap-2">

            @php
                $colors = [
                    'tech' => 'primary',
                    'health' => 'success',
                    'ngo' => 'warning',
                    'finance' => 'danger',
                ];

                $color = $colors[strtolower($job->category->name)] ?? 'dark';
            @endphp

            {{-- Location --}}
            <span class="badge bg-light text-dark border rounded-pill px-3 py-2 shadow-sm">
                <i class="bi bi-geo-alt-fill text-success me-1"></i>
                {{ $job->location }}
            </span>

            {{-- Remote --}}
            @if ($job->is_remote)
                <span class="badge bg-info text-white rounded-pill px-3 py-2 shadow-sm">
                    <i class="bi bi-wifi me-1"></i>
                    Remote
                </span>
            @endif

            {{-- @if ($job->is_remote)
                <span class="badge bg-info">Remote</span>
            @endif --}}


            {{-- Category --}}
            @if ($job->category)
                <span
                    class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} border border-{{ $color }} rounded-pill px-3 py-2">
                    <i class="bi bi-tag-fill me-1"></i>
                    {{ $job->category->name }}
                </span>
            @endif

            {{-- Job Type --}}
            <span
                class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3 py-2 shadow-sm">
                <i class="bi bi-briefcase-fill me-1"></i>
                {{ ucfirst($job->job_type) }}
            </span>

        </div>


        {{-- Description --}}
        {{-- Card description — always show truncated --}}
        @php
            $shortDesc = html_entity_decode(strip_tags($job->short_description), ENT_QUOTES, 'UTF-8');
            $truncated = Str::limit($shortDesc, 300);
            $isTruncated = strlen($shortDesc) > 300;
        @endphp

        <div class="job-description">
            <p class="text-muted small mb-0">{{ $truncated }}</p>
            @if ($isTruncated)
                <button class="accordion-toggle" data-bs-toggle="modal" data-bs-target="#jobModal{{ $job->id }}">
                    Read more <span class="accordion-icon">▾</span>
                </button>
            @endif
        </div>

        <style>
            .accordion-toggle {
                background: none;
                border: none;
                padding: 6px 0;
                color: #0d6efd;
                font-size: 0.875rem;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 4px;
                -webkit-tap-highlight-color: transparent;
            }

            .accordion-icon {
                font-size: 1rem;
                line-height: 1;
            }
        </style>


        {{-- <p class="text-muted small mb-4 flex-grow-1">
            {{ Str::limit(html_entity_decode(strip_tags($job->short_description)), 300) }}
        </p> --}}


        {{-- CTA & Salary --}}
        <div class="d-flex justify-content-between align-items-center mt-auto">
            @if ($job->salary_range)
                <div class="d-flex align-items-center gap-1">
                    {{-- <span class="text-success fs-5">&#8358;</span> --}}
                    <span class="fw-bold text-success">{{ $job->salary_range }}</span>
                </div>
            @endif

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
        </div>


        {{-- Share Buttons --}}
        {{-- Share Row --}}
        <div class="share-row mt-3">

            {{-- <span class="share-label small text-muted me-2">
                <i class="bi bi-share me-1"></i> Share
            </span> --}}
            {{-- Native share (mobile first) --}}
            <button class="share-circle share-native"
                onclick="nativeShare('{{ $shareText }}','{{ $jobUrl }}')">
                <i class="bi bi-upload"></i>
            </button>

            <div class="share-icons">

                {{-- WhatsApp --}}
                <a href="https://wa.me/?text={{ urlencode($shareText . ' - Apply here: ' . $jobUrl) }}" target="_blank"
                    class="share-btn whatsapp">
                    <i class="bi bi-whatsapp"></i>
                </a>

                {{-- Facebook --}}
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($jobUrl) }}" target="_blank"
                    class="share-btn facebook">
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
                <button onclick="copyLink('{{ $jobUrl }}', this)" class="share-btn copy">
                    <i class="bi bi-link-45deg"></i>
                </button>

            </div>
        </div>

    </div>
</div>

{{-- Modal --}}
@if ($isTruncated)
    <div class="modal fade" id="jobModal{{ $job->id }}" tabindex="-1"
        aria-labelledby="jobModalLabel{{ $job->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded-4 border-0 shadow">

                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold" id="jobModalLabel{{ $job->id }}">
                            {{-- Logo --}}
                            @if ($job->company_logo)
                                <img src="{{ asset($job->company_logo) }}" alt="{{ $job->company_name }}"
                                    class="rounded-circle border border-success border-2"
                                    style="width: 40px; height: 40px; object-fit: cover;">
                            @endif
                            {{ $job->title }}
                        </h5>
                        <p class="text-success small mb-0">{{ $job->company_name }}
                            {{-- {-- ✅ Verified Tick --} --}}
                            @if ($job->is_verified)
                                <i class="bi bi-patch-check-fill text-primary" title="Verified Company"
                                    style="font-size: 14px;"></i>
                            @endif
                        </p>
                        <small class="text-muted" style="font-size: 12px;">
                            <i class="bi bi-clock me-1"></i>
                            {{ $job->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body pt-2">
                    <div class="text-muted small">
                        {!! $job->short_description !!}
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    @if (!$job->isExpired())
                        <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}"
                            class="btn btn-success rounded-pill px-4 w-100">
                            View Full Job <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @else
                        <span class="badge bg-danger text-white rounded-pill px-3 py-2 w-100 text-center">
                            <i class="bi bi-x-circle me-1"></i> Expired
                        </span>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.modal').forEach(modal => {
            // Move every modal to body level so no parent stacking context can trap it
            document.body.appendChild(modal);
        });
    });
</script>

<script>
    function copyLink(url, btn) {
        navigator.clipboard.writeText(url);

        btn.innerHTML = '<i class="bi bi-check-lg"></i>';
        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-link-45deg"></i>';
        }, 1200);
    }
</script>

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
    /* Soft white gradient (very subtle) */
    .bg-gradient-success {
        background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
    }

    /* Soft neutral border */
    .border-success-subtle {
        border-color: rgba(0, 0, 0, 0.06) !important;
    }

    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Main Card Style */
    .card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        transition: all 0.25s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    /* Premium Hover Effect */
    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border-color: rgba(0, 0, 0, 0.08);
    }
</style>

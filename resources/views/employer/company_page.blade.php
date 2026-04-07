@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Company Profile Card with Animation --}}
        <div class="card mb-5 shadow-lg rounded-4 border-0 overflow-hidden animate__animated animate__fadeInUp"
            style="background: linear-gradient(135deg, #10b981 0%, #047857 100%);">

            {{-- Decorative Elements --}}
            <div class="position-absolute"
                style="top: -50px; right: -50px; width: 200px; height: 200px;
                background: rgba(255,255,255,0.1); border-radius: 50%;">
            </div>
            <div class="position-absolute"
                style="bottom: -30px; left: -30px; width: 150px; height: 150px;
                background: rgba(255,255,255,0.1); border-radius: 50%;">
            </div>

            <div class="card-body p-5 position-relative" style="z-index: 2;">
                <div class="d-flex align-items-center gap-4 flex-wrap">

                    {{-- Company Logo with Hover Effect --}}
                    @if ($user->company_logo)
                        <div class="company-logo-wrapper animate__animated animate__zoomIn animate__delay-1s">
                            <img src="{{ $user->logo_url }}" alt="{{ $user->company_name ?? $user->name }}"
                                class="company-logo rounded-4 shadow-lg"
                                style="height:120px; width:120px; object-fit:cover; border:4px solid rgba(255,255,255,0.3);
                                        transition: transform 0.3s ease, box-shadow 0.3s ease;"
                                onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.3)';"
                                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
                        </div>
                    @else
                        <div class="company-logo-placeholder rounded-4 shadow-lg d-flex align-items-center justify-content-center"
                            style="height:120px; width:120px; background: linear-gradient(135deg, #10b981 0%, #047857 100%);
                                    border:4px solid rgba(255,255,255,0.3);">
                            <span class="text-white fw-bold" style="font-size: 3rem;">🏢</span>
                        </div>
                    @endif

                    {{-- Company Info with Animation --}}
                    <div class="company-info animate__animated animate__fadeInRight animate__delay-1s">
                        <h2 class="fw-bold text-white mb-2"
                            style="font-size: 2.2rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                            {{ $user->company_name ?? $user->name }}
                        </h2>

                        <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                            <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm">
                                <i class="bi bi-geo-alt-fill me-1 text-success"></i> {{ $user->location }}
                            </span>
                            @if ($jobs->count())
                                <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-briefcase-fill me-1"></i> {{ $jobs->count() }} Active Jobs
                                </span>
                            @endif
                        </div>

                        @if ($user->about_company)
                            <p class="text-white mb-0" style="max-width: 600px; opacity: 0.9; line-height: 1.6;">
                                <i class="bi bi-quote me-1"></i> {{ $user->about_company }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Title with Animation --}}
        <div class="d-flex align-items-center justify-content-between mb-4 animate__animated animate__fadeInUp">
            <div>
                <h4 class="fw-bold mb-1" style="color: #2d3748;">
                    <i class="bi bi-briefcase-fill me-2" style="color: #10b981;"></i>
                    Job Openings
                </h4>
                <div
                    style="width: 80px; height: 4px; background: linear-gradient(90deg, #10b981 0%, #047857 100%); border-radius: 2px;">
                </div>
            </div>

            {{-- Stats Counter with Animation --}}
            <div class="stats-badge animate__animated animate__pulse animate__infinite">
                <span class="badge bg-light text-dark px-4 py-2 rounded-pill shadow-sm">
                    <span class="fw-bold" style="color: #10b981;">{{ $jobs->count() }}</span> total positions
                </span>
            </div>
        </div>

        {{-- Jobs Grid with Staggered Animation --}}
        @if ($jobs->count())
            <div class="row g-4">
                @foreach ($jobs as $index => $job)
                    <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp"
                        style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="card job-card h-100 border-0 rounded-4 shadow-sm hover-lift">
                            <div class="card-body p-4">

                                {{-- Job Type Badge --}}
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge job-type-badge px-3 py-2 rounded-pill"
                                        style="background: linear-gradient(135deg, #10b981 0%, #047857 100%); color: white;">
                                        <i class="bi bi-clock me-1"></i> {{ ucfirst($job->job_type) }}
                                    </span>
                                    @if ($job->is_featured)
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                            <i class="bi bi-star-fill me-1"></i> Featured
                                        </span>
                                    @endif
                                </div>

                                {{-- Job Title --}}
                                <h5 class="fw-bold mb-2" style="color: #2d3748;">{{ $job->title }}</h5>

                                {{-- Company Name (if different) --}}
                                @if ($job->company_name && $job->company_name !== $user->company_name)
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-building me-1"></i> {{ $job->company_name }}
                                    </p>
                                @endif

                                {{-- Location and Meta --}}
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i> {{ $job->location }}
                                    </span>
                                    @if ($job->salary_range)
                                        <span class="text-success small fw-bold">
                                            <i class="bi bi-cash me-1"></i> {{ $job->salary_range }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Description Preview --}}
                                <p class="text-muted small mb-4" style="line-height: 1.5;">
                                    {{ Str::limit(strip_tags($job->short_description), 100) }}
                                </p>

                                {{-- View Job Button with Hover Effect --}}
                                <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => Str::slug($job->title)]) }}"
                                    class="btn btn-outline-success w-100 rounded-pill view-job-btn"
                                    style="border-color: #10b981; color: #10b981; transition: all 0.3s ease;">
                                    <span class="d-flex align-items-center justify-content-center gap-2">
                                        View Details
                                        <i class="bi bi-arrow-right"></i>
                                    </span>
                                </a>
                            </div>

                            {{-- Decorative corner --}}
                            <div class="position-absolute" style="bottom: 10px; right: 10px; opacity: 0.1;">
                                <i class="bi bi-briefcase" style="font-size: 3rem; color: #10b981;"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State with Animation --}}
            <div class="text-center py-5 animate__animated animate__fadeIn">
                <div class="empty-state-icon mb-4">
                    <i class="bi bi-briefcase" style="font-size: 5rem; color: #cbd5e0;"></i>
                </div>
                <h5 class="fw-bold text-muted mb-2">No Active Jobs</h5>
                <p class="text-muted mb-4">This company doesn't have any active job openings at the moment.</p>
                <a href="{{ route('jobs.index') }}" class="btn btn-success rounded-pill px-5 py-2 shadow-sm">
                    <i class="bi bi-search me-2"></i> Browse Other Jobs
                </a>
            </div>
        @endif

    </div>
@endsection


{{-- Add Animate.css for animations --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Custom Animations */
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.2) !important;
    }

    .job-card {
        position: relative;
        overflow: hidden;
        background: white;
        transition: all 0.3s ease;
    }

    .job-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #10b981 0%, #047857 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
        transform-origin: left;
    }

    .job-card:hover::before {
        transform: scaleX(1);
    }

    .job-type-badge {
        transition: all 0.3s ease;
    }

    .job-card:hover .job-type-badge {
        transform: scale(1.05);
    }

    .view-job-btn:hover {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-color: transparent !important;
        color: white !important;
        transform: translateX(5px);
    }

    .view-job-btn:hover i {
        animation: slideRight 0.5s ease infinite;
    }

    @keyframes slideRight {

        0%,
        100% {
            transform: translateX(0);
        }

        50% {
            transform: translateX(5px);
        }
    }

    .company-logo {
        transition: all 0.3s ease;
    }

    .stats-badge {
        animation-duration: 2s;
    }

    /* Loading animation for images */
    .company-logo,
    .company-logo-placeholder {
        transition: all 0.3s ease;
    }

    /* Gradient text for company name on hover */
    .company-info h2 {
        background: linear-gradient(135deg, #fff 0%, #e0e7ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>


<script>
    // Add intersection observer for scroll animations
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.job-card');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        cards.forEach(card => {
            observer.observe(card);
        });

        // Add counter animation for stats
        const statElement = document.querySelector('.stats-badge .fw-bold');
        if (statElement) {
            const count = parseInt(statElement.innerText);
            let current = 0;
            const increment = Math.ceil(count / 50);

            const timer = setInterval(() => {
                current += increment;
                if (current > count) {
                    current = count;
                    clearInterval(timer);
                }
                statElement.innerText = current;
            }, 30);
        }
    });
</script>

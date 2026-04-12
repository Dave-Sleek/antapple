<div class="opportunity-card h-100">
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
                <i class="bi bi-star"></i> {{ ucfirst(str_replace('_', ' ', $item->type)) }}
        @endswitch
    </div>

    {{-- Image --}}
    @if ($item->image)
        <img src="{{ asset(str_replace('storage/', 'storage/', $item->image)) }}" class="img-fluid rounded mb-2"
            style="height: 180px; width: 100%; object-fit: cover;">
    @endif

    {{-- Featured Badge (optional) --}}
    @if ($item->is_featured ?? false)
        <div class="featured-badge">
            <i class="bi bi-star-fill"></i>
            Featured
        </div>
    @endif

    <div class="card-body">
        {{-- Title --}}
        <h3 class="opportunity-title">{{ $item->title }}</h3>

        {{-- Organization & Location --}}
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
            {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 120) }}
        </p>

        {{-- Details Row --}}
        <div class="details-row">
            @if ($item->salary_range)
                <div class="detail-item">
                    <i class="bi bi-cash"></i>
                    <span>{{ $item->salary_range }}</span>
                </div>
            @endif

            @if ($item->funding_type)
                <div class="detail-item">
                    <i class="bi bi-gift"></i>
                    <span>{{ $item->funding_type }}</span>
                </div>
            @endif

            @if ($item->deadline)
                <div class="deadline {{ \Carbon\Carbon::parse($item->deadline)->isPast() ? 'expired' : '' }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>Deadline: {{ \Carbon\Carbon::parse($item->deadline)->format('M d, Y') }}</span>
                    @if (!\Carbon\Carbon::parse($item->deadline)->isPast())
                        <span class="days-left">
                            ({{ \Carbon\Carbon::now()->diffInDays($item->deadline) }} days left)
                        </span>
                    @endif
                </div>
            @endif
        </div>

        {{-- View Details Button --}}
        <a href="{{ route('opportunities.show', [$item->uuid, $item->slug]) }}" class="btn-view">
            <span>View Details</span>
            <i class="bi bi-arrow-right"></i>
            <div class="btn-glow"></div>
        </a>
    </div>

    {{-- Hover Pattern --}}
    <div class="card-pattern"></div>
</div>

<style>
    /* Premium Opportunity Card Styles */
    .opportunity-card {
        background: white;
        border-radius: 28px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        height: 100%;
        display: flex;
        flex-direction: column;
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
        backdrop-filter: blur(4px);
    }

    .type-internship {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #047857;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .type-scholarship {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #92400e;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .type-grant {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .type-graduate_program {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #3730a3;
        border: 1px solid rgba(79, 70, 229, 0.2);
    }

    /* Featured Badge */
    .featured-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 0.7rem;
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
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .opportunity-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e2937;
        margin: 2rem 0 0.75rem 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
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
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Details Row */
    .details-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 0.75rem 0;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.85rem;
        color: #475569;
        background: #f8fafc;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
    }

    .detail-item i {
        color: #10b981;
        font-size: 0.75rem;
    }

    .deadline {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.85rem;
        color: #64748b;
        background: #f8fafc;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
    }

    .deadline i {
        color: #10b981;
    }

    .deadline.expired {
        color: #ef4444;
        background: #fef2f2;
    }

    .deadline.expired i {
        color: #ef4444;
    }

    .days-left {
        color: #10b981;
        font-weight: 500;
        margin-left: 0.25rem;
    }

    .deadline.expired .days-left {
        color: #ef4444;
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
        cursor: pointer;
        margin-top: auto;
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
        transition: all 0.3s ease;
    }

    .opportunity-card:hover .card-pattern {
        transform: scale(1.2);
        opacity: 0.8;
    }

    /* Dark Mode Support */
    @media (prefers-color-scheme: dark) {
        .opportunity-card {
            background: #1e2937;
            border-color: rgba(16, 185, 129, 0.2);
        }

        .opportunity-title {
            color: #f1f5f9;
        }

        .meta-item {
            color: #94a3b8;
        }

        .opportunity-description {
            color: #94a3b8;
        }

        .detail-item {
            background: #0f172a;
            color: #cbd5e1;
        }

        .deadline {
            background: #0f172a;
        }
    }
</style>

{{-- Bootstrap Icons (if not already included) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

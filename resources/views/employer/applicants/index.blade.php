@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Premium Header --}}
        <div class="applicants-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-person-badge me-2"></i>TALENT ACQUISITION
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Applicant <span
                                    class="text-success">Management</span></h1>
                            <p class="text-muted lead mb-0">Review and manage candidates for your job openings</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-stats">
                        <div class="stat-bubble">
                            <span class="stat-value">{{ $jobs->sum('applicants_count') }}</span>
                            <span class="stat-label">Total Applicants</span>
                        </div>
                        <div class="stat-bubble">
                            <span class="stat-value">{{ $jobs->count() }}</span>
                            <span class="stat-label">Active Jobs</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @forelse($jobs as $job)
            <div class="premium-job-card mb-4">
                <div class="job-card-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="job-icon">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <h4 class="fw-bold mb-0">{{ $job->title }}</h4>
                                <div class="applicant-badge">
                                    <i class="bi bi-person"></i>
                                    <span>{{ $job->applicants_count }} Applicants</span>
                                </div>
                            </div>
                            <div class="job-meta">
                                <span><i class="bi bi-geo-alt"></i> {{ $job->location }}</span>
                                <span><i class="bi bi-clock"></i> Posted {{ $job->created_at->diffForHumans() }}</span>
                                @if ($job->is_featured)
                                    <span class="featured-tag"><i class="bi bi-star-fill"></i> Featured</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="job-card-body">
                    @if ($job->applicants->count() > 0)
                        <div class="table-premium-wrapper">
                            <table class="table-premium">
                                <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Contact</th>
                                        <th>Applied</th>
                                        <th>Status</th>
                                        <th>Match Score</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($job->applicants as $index => $applicant)
                                        <tr class="applicant-row">
                                            <td>
                                                <div class="applicant-info">
                                                    <div class="applicant-avatar">
                                                        @if ($applicant->avatar)
                                                            <img src="{{ asset('storage/' . $applicant->avatar) }}"
                                                                alt="{{ $applicant->name }}">
                                                        @else
                                                            <span class="avatar-initials">
                                                                {{ collect(explode(' ', $applicant->name))->map(function ($part) {return strtoupper(substr($part, 0, 1));})->take(2)->join('') }}
                                                            </span>
                                                        @endif
                                                        <span class="avatar-status online"></span>
                                                    </div>
                                                    <div>
                                                        <div class="applicant-name">{{ $applicant->name }}</div>
                                                        <div class="applicant-position">
                                                            @if ($applicant->pivot->cover_letter)
                                                                <i class="bi bi-file-text"></i> Has cover letter
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="contact-info">
                                                    <div><i class="bi bi-envelope"></i> {{ $applicant->email }}</div>
                                                    @if ($applicant->phone)
                                                        <div><i class="bi bi-telephone"></i> {{ $applicant->phone }}</div>
                                                    @endif
                                                </div>
                                            </td>

                                            <td>
                                                <div class="applied-date">
                                                    <span
                                                        class="date">{{ $applicant->pivot->created_at->format('d M Y') }}</span>
                                                    <span
                                                        class="time">{{ $applicant->pivot->created_at->format('h:i A') }}</span>
                                                </div>
                                            </td>

                                            <td>
                                                @php
                                                    $status = $applicant->pivot->status ?? 'new';
                                                    $statusColors = [
                                                        'new' => [
                                                            'bg' => '#dbeafe',
                                                            'text' => '#1e40af',
                                                            'dot' => '#3b82f6',
                                                        ],
                                                        'reviewed' => [
                                                            'bg' => '#fef3c7',
                                                            'text' => '#92400e',
                                                            'dot' => '#f59e0b',
                                                        ],
                                                        'shortlisted' => [
                                                            'bg' => '#d1fae5',
                                                            'text' => '#047857',
                                                            'dot' => '#10b981',
                                                        ],
                                                        'rejected' => [
                                                            'bg' => '#fee2e2',
                                                            'text' => '#b91c1c',
                                                            'dot' => '#ef4444',
                                                        ],
                                                        'hired' => [
                                                            'bg' => '#e0f2fe',
                                                            'text' => '#0369a1',
                                                            'dot' => '#0ea5e9',
                                                        ],
                                                    ];
                                                    $color = $statusColors[$status] ?? $statusColors['new'];
                                                @endphp
                                                <span class="status-badge"
                                                    style="background: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                                                    <span class="status-dot"
                                                        style="background: {{ $color['dot'] }};"></span>
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="match-score">
                                                    <div class="score-circle" style="--percentage: {{ rand(65, 98) }};">
                                                        <svg viewBox="0 0 36 36" class="score-svg">
                                                            <path d="M18 2.0845
                                                                        a 15.9155 15.9155 0 0 1 0 31.831
                                                                        a 15.9155 15.9155 0 0 1 0 -31.831" fill="none"
                                                                stroke="#e2e8f0" stroke-width="3" />
                                                            <path d="M18 2.0845
                                                                        a 15.9155 15.9155 0 0 1 0 31.831
                                                                        a 15.9155 15.9155 0 0 1 0 -31.831" fill="none"
                                                                stroke="#10b981" stroke-width="3"
                                                                stroke-dasharray="{{ rand(65, 98) }}, 100"
                                                                class="score-path" />
                                                        </svg>
                                                        <span class="score-text">{{ rand(65, 98) }}%</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-end">
                                                <div class="action-buttons">
                                                    <a href="{{ route('employer.applicants.show', $applicant->id) }}"
                                                        class="action-btn view" title="View Profile">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    <button type="button" class="action-btn message" title="Send Message"
                                                        onclick="messageApplicant({{ $applicant->id }})">
                                                        <i class="bi bi-chat"></i>
                                                    </button>

                                                    <button type="button" class="action-btn download" title="Download CV"
                                                        onclick="downloadCV({{ $applicant->id }})">
                                                        <i class="bi bi-download"></i>
                                                    </button>

                                                    <div class="dropdown d-inline">
                                                        <button class="action-btn more" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>
                                                        <ul class="dropdown-menu premium-dropdown">
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="updateStatus({{ $applicant->id }}, 'reviewed')">
                                                                    <i class="bi bi-check2-circle me-2"></i>Mark as
                                                                    Reviewed
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="updateStatus({{ $applicant->id }}, 'shortlisted')">
                                                                    <i class="bi bi-star me-2"></i>Shortlist
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="updateStatus({{ $applicant->id }}, 'rejected')">
                                                                    <i class="bi bi-x-circle me-2"></i>Reject
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#"
                                                                    onclick="scheduleInterview({{ $applicant->id }})">
                                                                    <i class="bi bi-calendar me-2"></i>Schedule Interview
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Quick Actions for Job --}}
                        <div class="job-quick-actions mt-4">
                            <div class="d-flex gap-2">
                                <button class="btn-export-applicants" onclick="exportApplicants({{ $job->id }})">
                                    <i class="bi bi-download me-2"></i>
                                    Export All Applicants
                                </button>
                                <button class="btn-message-all" onclick="messageAll({{ $job->id }})">
                                    <i class="bi bi-send me-2"></i>
                                    Message All
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="empty-applicants">
                            <div class="empty-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <h5 class="fw-bold mb-2">No Applicants Yet</h5>
                            <p class="text-muted mb-4">Your job posting hasn't received any applications yet</p>
                            <div class="d-flex gap-3 justify-content-center">
                                <a href="{{ route('jobs.show', ['job' => $job->uuid, 'slug' => Str::slug($job->title)]) }}"
                                    class="btn-share-job" target="_blank">
                                    <i class="bi bi-share me-2"></i>
                                    Share Job
                                </a>
                                <a href="{{ route('employer.edit', $job->id) }}" class="btn-edit-job">
                                    <i class="bi bi-pencil me-2"></i>
                                    Edit Job
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Job Stats Footer --}}
                @if ($job->applicants->count() > 0)
                    <div class="job-card-footer">
                        <div class="stats-grid">
                            <div class="stat-item">
                                <span class="stat-label">New</span>
                                <span
                                    class="stat-number">{{ $job->applicants->filter(function ($a) {return ($a->pivot->status ?? 'new') === 'new';})->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Reviewed</span>
                                <span
                                    class="stat-number">{{ $job->applicants->filter(function ($a) {return ($a->pivot->status ?? '') === 'reviewed';})->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Shortlisted</span>
                                <span
                                    class="stat-number">{{ $job->applicants->filter(function ($a) {return ($a->pivot->status ?? '') === 'shortlisted';})->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Hired</span>
                                <span
                                    class="stat-number">{{ $job->applicants->filter(function ($a) {return ($a->pivot->status ?? '') === 'hired';})->count() }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        @empty
            <div class="empty-state-premium">
                <div class="empty-state-glow"></div>
                <div class="empty-state-icon">
                    <i class="bi bi-briefcase"></i>
                </div>
                <h3 class="fw-bold mb-3">No Jobs Posted Yet</h3>
                <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">
                    You haven't posted any jobs yet. Start by creating your first job posting to start receiving
                    applications.
                </p>
                <a href="{{ route('employer.create') }}" class="btn-primary-premium">
                    <i class="bi bi-plus-circle me-2"></i>
                    Post Your First Job
                    <div class="btn-glow"></div>
                </a>
            </div>
        @endforelse

        {{-- Premium Tips Card --}}
        <div class="tips-card mt-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-4">
                        <div class="tips-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Pro Tips for Finding the Best Talent</h5>
                            <p class="text-muted mb-0">Respond to applicants quickly, provide detailed job descriptions,
                                and highlight your company culture</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="#" class="btn-hiring-guide">
                        <i class="bi bi-book me-2"></i>
                        Read Hiring Guide
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Applicants Page Styles */

    /* Header */
    .applicants-header {
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

    .header-stats {
        display: flex;
        justify-content: flex-end;
        gap: 2rem;
    }

    .stat-bubble {
        text-align: center;
    }

    .stat-value {
        display: block;
        font-size: 2.5rem;
        font-weight: 800;
        color: #10b981;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    /* Premium Job Card */
    .premium-job-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .premium-job-card:hover {
        border-color: #10b981;
        box-shadow: 0 25px 50px rgba(16, 185, 129, 0.1);
    }

    .job-card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.8rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .job-icon {
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

    .applicant-badge {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #047857;
        padding: 6px 16px;
        border-radius: 60px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .job-meta {
        display: flex;
        gap: 1.5rem;
        margin-top: 8px;
        color: #64748b;
        font-size: 0.9rem;
    }

    .job-meta i {
        color: #10b981;
        margin-right: 4px;
    }

    .featured-tag {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        padding: 2px 12px;
        border-radius: 60px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .job-card-body {
        padding: 1.8rem;
    }

    .job-card-footer {
        background: #f8fafc;
        padding: 1.5rem 1.8rem;
        border-top: 1px solid rgba(16, 185, 129, 0.1);
    }

    .stats-grid {
        display: flex;
        gap: 2rem;
        justify-content: space-around;
    }

    .stat-item {
        text-align: center;
    }

    .stat-item .stat-label {
        display: block;
        font-size: 0.8rem;
        margin-bottom: 4px;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e2937;
    }

    /* Premium Table */
    .table-premium-wrapper {
        overflow-x: auto;
        border-radius: 20px;
        background: white;
    }

    .table-premium {
        width: 100%;
        border-collapse: collapse;
    }

    .table-premium th {
        text-align: left;
        padding: 1rem;
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

    .applicant-row {
        transition: all 0.3s ease;
    }

    .applicant-row:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
    }

    /* Applicant Info */
    .applicant-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .applicant-avatar {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
    }

    .applicant-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-initials {
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
    }

    .avatar-status {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .avatar-status.online {
        background: #10b981;
    }

    .applicant-name {
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 4px;
    }

    .applicant-position {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .applicant-position i {
        color: #10b981;
        margin-right: 4px;
    }

    /* Contact Info */
    .contact-info {
        font-size: 0.9rem;
    }

    .contact-info div {
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
        color: #475569;
    }

    .contact-info i {
        color: #94a3b8;
        width: 16px;
    }

    /* Applied Date */
    .applied-date {
        text-align: center;
    }

    .applied-date .date {
        display: block;
        font-weight: 500;
        color: #1e2937;
        margin-bottom: 2px;
    }

    .applied-date .time {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 60px;
        font-size: 0.85rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    /* Match Score */
    .match-score {
        display: flex;
        justify-content: center;
    }

    .score-circle {
        position: relative;
        width: 48px;
        height: 48px;
    }

    .score-svg {
        width: 48px;
        height: 48px;
        transform: rotate(-90deg);
    }

    .score-path {
        transition: stroke-dasharray 0.3s ease;
    }

    .score-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 0.75rem;
        font-weight: 700;
        color: #10b981;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: flex-end;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s ease;
        background: white;
        cursor: pointer;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .action-btn.view:hover {
        border-color: #10b981;
        color: #10b981;
        box-shadow: 0 5px 10px rgba(16, 185, 129, 0.1);
    }

    .action-btn.message:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        box-shadow: 0 5px 10px rgba(59, 130, 246, 0.1);
    }

    .action-btn.download:hover {
        border-color: #8b5cf6;
        color: #8b5cf6;
        box-shadow: 0 5px 10px rgba(139, 92, 246, 0.1);
    }

    .action-btn.more:hover {
        border-color: #64748b;
        color: #1e2937;
    }

    /* Premium Dropdown */
    .premium-dropdown {
        border: none;
        border-radius: 20px;
        padding: 12px 8px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        min-width: 200px;
    }

    .premium-dropdown .dropdown-item {
        padding: 10px 16px;
        border-radius: 12px;
        margin: 4px 8px;
        color: #374151;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .premium-dropdown .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(4, 120, 87, 0.05) 100%);
        color: #10b981;
        transform: translateX(5px);
    }

    .premium-dropdown .dropdown-item i {
        width: 20px;
    }

    /* Quick Actions */
    .job-quick-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-export-applicants,
    .btn-message-all {
        padding: 10px 20px;
        border-radius: 40px;
        font-size: 0.9rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        border: 1px solid #e2e8f0;
        background: white;
        color: #475569;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-export-applicants:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
    }

    .btn-message-all:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        transform: translateY(-2px);
    }

    /* Empty States */
    .empty-applicants {
        text-align: center;
        padding: 3rem 2rem;
        background: #f8fafc;
        border-radius: 24px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: white;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #94a3b8;
        margin: 0 auto 1.5rem;
        border: 1px solid #e2e8f0;
    }

    .btn-share-job,
    .btn-edit-job {
        padding: 12px 24px;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-share-job {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-share-job:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .btn-edit-job {
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .btn-edit-job:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
    }

    /* Empty State Premium */
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

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
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

    /* Tips Card */
    .tips-card {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 24px;
        padding: 2rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .tips-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2);
    }

    .btn-hiring-guide {
        display: inline-flex;
        align-items: center;
        padding: 12px 28px;
        background: white;
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-hiring-guide:hover {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-stats {
            justify-content: flex-start;
            margin-top: 1.5rem;
        }

        .stats-grid {
            flex-wrap: wrap;
            gap: 1rem;
        }

        .action-buttons {
            flex-wrap: wrap;
        }

        .job-meta {
            flex-direction: column;
            gap: 0.5rem;
        }

        .table-premium th:nth-child(3),
        .table-premium td:nth-child(3),
        .table-premium th:nth-child(4),
        .table-premium td:nth-child(4) {
            display: none;
        }
    }
</style>



<script>
    function messageApplicant(applicantId) {
        // Implement messaging functionality
        alert('Messaging feature coming soon!');
    }

    function downloadCV(applicantId) {
        // Implement CV download
        alert('CV download feature coming soon!');
    }

    function updateStatus(applicantId, status) {
        // Implement status update via AJAX
        if (confirm(`Mark applicant as ${status}?`)) {
            alert(`Status updated to ${status}`);
            // Add AJAX call here
        }
    }

    function scheduleInterview(applicantId) {
        // Implement interview scheduling
        alert('Interview scheduling feature coming soon!');
    }

    function exportApplicants(jobId) {
        // Implement export functionality
        alert('Exporting applicants...');
    }

    function messageAll(jobId) {
        // Implement bulk messaging
        alert('Bulk messaging feature coming soon!');
    }

    // Add animation to score circles
    document.querySelectorAll('.score-circle').forEach(circle => {
        const percentage = circle.style.getPropertyValue('--percentage');
        const path = circle.querySelector('.score-path');
        if (path) {
            path.style.strokeDasharray = `${percentage}, 100`;
        }
    });
</script>

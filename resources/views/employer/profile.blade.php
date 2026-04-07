@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Premium Header --}}
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                    <i class="bi bi-person-gear me-2"></i>PROFILE SETTINGS
                </span>
                <h1 class="display-5 fw-bold mb-2" style="color: #1e2937;">Company <span class="text-success">Profile</span>
                </h1>
                <p class="text-muted lead" style="max-width: 600px;">Manage your company information and account settings</p>
            </div>
            <div class="d-none d-md-block">
                <div class="profile-header-icon">
                    <i class="bi bi-building"></i>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-premium rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <div class="alert-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="flex-grow-1">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        {{-- Premium Progress Card --}}
        <div class="premium-progress-card mb-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="progress-icon-wrapper">
                            <i class="bi bi-pie-chart-fill"></i>
                        </div>
                        <div>
                            <span class="progress-label">Profile Completion</span>
                            <div class="d-flex align-items-center gap-3">
                                <h3 class="fw-bold mb-0 text-success">{{ $user->profileCompletion() }}%</h3>
                                <span class="progress-status">
                                    @if ($user->profileCompletion() < 50)
                                        <span class="badge bg-warning-subtle text-warning">Needs Improvement</span>
                                    @elseif($user->profileCompletion() < 80)
                                        <span class="badge bg-info-subtle text-info">Almost There</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success">Excellent</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="progress-wrapper">
                        <div class="progress premium-progress">
                            <div class="progress-bar" role="progressbar"
                                style="width: {{ $user->profileCompletion() }}%; background: linear-gradient(90deg, #10b981, #047857);"
                                aria-valuenow="{{ $user->profileCompletion() }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="progress-steps">
                            <span class="step completed">Basic Info</span>
                            <span class="step {{ $user->profileCompletion() > 30 ? 'completed' : '' }}">Company</span>
                            <span class="step {{ $user->profileCompletion() > 60 ? 'completed' : '' }}">Social</span>
                            <span class="step {{ $user->profileCompletion() > 80 ? 'completed' : '' }}">Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('employer.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                {{-- LEFT SIDE --}}
                <div class="col-lg-8">

                    {{-- Account Information Card --}}
                    <div class="premium-form-card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center gap-2">
                                <div class="header-icon">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Account Information</h5>
                            </div>
                            <p class="header-subtitle">Update your personal details and email address</p>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">Full Name</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-person"></i>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $user->name) }}" required
                                                placeholder="Enter your full name">
                                        </div>
                                        @error('name')
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">Email Address</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-envelope"></i>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email', $user->email) }}" required
                                                placeholder="Enter your email">
                                        </div>
                                        @error('email')
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Company Information Card --}}
                    <div class="premium-form-card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center gap-2">
                                <div class="header-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Company Information</h5>
                            </div>
                            <p class="header-subtitle">Tell job seekers about your company</p>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">Company Name</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-buildings"></i>
                                            <input type="text" name="company_name" class="form-control"
                                                value="{{ old('company_name', $user->company_name) }}"
                                                placeholder="Your company name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">Location</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-geo-alt"></i>
                                            <input type="text" name="location" class="form-control"
                                                value="{{ old('location', $user->location) }}"
                                                placeholder="City, Country">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">Phone</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-telephone"></i>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ old('phone', $user->phone) }}" placeholder="+234 XXX XXX XXXX">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">Website</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-globe"></i>
                                            <input type="url" name="website" class="form-control"
                                                value="{{ old('website', $user->website) }}"
                                                placeholder="https://example.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group premium-input">
                                        <label class="form-label">About Company</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-text-paragraph" style="top: 20px;"></i>
                                            <textarea name="about_company" rows="5" class="form-control"
                                                placeholder="Tell us about your company, mission, and values...">{{ old('about_company', $user->about_company) }}</textarea>
                                        </div>
                                        <span class="character-count">{{ strlen($user->about_company ?? '') }}/2000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Social Media Card --}}
                    <div class="premium-form-card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center gap-2">
                                <div class="header-icon">
                                    <i class="bi bi-share"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Social Media</h5>
                            </div>
                            <p class="header-subtitle">Connect your social profiles</p>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">LinkedIn</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-linkedin" style="color: #0A66C2;"></i>
                                            <input type="url" name="linkedin" class="form-control"
                                                value="{{ old('linkedin', $user->linkedin) }}"
                                                placeholder="https://linkedin.com/company/...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">Twitter</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-twitter-x" style="color: #000;"></i>
                                            <input type="url" name="twitter" class="form-control"
                                                value="{{ old('twitter', $user->twitter) }}"
                                                placeholder="https://twitter.com/...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">Facebook</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-facebook" style="color: #1877F2;"></i>
                                            <input type="url" name="facebook" class="form-control"
                                                value="{{ old('facebook', $user->facebook ?? '') }}"
                                                placeholder="https://facebook.com/...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">Instagram</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-instagram" style="color: #E4405F;"></i>
                                            <input type="url" name="instagram" class="form-control"
                                                value="{{ old('instagram', $user->instagram ?? '') }}"
                                                placeholder="https://instagram.com/...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Security Card --}}
                    <div class="premium-form-card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center gap-2">
                                <div class="header-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Security</h5>
                            </div>
                            <p class="header-subtitle">Update your password (leave blank to keep current)</p>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">New Password</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-key"></i>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Enter new password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group premium-input">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-wrapper">
                                            <i class="input-icon bi bi-key-fill"></i>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Confirm new password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="password-requirements mt-3">
                                <small class="text-muted">Password must be at least 8 characters long</small>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- RIGHT SIDE --}}
                <div class="col-lg-4">

                    {{-- Company Logo Card --}}
                    <div class="premium-logo-card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center gap-2">
                                <div class="header-icon">
                                    <i class="bi bi-image"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Company Logo</h5>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <div class="logo-preview-wrapper mb-4">
                                @if ($user->company_logo)
                                    <img src="{{ asset('storage/' . $user->company_logo) }}" class="logo-preview"
                                        alt="{{ $user->company_name }}" id="logoPreview">
                                @else
                                    <div class="logo-placeholder">
                                        <i class="bi bi-building"></i>
                                        <span>No logo uploaded</span>
                                    </div>
                                @endif
                                <div class="logo-edit-overlay" onclick="document.getElementById('company_logo').click();">
                                    <i class="bi bi-camera"></i>
                                    <span>Change Logo</span>
                                </div>
                            </div>

                            <div class="file-input-wrapper">
                                <input type="file" name="company_logo" id="company_logo" class="file-input"
                                    accept="image/*">
                                <label for="company_logo" class="file-label">
                                    <i class="bi bi-cloud-upload me-2"></i>
                                    Choose Image
                                </label>
                                <span class="file-info">Recommended: 400x400px, JPG or PNG</span>
                            </div>

                            {{-- Profile Stats --}}
                            <div class="profile-stats mt-4">
                                <div class="stat-item">
                                    <span class="stat-value">{{ $jobs_count ?? 0 }}</span>
                                    <span class="stat-label">Jobs Posted</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value">{{ $applicants_count ?? 0 }}</span>
                                    <span class="stat-label">Applicants</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value">{{ $profile_views ?? 0 }}</span>
                                    <span class="stat-label">Profile Views</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Save Button --}}
                    <button type="submit" class="btn-save-premium w-100">
                        <span class="btn-text">Save Changes</span>
                        <i class="bi bi-check2-circle"></i>
                        <div class="btn-glow"></div>
                    </button>

                    {{-- Preview Company Page --}}
                    <a href="{{ route('employer.company.page', auth()->user()->id) }}" target="_blank"
                        class="btn-preview w-100 mt-3">
                        <i class="bi bi-eye me-2"></i>
                        Preview Company Page
                    </a>

                    {{-- Danger Zone --}}
                    <div class="danger-zone mt-4">
                        <div class="danger-header">
                            <i class="bi bi-exclamation-triangle"></i>
                            <span>Danger Zone</span>
                        </div>
                        <button type="button" class="btn-delete-account" data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                            <i class="bi bi-trash3 me-2"></i>
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Delete Account Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content premium-modal">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Delete Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="modal-icon text-danger">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <p class="mt-3">Are you sure you want to delete your account?</p>
                        <p class="text-muted small">This action cannot be undone. All your jobs and data will be
                            permanently removed.</p>
                    </div>
                    <form method="POST" action="#">
                        @csrf
                        @method('DELETE')
                        <div class="form-group mb-3">
                            <input type="password" name="password" class="form-control"
                                placeholder="Enter your password to confirm" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 rounded-pill py-2">
                            Permanently Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Profile Styles */

    /* Header Icon */
    .profile-header-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    /* Premium Alert */
    .alert-premium {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: none;
        color: #047857;
        padding: 1.2rem;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.1);
    }

    .alert-icon {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
        color: #10b981;
    }

    /* Premium Progress Card */
    .premium-progress-card {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .premium-progress-card:hover {
        border-color: #10b981;
        box-shadow: 0 20px 50px rgba(16, 185, 129, 0.1);
    }

    .progress-icon-wrapper {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .progress-label {
        color: #6b7280;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }

    .progress-status .badge {
        padding: 8px 16px;
        font-weight: 500;
    }

    .premium-progress {
        height: 8px;
        border-radius: 100px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .premium-progress .progress-bar {
        border-radius: 100px;
        transition: width 1s ease;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-top: 12px;
    }

    .step {
        font-size: 0.8rem;
        color: #94a3b8;
        position: relative;
    }

    .step.completed {
        color: #10b981;
    }

    .step::before {
        content: '';
        position: absolute;
        top: -16px;
        left: 50%;
        transform: translateX(-50%);
        width: 8px;
        height: 8px;
        background: #e2e8f0;
        border-radius: 50%;
    }

    .step.completed::before {
        background: #10b981;
    }

    /* Premium Form Cards */
    .premium-form-card {
        background: white;
        border-radius: 24px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .premium-form-card:hover {
        border-color: #10b981;
        box-shadow: 0 15px 40px rgba(16, 185, 129, 0.05);
    }

    .premium-form-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .header-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .header-subtitle {
        color: #64748b;
        font-size: 0.9rem;
        margin-top: 4px;
        margin-left: 48px;
    }

    .premium-form-card .card-body {
        padding: 1.5rem;
    }

    /* Premium Inputs */
    .premium-input {
        margin-bottom: 0;
    }

    .premium-input .form-label {
        color: #475569;
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        z-index: 2;
        transition: color 0.3s ease;
    }

    .premium-input:focus-within .input-icon {
        color: #10b981;
    }

    .premium-input .form-control {
        height: 52px;
        padding-left: 48px;
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

    .premium-input .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        background: white;
    }

    .character-count {
        display: block;
        text-align: right;
        font-size: 0.8rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 4px;
        display: block;
    }

    /* Premium Logo Card */
    .premium-logo-card {
        background: white;
        border-radius: 24px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
    }

    .logo-preview-wrapper {
        position: relative;
        width: 100%;
        padding-top: 100%;
        border-radius: 20px;
        overflow: hidden;
        background: #f8fafc;
    }

    .logo-preview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 1rem;
    }

    .logo-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    .logo-placeholder i {
        font-size: 3rem;
        margin-bottom: 0.5rem;
    }

    .logo-edit-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        color: white;
        padding: 1rem;
        transform: translateY(100%);
        transition: transform 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .logo-preview-wrapper:hover .logo-edit-overlay {
        transform: translateY(0);
    }

    .file-input-wrapper {
        margin-top: 1.5rem;
    }

    .file-input {
        display: none;
    }

    .file-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 24px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border-radius: 60px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .file-label:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }

    .file-info {
        display: block;
        font-size: 0.8rem;
        color: #94a3b8;
        margin-top: 8px;
    }

    /* Profile Stats */
    .profile-stats {
        display: flex;
        justify-content: space-around;
        padding: 1.5rem 0;
        border-top: 1px solid #e2e8f0;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e2937;
    }

    .stat-label {
        color: #64748b;
        font-size: 0.8rem;
    }

    /* Save Button */
    .btn-save-premium {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        padding: 16px 32px;
        border-radius: 60px;
        font-weight: 600;
        font-size: 1rem;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }

    .btn-save-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-save-premium:active {
        transform: translateY(0);
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

    .btn-save-premium:hover .btn-glow {
        opacity: 1;
    }

    /* Preview Button */
    .btn-preview {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 16px 32px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-preview:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    /* Danger Zone */
    .danger-zone {
        border: 1px solid #fee2e2;
        border-radius: 20px;
        overflow: hidden;
    }

    .danger-header {
        background: #fef2f2;
        padding: 1rem;
        color: #ef4444;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid #fee2e2;
    }

    .btn-delete-account {
        width: 100%;
        padding: 1rem;
        background: white;
        border: none;
        color: #ef4444;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-delete-account:hover {
        background: #fef2f2;
    }

    /* Premium Modal */
    .premium-modal {
        border: none;
        border-radius: 32px;
        overflow: hidden;
    }

    .modal-icon {
        width: 60px;
        height: 60px;
        background: #fef2f2;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .progress-steps {
            display: none;
        }

        .premium-form-card .card-header {
            padding: 1rem;
        }

        .header-subtitle {
            margin-left: 0;
        }

        .profile-stats {
            flex-wrap: wrap;
            gap: 1rem;
        }

        .stat-item {
            width: 100%;
        }
    }
</style>


<script>
    // Image preview
    document.getElementById('company_logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('logoPreview');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    const wrapper = document.querySelector('.logo-preview-wrapper');
                    wrapper.innerHTML =
                        `<img src="${e.target.result}" class="logo-preview" id="logoPreview">`;
                }
            }
            reader.readAsDataURL(file);
        }
    });

    // Character count for about company
    const aboutTextarea = document.querySelector('textarea[name="about_company"]');
    if (aboutTextarea) {
        aboutTextarea.addEventListener('input', function() {
            const count = this.value.length;
            document.querySelector('.character-count').textContent = `${count}/2000`;
        });
    }
</script>

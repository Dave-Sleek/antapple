@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- Premium Header --}}
                <div class="d-flex align-items-center justify-content-between mb-5">
                    <div>
                        <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                            <i class="bi bi-plus-circle me-2"></i>NEW LISTING
                        </span>
                        <h1 class="display-5 fw-bold mb-2" style="color: #1e2937;">Post a <span class="text-success">New
                                Job</span></h1>
                        <p class="text-muted lead" style="max-width: 600px;">Create a compelling job posting to attract the
                            best talent</p>
                        @if (auth()->user()->hasActiveSubscription())
                            <span
                                class="badge bg-success-subtle text-success px-3 py-1 mt-2 d-inline-flex align-items-center gap-1">
                                <i class="bi bi-patch-check-fill"></i>
                                Premium Account
                            </span>
                            <small class="d-block mt-1 text-muted">Your premium features are active</small>
                            <small class="d-block mt-1 text-muted">After posting, you can mark this job as featured
                                from your dashboard.</small>
                        @else
                            <span
                                class="badge bg-gray-subtle text-gray px-3 py-1 mt-2 d-inline-flex align-items-center gap-1">
                                <i class="bi bi-x-circle-fill"></i>
                                Free Account
                        @endif
                    </div>
                    <a href="{{ route('employer.dashboard') }}" class="btn-back">
                        <i class="bi bi-arrow-left me-2"></i>
                        Back to Dashboard
                    </a>
                </div>

                {{-- Premium Form Card --}}
                <div class="premium-form-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">Job Details</h4>
                                <p class="header-subtitle">Fill in the information below to create your job posting</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert-premium-danger mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="alert-icon">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong class="d-block mb-2">Please fix the following errors:</strong>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('employer.store') }}" method="POST" enctype="multipart/form-data"
                            id="jobPostForm">
                            @csrf

                            {{-- Form Sections --}}
                            <div class="form-sections">

                                {{-- Section 1: Basic Information --}}
                                <div class="form-section">
                                    <div class="section-header">
                                        <div class="section-number">1</div>
                                        <div>
                                            <h5 class="fw-bold mb-1">Basic Information</h5>
                                            <p class="section-subtitle">Essential details about the position</p>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Job Title</label>
                                                <div class="input-wrapper">
                                                    <i class="input-icon bi bi-briefcase"></i>
                                                    <input type="text" name="title" class="form-control"
                                                        value="{{ old('title') }}" required
                                                        placeholder="e.g. Senior Laravel Developer">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Company Name</label>
                                                <div class="input-wrapper">
                                                    <i class="input-icon bi bi-building"></i>
                                                    <input type="text" name="company_name" class="form-control"
                                                        value="{{ old('company_name', auth()->user()->company_name) }}"
                                                        required placeholder="Your company name" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Location</label>
                                                <div class="input-wrapper">
                                                    <i class="input-icon bi bi-geo-alt"></i>
                                                    <input type="text" name="location" class="form-control"
                                                        value="{{ old('location', auth()->user()->location) }}" required
                                                        placeholder="e.g. Lagos, Nigeria" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Category</label>
                                                <div class="select-wrapper">
                                                    <i class="input-icon bi bi-grid"></i>
                                                    <select name="category_id" class="form-select" required>
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section 2: Job Details --}}
                                <div class="form-section">
                                    <div class="section-header">
                                        <div class="section-number">2</div>
                                        <div>
                                            <h5 class="fw-bold mb-1">Job Details</h5>
                                            <p class="section-subtitle">Specify the role requirements</p>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <div class="premium-input">
                                                <label class="form-label">Job Type</label>
                                                <div class="select-wrapper">
                                                    <i class="input-icon bi bi-clock"></i>
                                                    <select name="job_type" class="form-select" required>
                                                        <option value="">Select Type</option>
                                                        <option value="full-time">Full Time</option>
                                                        <option value="part-time">Part Time</option>
                                                        <option value="contract">Contract</option>
                                                        <option value="internship">Internship</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="premium-input">
                                                <label class="form-label">Experience Level</label>
                                                <div class="select-wrapper">
                                                    <i class="input-icon bi bi-bar-chart"></i>
                                                    <select name="experience_level" class="form-select" required>
                                                        <option value="">Select Level</option>
                                                        <option value="entry">Entry Level</option>
                                                        <option value="mid">Mid Level</option>
                                                        <option value="senior">Senior Level</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="premium-input">
                                                <label class="form-label">Salary Range</label>
                                                <div class="input-wrapper">
                                                    <i class="input-icon bi bi-cash"></i>
                                                    <input type="text" name="salary_range" class="form-control"
                                                        value="{{ old('salary_range') }}"
                                                        placeholder="e.g. ₦300k - ₦500k">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Official Apply URL</label>
                                                <div class="input-wrapper">
                                                    <i class="input-icon bi bi-link"></i>
                                                    <input type="url" name="apply_url" class="form-control"
                                                        value="{{ old('apply_url') }}" required
                                                        placeholder="https://company.com/apply">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Application Deadline</label>
                                                <div class="input-wrapper">
                                                    <i class="input-icon bi bi-calendar"></i>
                                                    <input type="date" name="deadline" class="form-control"
                                                        value="{{ old('deadline') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section 3: Company Information --}}
                                <div class="form-section">
                                    <div class="section-header">
                                        <div class="section-number">3</div>
                                        <div>
                                            <h5 class="fw-bold mb-1">Company Information</h5>
                                            <p class="section-subtitle">Tell candidates about your company</p>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">About Company</label>
                                                <div class="input-wrapper">
                                                    <i class="input-icon bi bi-info-circle" style="top: 20px;"></i>
                                                    <textarea name="about_company" id="aboutCompanyEditor" class="form-control" rows="4"
                                                        placeholder="Tell candidates about your company...">{{ old('about_company') }}</textarea>
                                                </div>
                                                <span
                                                    class="character-count">{{ strlen(old('about_company') ?? '') }}/2000</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Short Description</label>
                                                <div class="input-wrapper">
                                                    <i class="input-icon bi bi-file-text" style="top: 20px;"></i>
                                                    <textarea name="short_description" id="descriptionEditor" class="form-control" rows="4"
                                                        placeholder="Brief description of the role...">{{ old('short_description') }}</textarea>
                                                </div>
                                                <span
                                                    class="character-count">{{ strlen(old('short_description') ?? '') }}/500</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-file-input">
                                                <label class="form-label fw-semibold">Company Logo</label>

                                                <div class="file-upload-wrapper">

                                                    <input type="file" name="company_logo" id="company_logo"
                                                        class="file-input" accept="image/*">

                                                    <!-- Upload Area -->
                                                    <label for="company_logo" class="file-upload-area">
                                                        <i class="bi bi-cloud-upload"></i>
                                                        <div>
                                                            <strong>Click to upload</strong>
                                                            <span>or drag & drop</span>
                                                        </div>
                                                        <small>PNG, JPG up to 2MB</small>
                                                    </label>

                                                    <!-- Preview -->
                                                    <div class="file-preview" id="filePreview">
                                                        <img id="previewImage" src="">
                                                        <span class="file-name"></span>
                                                        <button type="button" class="remove-file"
                                                            onclick="clearFile()">×</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="premium-input">
                                                <label class="form-label">Source</label>
                                                <div class="input-wrapper">
                                                    <i class="input-icon bi bi-tag"></i>
                                                    <input type="text" name="source" class="form-control"
                                                        value="{{ old('source') }}"
                                                        placeholder="e.g. Company website, LinkedIn">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section 4: Additional Options --}}
                                <div class="form-section">
                                    <div class="section-header">
                                        <div class="section-number">4</div>
                                        <div>
                                            <h5 class="fw-bold mb-1">Additional Options</h5>
                                            <p class="section-subtitle">Enhance your job posting</p>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <div class="premium-toggle">
                                                <label class="toggle-label">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-patch-check text-success"></i>
                                                        <span>Verified Company</span>
                                                    </div>
                                                    <div class="toggle-wrapper">
                                                        <input type="checkbox" name="is_verified" value="1"
                                                            {{ old('is_verified') ? 'checked' : '' }}>
                                                        <span class="toggle-slider"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="premium-toggle">
                                                <label class="toggle-label">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-star text-warning"></i>
                                                        <span>Featured Job</span>
                                                    </div>
                                                    <div class="toggle-wrapper">
                                                        <input type="checkbox" name="is_featured" value="1"
                                                            {{ old('is_featured') ? 'checked' : '' }}>
                                                        <span class="toggle-slider"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="premium-toggle">
                                                <label class="toggle-label">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-wifi text-primary"></i>
                                                        <span>Remote Position</span>
                                                    </div>
                                                    <div class="toggle-wrapper">
                                                        <input type="checkbox" name="is_remote" value="1"
                                                            {{ old('is_remote') ? 'checked' : '' }}>
                                                        <span class="toggle-slider"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Preview Card --}}
                                    <div class="preview-card mt-4">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <i class="bi bi-eye-fill text-success"></i>
                                            <span class="fw-semibold">Job Posting Preview</span>
                                        </div>
                                        <div class="preview-content" id="jobPreview">
                                            <div class="text-center text-muted py-4">
                                                <i class="bi bi-file-text" style="font-size: 2rem;"></i>
                                                <p class="mt-2 mb-0">Your job preview will appear here as you type</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Form Actions --}}
                            <div class="form-actions">
                                <button type="button" class="btn-save-draft" onclick="saveDraft()">
                                    <i class="bi bi-save me-2"></i>
                                    Save as Draft
                                </button>
                                <button type="submit" class="btn-publish">
                                    <span class="btn-text">Publish Job</span>
                                    <i class="bi bi-check2-circle ms-2"></i>
                                    <div class="btn-glow"></div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Help Card --}}
                <div class="help-card mt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="help-icon">
                                <i class="bi bi-question-circle"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Need help posting a job?</h6>
                                <p class="text-muted small mb-0">Check out our guide or contact support</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn-help">View Guide</a>
                            <a href="{{ route('contact') }}" class="btn-help primary">Contact Support</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Job Post Form Styles */

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        padding: 12px 24px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
    }

    .btn-back:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateX(-5px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.1);
    }

    /* Premium Form Card */
    .premium-form-card {
        background: white;
        border-radius: 32px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.03);
    }

    .premium-form-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 2rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .header-icon {
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

    .header-subtitle {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 0;
    }

    /* Alert Premium */
    .alert-premium-danger {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: 1px solid #fecaca;
        border-radius: 20px;
        padding: 1.5rem;
        color: #b91c1c;
    }

    .alert-icon {
        width: 40px;
        height: 40px;
        background: #ef4444;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    /* Form Sections */
    .form-sections {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .form-section {
        background: #f8fafc;
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .form-section:hover {
        background: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .section-number {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.2);
    }

    .section-subtitle {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 0;
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

    .input-wrapper,
    .select-wrapper {
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
        pointer-events: none;
    }

    .premium-input:focus-within .input-icon {
        color: #10b981;
    }

    .premium-input .form-control,
    .premium-input .form-select {
        height: 52px;
        padding-left: 48px;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
    }

    .premium-input textarea.form-control {
        height: auto;
        padding-top: 16px;
    }

    .premium-input .form-control:focus,
    .premium-input .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .character-count {
        display: block;
        text-align: right;
        font-size: 0.8rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    /* File Upload */
    .file-input {
        display: none;
    }

    .file-upload-wrapper {
        position: relative;
    }

    /* Upload Area */
    .file-upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 20px;
        padding: 2.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }

    .file-upload-area:hover {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.03);
        transform: translateY(-2px);
    }

    .file-upload-area i {
        font-size: 2.5rem;
        color: #10b981;
        margin-bottom: 10px;
    }

    .file-upload-area strong {
        font-size: 0.95rem;
    }

    .file-upload-area span {
        font-size: 0.85rem;
        color: #64748b;
    }

    /* Glass Preview */
    .file-preview {
        position: absolute;
        inset: 0;
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        border-radius: 20px;

        /* Glassmorphism */
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(16, 185, 129, 0.3);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);

        animation: fadeIn 0.3s ease forwards;
    }

    .file-preview img {
        max-height: 90px;
        object-fit: contain;
        border-radius: 12px;
    }

    .file-name {
        font-size: 0.85rem;
        font-weight: 500;
        color: #1e293b;
        text-align: center;
        max-width: 80%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .remove-file {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .remove-file:hover {
        background: #ef4444;
        color: white;
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.98);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Premium Toggle */
    .premium-toggle {
        background: white;
        padding: 1rem;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .premium-toggle:hover {
        border-color: #10b981;
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.05);
    }

    .toggle-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        margin: 0;
    }

    .toggle-wrapper {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
    }

    .toggle-wrapper input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e2e8f0;
        transition: 0.3s;
        border-radius: 34px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .toggle-wrapper input:checked+.toggle-slider {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .toggle-wrapper input:checked+.toggle-slider:before {
        transform: translateX(24px);
    }

    /* Preview Card */
    .preview-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
    }

    .preview-content {
        min-height: 100px;
        background: #f8fafc;
        border-radius: 16px;
        padding: 1rem;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }

    .btn-save-draft {
        flex: 1;
        padding: 16px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        color: #475569;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-save-draft:hover {
        border-color: #10b981;
        color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.02) 0%, rgba(4, 120, 87, 0.02) 100%);
    }

    .btn-publish {
        flex: 2;
        padding: 16px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border: none;
        border-radius: 60px;
        color: white;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        cursor: pointer;
    }

    .btn-publish:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4);
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

    .btn-publish:hover .btn-glow {
        opacity: 1;
    }

    /* Help Card */
    .help-card {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 24px;
        padding: 1.5rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .help-icon {
        width: 48px;
        height: 48px;
        background: white;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #10b981;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.02);
    }

    .btn-help {
        padding: 8px 20px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        color: #475569;
        background: white;
        border: 1px solid #e2e8f0;
    }

    .btn-help.primary {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
    }

    .btn-help:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<script>
    // File upload preview
    document.addEventListener('DOMContentLoaded', function() {

        const input = document.getElementById('company_logo');
        const preview = document.getElementById('filePreview');
        const previewImg = document.getElementById('previewImage');
        const fileName = preview.querySelector('.file-name');

        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            fileName.textContent = file.name;
            preview.style.display = 'flex';

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImg.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        window.clearFile = function() {
            input.value = '';
            preview.style.display = 'none';
            previewImg.src = '';
        };

    });

    // Live preview
    const titleInput = document.querySelector('input[name="title"]');
    const locationInput = document.querySelector('input[name="location"]');
    const typeSelect = document.querySelector('select[name="job_type"]');
    const previewDiv = document.getElementById('jobPreview');

    function updatePreview() {
        const title = titleInput.value || 'Job Title';
        const location = locationInput.value || 'Location';
        const type = typeSelect.options[typeSelect.selectedIndex]?.text || 'Job Type';

        previewDiv.innerHTML = `
            <div class="preview-item">
                <h5 class="fw-bold mb-2">${title}</h5>
                <div class="d-flex gap-3 mb-2">
                    <span class="text-muted"><i class="bi bi-geo-alt me-1"></i>${location}</span>
                    <span class="text-muted"><i class="bi bi-clock me-1"></i>${type}</span>
                </div>
                <p class="text-muted small mb-0">Your job description will appear here...</p>
            </div>
        `;
    }

    titleInput?.addEventListener('input', updatePreview);
    locationInput?.addEventListener('input', updatePreview);
    typeSelect?.addEventListener('change', updatePreview);

    // Character counters
    const aboutCompany = document.querySelector('textarea[name="about_company"]');
    const shortDesc = document.querySelector('textarea[name="short_description"]');

    if (aboutCompany) {
        aboutCompany.addEventListener('input', function() {
            const count = this.value.length;
            this.closest('.premium-input').querySelector('.character-count').textContent = `${count}/2000`;
        });
    }

    if (shortDesc) {
        shortDesc.addEventListener('input', function() {
            const count = this.value.length;
            this.closest('.premium-input').querySelector('.character-count').textContent = `${count}/500`;
        });
    }

    // Save draft functionality
    function saveDraft() {
        // Get form data
        const formData = new FormData(document.getElementById('jobPostForm'));
        const formObject = {};
        formData.forEach((value, key) => {
            formObject[key] = value;
        });

        // Save to localStorage
        localStorage.setItem('jobDraft', JSON.stringify(formObject));

        // Show success message
        alert('Draft saved successfully!');
    }

    // Load draft if exists
    window.addEventListener('load', function() {
        const draft = localStorage.getItem('jobDraft');
        if (draft) {
            if (confirm('You have a saved draft. Would you like to load it?')) {
                const formData = JSON.parse(draft);
                // Populate form fields
                Object.keys(formData).forEach(key => {
                    const field = document.querySelector(`[name="${key}"]`);
                    if (field) {
                        if (field.type === 'checkbox') {
                            field.checked = formData[key] === '1';
                        } else {
                            field.value = formData[key];
                        }
                    }
                });
                updatePreview();
            }
        }
    });
</script>

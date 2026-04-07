@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold">Edit Job</h3>
                    <a href="{{ route('employer.dashboard') }}" class="btn btn-outline-secondary">
                        ← Back to Dashboard
                    </a>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('update', $job->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Job Title -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Job Title</label>
                                <input type="text" name="title" class="form-control rounded-3"
                                    value="{{ old('title', $job->title) }}" required>
                            </div>

                            <!-- Company Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Company Name</label>
                                <input type="text" name="company_name" class="form-control rounded-3"
                                    value="{{ old('company_name', $job->company_name) }}" required>
                            </div>

                            <!-- Verified -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="is_verified" value="1" class="form-check-input"
                                    {{ old('is_verified', $job->is_verified) ? 'checked' : '' }}>
                                <label class="form-check-label">Verified Company</label>
                            </div>

                            <!-- Company Logo -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Company Logo</label>
                                <input type="file" name="company_logo" class="form-control rounded-3">
                                @if ($job->company_logo)
                                    <small class="text-muted">Current: {{ $job->company_logo }}</small>
                                @endif
                            </div>

                            <!-- About Company -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">About Company</label>
                                <textarea name="about_company" class="form-control rounded-3" rows="3">{{ old('about_company', $job->about_company) }}</textarea>
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Category</label>
                                <select name="category_id" class="form-select rounded-3" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Job Type -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Job Type</label>
                                <select name="job_type" class="form-select rounded-3" required>
                                    <option value="">Select Type</option>
                                    <option value="full-time"
                                        {{ old('job_type', $job->job_type) == 'full-time' ? 'selected' : '' }}>Full Time
                                    </option>
                                    <option value="part-time"
                                        {{ old('job_type', $job->job_type) == 'part-time' ? 'selected' : '' }}>Part Time
                                    </option>
                                    <option value="contract"
                                        {{ old('job_type', $job->job_type) == 'contract' ? 'selected' : '' }}>Contract
                                    </option>
                                    <option value="internship"
                                        {{ old('job_type', $job->job_type) == 'internship' ? 'selected' : '' }}>Internship
                                    </option>
                                </select>
                            </div>

                            <!-- Experience Level -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Experience Level</label>
                                <select name="experience_level" class="form-select" required>
                                    <option value="">Experience Level</option>
                                    <option value="entry"
                                        {{ old('experience_level', $job->experience_level) == 'entry' ? 'selected' : '' }}>
                                        Entry</option>
                                    <option value="mid"
                                        {{ old('experience_level', $job->experience_level) == 'mid' ? 'selected' : '' }}>
                                        Mid</option>
                                    <option value="senior"
                                        {{ old('experience_level', $job->experience_level) == 'senior' ? 'selected' : '' }}>
                                        Senior</option>
                                </select>
                            </div>

                            <!-- Location -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Location</label>
                                <input type="text" name="location" class="form-control rounded-3"
                                    value="{{ old('location', $job->location) }}" required>
                            </div>

                            <!-- Salary Range -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Salary Range</label>
                                <input type="text" name="salary_range" class="form-control rounded-3"
                                    value="{{ old('salary_range', $job->salary_range) }}">
                            </div>

                            <!-- Apply URL -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Official Apply URL</label>
                                <input type="text" name="apply_url" class="form-control rounded-3"
                                    value="{{ old('apply_url', $job->apply_url) }}" required>
                            </div>

                            <!-- Short Description -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Short Description</label>
                                <textarea name="short_description" class="form-control rounded-3" rows="5">{{ old('short_description', $job->short_description) }}</textarea>
                            </div>

                            <!-- Deadline -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Application Deadline</label>
                                <input type="date" name="deadline" class="form-control rounded-3"
                                    value="{{ old('deadline', $job->deadline ? $job->deadline->format('Y-m-d') : '') }}">
                            </div>

                            <!-- Source -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Source</label>
                                <input type="text" name="source" class="form-control rounded-3"
                                    value="{{ old('source', $job->source) }}">
                            </div>

                            <!-- Remote Toggle -->
                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_remote"
                                    value="1" {{ old('is_remote', $job->is_remote) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold">This job is Remote</label>
                            </div>

                            <!-- Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark rounded-3">
                                    Update Job
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

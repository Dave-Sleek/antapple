@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Job</h2>

        <form method="POST" action="{{ route('editor-jobs.update', $job) }}" enctype="multipart/form-data" id="jobForm">
            @csrf
            @method('PUT')

            {{-- Job Title --}}
            <input class="form-control mb-3" name="title" value="{{ old('title', $job->title) }}" required>

            {{-- Company Name --}}
            <input class="form-control mb-3" name="company_name" value="{{ old('company_name', $job->company_name) }}"
                required>

            <input type="checkbox" name="is_verified" value="1" class="form-check-input mb-3"
                @checked($job->is_verified)>
            <label class="form-check-label">Verified Company</label>

            {{-- About Company --}}
            <textarea id="aboutCompanyEditor" class="form-control mb-3" name="about_company" rows="3">{{ old('about_company', $job->about_company) }}</textarea>


            {{-- Company Logo --}}
            <div class="mb-3">
                <label class="form-label">Company Logo</label>
                <input type="file" name="company_logo" class="form-control">

                @if ($job->company_logo)
                    <img src="{{ asset('storage/' . $job->company_logo) }}" class="mt-2 rounded" width="80">
                @endif
            </div>

            {{-- Category --}}
            <select name="category_id" class="form-control mb-3" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($job->category_id == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            {{-- Job Type --}}
            <select name="job_type" class="form-control mb-3">
                @foreach (['full-time', 'part-time', 'contract', 'internship'] as $type)
                    <option value="{{ $type }}" @selected($job->job_type === $type)>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>

            {{-- Experience Level --}}
            <select name="experience_level" class="form-control mb-3">
                @foreach (['entry', 'mid', 'senior'] as $level)
                    <option value="{{ $level }}" @selected($job->experience_level === $level)>
                        {{ ucfirst($level) }}
                    </option>
                @endforeach
            </select>

            {{-- Location --}}
            <input class="form-control mb-3" name="location" value="{{ old('location', $job->location) }}" required>

            {{-- Salary --}}
            <input class="form-control mb-3" name="salary_range" value="{{ old('salary_range', $job->salary_range) }}">

            {{-- Apply URL --}}
            <input class="form-control mb-3" name="apply_url" value="{{ old('apply_url', $job->apply_url) }}" required>

            {{-- Rich Text Description --}}
            {{-- <textarea class="form-control mb-3" name="short_description" id="descriptionEditor" rows="6">{{ old('short_description', $job->short_description) }}</textarea> --}}
            <textarea class="form-control mb-3" name="short_description" id="descriptionEditor" rows="6">{{ old('short_description', $job->short_description) }}</textarea>


            {{-- Deadline --}}
            <input type="date" class="form-control mb-3" name="deadline"
                value="{{ optional($job->deadline)->format('Y-m-d') }}">

            {{-- Source --}}
            <input class="form-control mb-3" name="source" value="{{ old('source', $job->source) }}">

            {{-- Featured --}}
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                    @checked($job->is_featured)>
                <label class="form-check-label">Featured Job</label>
            </div>

            {{-- Status --}}
            <select name="status" class="form-control mb-4">
                <option value="active" @selected($job->status === 'active')>Active</option>
                <option value="expired" @selected($job->status === 'expired')>Expired</option>
            </select>

            {{-- Buttons --}}
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                    data-bs-target="#previewModal">
                    Preview
                </button>

                <button class="btn btn-primary">
                    Update Job
                </button>
            </div>
        </form>
    </div>

    @include('admin.jobs.preview-modal')
@endsection

<script>
    document.querySelector('[data-bs-target="#previewModal"]').addEventListener('click', () => {
        document.getElementById('previewTitle').innerText =
            document.querySelector('[name="title"]').value;

        document.getElementById('previewCompany').innerText =
            document.querySelector('[name="company_name"]').value;

        document.getElementById('previewMeta').innerText =
            document.querySelector('[name="location"]').value + ' · ' +
            document.querySelector('[name="job_type"]').value;

        document.getElementById('previewDescription').innerHTML =
            tinymce.get('descriptionEditor').getContent();
    });
</script>

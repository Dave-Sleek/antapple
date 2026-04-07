@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Post New Job</h2>

        <form method="POST" action="{{ route('admin.jobs.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Job Title --}}
            <input class="form-control mb-3" name="title" placeholder="Job Title" value="{{ old('title') }}" required>

            {{-- Company Name --}}
            <input class="form-control mb-3" name="company_name" placeholder="Company Name" value="{{ old('company_name') }}"
                required>

            <input type="checkbox" name="is_verified" value="1" class="form-check-input mb-3">
            <label class="form-check-label">Verified Company</label>

            {{-- Company logo --}}
            <input type="file" name="company_logo" class="form-control mb-3" accept="image/*">

            {{-- About Company --}}
            <textarea id="aboutCompanyEditor" class="form-control mb-3" name="about_company"></textarea>



            {{-- Category --}}
            <select name="category_id" class="form-control mb-3" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            {{-- Job Type --}}
            <select name="job_type" class="form-control mb-3" required>
                <option value="">Job Type</option>
                <option value="full-time">Full Time</option>
                <option value="part-time">Part Time</option>
                <option value="contract">Contract</option>
                <option value="internship">Internship</option>
            </select>

            {{-- Experience Level --}}
            <select name="experience_level" class="form-control mb-3" required>
                <option value="">Experience Level</option>
                <option value="entry">Entry</option>
                <option value="mid">Mid</option>
                <option value="senior">Senior</option>
            </select>

            {{-- Location --}}
            <input class="form-control mb-3" name="location" placeholder="Location (City / Country)"
                value="{{ old('location') }}" required>

            {{-- Salary --}}
            <input class="form-control mb-3" name="salary_range" placeholder="Salary Range (optional)"
                value="{{ old('salary_range') }}">

            {{-- Apply URL --}}
            <input class="form-control mb-3" name="apply_url" placeholder="Official Apply URL"
                value="{{ old('apply_url') }}" required>

            {{-- Short Description --}}
            {{-- <textarea class="form-control mb-3" name="short_description" rows="5" placeholder="Short job description"
                required>{{ old('short_description') }}</textarea> --}}
            <textarea class="form-control mb-3" name="short_description" id="descriptionEditor" rows="5">{{ old('short_description') }}</textarea>

            {{-- Deadline --}}
            <input type="date" class="form-control mb-3" name="deadline" value="{{ old('deadline') }}">

            {{-- Source --}}
            <input class="form-control mb-3" name="source" placeholder="Source (Company website, LinkedIn, etc.)"
                value="{{ old('source') }}">

            {{-- Featured --}}
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_featured" value="1">
                <label class="form-check-label">
                    Featured Job
                </label>
            </div>

            {{-- Status --}}
            <select name="status" class="form-control mb-4" required>
                <option value="active">Active</option>
                <option value="inactive">Expired</option>
            </select>


            {{-- <div class="form-check mb-3">
                <input type="checkbox" name="is_remote" value="1" class="form-check-input"
                    {{ request('is_remote') ? 'checked' : '' }}>
                <label class="form-check-label">Remote only</label>
            </div> --}}

            <div class="form-check mb-3">
                <input type="checkbox" name="is_remote" value="1" class="form-check-input">
                <label class="form-check-label">Remote only</label>
            </div>


            <button class="btn btn-success">
                Publish Job
            </button>

            {{-- Buttons --}}
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#previewModal">
                Preview
            </button>

            <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary ms-2">
                Cancel
            </a>
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

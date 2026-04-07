@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h3>Apply for: {{ $job->title }}</h3>
        <p>Company: {{ $job->company_name }}</p>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('jobs.apply.store', $job->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="resume" class="form-label">Upload Resume (PDF/DOC)</label>
                <input type="file" name="resume" id="resume" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="cover_letter" class="form-label">Cover Letter (Optional)</label>
                <textarea name="cover_letter" id="descriptionEditor" rows="4" class="form-control">{{ old('cover_letter') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Application</button>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="card shadow-sm border-0 rounded-4 p-4">

            <h4 class="fw-bold mb-3">Applicant Details</h4>

            <p><strong>Job:</strong> {{ $applicant->job->title }}</p>
            <p><strong>Name:</strong> {{ $applicant->name }}</p>
            <p><strong>Email:</strong> {{ $applicant->email }}</p>

            <hr>

            <h6 class="fw-bold">Cover Letter</h6>
            <p>{{ $applicant->cover_letter ?? 'No cover letter provided.' }}</p>

            <hr>

            <h6 class="fw-bold">Resume</h6>

            @if ($applicant->resume)
                <a href="{{ asset('storage/' . $applicant->resume) }}" target="_blank" class="btn btn-dark">
                    Download Resume
                </a>
            @else
                <p class="text-muted">No resume uploaded.</p>
            @endif

        </div>

    </div>
@endsection

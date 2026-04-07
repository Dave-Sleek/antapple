@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Report #{{ $report->id }}</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold">{{ $report->job->title }}</h5>
                <p class="text-muted">{{ $report->job->company_name }}</p>

                <p><strong>Reason:</strong> {{ $report->reason }}</p>
                <p><strong>Message:</strong> {{ $report->message ?? 'No message provided' }}</p>
                <p><strong>Reported At:</strong> {{ $report->created_at->format('M d, Y H:i') }}</p>

                <a href="{{ route('jobs.show', [$report->job->uuid, $report->job->slug]) }}" class="btn btn-outline-primary"
                    target="_blank">
                    View Job
                </a>

            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <h4 class="mb-4">Draft Jobs</h4>

        @foreach ($jobs as $job)
            <div class="card mb-3 p-3 d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="mb-1">{{ $job->title }}</h6>
                    <small class="text-muted">{{ $job->company_name }}</small>
                </div>

                <div class="d-flex gap-2">

                    <a href="{{ route('editor-jobs.edit', $job) }}" class="btn btn-sm btn-primary">
                        Edit
                    </a>

                    <form action="{{ route('editor-jobs.publish', $job) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-success">
                            Publish
                        </button>
                    </form>

                </div>
            </div>
        @endforeach

        {{ $jobs->links() }}

    </div>
@endsection

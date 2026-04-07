@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">
            Jobs in {{ $category->name }}
        </h3>

        @forelse($jobs as $job)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $job->title }}</h5>
                    <p class="text-muted">{{ $job->location }}</p>
                </div>
            </div>
        @empty
            <p>No jobs found in this category.</p>
        @endforelse

        {{ $jobs->links() }}
    </div>
@endsection

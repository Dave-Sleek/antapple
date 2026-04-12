@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">

        <div class="d-flex justify-content-between mb-3">
            <h4>Manage Opportunities</h4>
            <a href="{{ route('admin.opportunities.create') }}" class="btn btn-primary">
                + Add Opportunity
            </a>
        </div>

        @foreach ($opportunities as $item)
            <div class="card mb-3 p-3">

                <h5>{{ $item->title }}</h5>
                <p class="small text-muted">
                    {{ $item->type }} • {{ $item->organization }}
                </p>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.opportunities.edit', $item) }}" class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('admin.opportunities.destroy', $item) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            Delete
                        </button>
                    </form>
                </div>

            </div>
        @endforeach

        {{ $opportunities->links() }}

    </div>
@endsection

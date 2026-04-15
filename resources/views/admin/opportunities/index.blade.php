@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">

        <div class="row mb-4">

            <div class="col-md-4">
                <div class="card p-3">
                    <h6>Total Views</h6>
                    <h3>{{ $totalViews }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3">
                    <h6>Total Clicks</h6>
                    <h3>{{ $totalClicks }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3">
                    <h6>Conversion Rate</h6>
                    <h3>{{ $conversionRate }}%</h3>
                </div>
            </div>

        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Views</th>
                    <th>Clicks</th>
                    <th>Conversion</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($opportunities as $item)
                    <tr>
                        <td>{{ $item->title }}</td>

                        <td>
                            👁️ {{ $item->views_count }}
                        </td>

                        <td>
                            🔗 {{ $item->clicks_count }}
                        </td>

                        <td>
                            @if ($item->views_count > 0)
                                {{ round(($item->clicks_count / $item->views_count) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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

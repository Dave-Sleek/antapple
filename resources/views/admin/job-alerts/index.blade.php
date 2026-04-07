@extends('admin.layouts.app')

@section('content')
    <h1 class="mb-4">Job Alerts</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Email</th>
                <th>Category</th>
                <th>Location</th>
                <th>Remote</th>
                <th>Created</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alerts as $alert)
                <tr>
                    <td>{{ $alert->email }}</td>
                    <td>{{ optional($alert->category)->name ?? 'Any' }}</td>
                    <td>{{ $alert->location ?? 'Any' }}</td>
                    <td>
                        @if ($alert->remote_only)
                            <span class="badge bg-success">Yes</span>
                        @else
                            No
                        @endif
                    </td>
                    <td>{{ $alert->created_at->diffForHumans() }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.job-alerts.destroy', $alert) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $alerts->links() }}
@endsection

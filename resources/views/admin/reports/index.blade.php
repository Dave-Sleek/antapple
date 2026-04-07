@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Manage Reports</h2>

        <table class="table table-hover shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Job</th>
                    <th>Reason</th>
                    <th>Message</th>
                    <th>Reported At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>
                            @if ($report->job)
                                <a href="{{ route('jobs.show', ['job' => $report->job->uuid, 'slug' => $report->job->slug]) }}"
                                    target="_blank">
                                    {{ $report->job->title }}
                                </a>
                            @else
                                <span class="text-muted">Job not available</span>
                            @endif
                        </td>
                        <td><span class="badge bg-danger">{{ $report->reason }}</span></td>
                        <td>{{ Str::limit($report->message, 50) }}</td>
                        <td>{{ $report->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-sm btn-primary">View</a>
                            <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete this report?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $reports->links() }}
    </div>
@endsection

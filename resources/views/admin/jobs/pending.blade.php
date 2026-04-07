@extends('admin.layouts.app')

@section('content')
    <div class="container py-5">

        <h3 class="fw-bold mb-4">Pending Job Approvals</h3>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($pendingJobs as $job)
                            <tr>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->company_name }}</td>
                                <td>{{ $job->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.approve', $job->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.reject', $job->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-danger">
                                            Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    No pending jobs.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection

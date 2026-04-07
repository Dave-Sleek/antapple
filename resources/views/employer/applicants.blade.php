@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <h4 class="fw-bold mb-4">
            Applicants for: {{ $job->title }}
        </h4>

        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Resume</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($applicants as $applicant)
                            <tr>
                                <td>{{ $applicant->name }}</td>
                                <td>{{ $applicant->email }}</td>
                                <td>
                                    @if ($applicant->resume)
                                        <a href="{{ asset('storage/' . $applicant->resume) }}" target="_blank"
                                            class="btn btn-sm btn-outline-dark">
                                            View Resume
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $applicant->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    No applicants yet.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection

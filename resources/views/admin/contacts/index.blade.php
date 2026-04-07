@extends('admin.layouts.app')

@section('content')
    <h2 class="mb-4">Contact Messages</h2>

    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Status</th>
                <th>Received</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $msg)
                <tr class="{{ !$msg->is_read ? 'fw-bold' : '' }}">
                    <td>{{ $msg->name }}</td>
                    <td>{{ $msg->email }}</td>
                    <td>{{ Str::limit($msg->message, 50) }}</td>
                    <td>
                        @if ($msg->is_read)
                            <span class="badge bg-secondary">Read</span>
                        @else
                            <span class="badge bg-success">New</span>
                        @endif
                    </td>
                    <td>{{ $msg->created_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('admin.contacts.show', $msg) }}" class="btn btn-sm btn-outline-primary">
                            View
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $messages->links() }}
@endsection

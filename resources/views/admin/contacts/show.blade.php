@extends('admin.layouts.app')

@section('content')
    <h2>Message from {{ $contact->name }}</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <p><strong>Email:</strong> {{ $contact->email }}</p>
            <p><strong>IP:</strong> {{ $contact->ip_address }}</p>

            <hr>

            <p>{{ $contact->message }}</p>

            <hr>

            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}"
                onsubmit="return confirm('Delete this message?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                    Delete Message
                </button>
            </form>

        </div>
    </div>
@endsection

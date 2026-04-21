@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <h4>Edit Opportunity</h4>

        <form method="POST" action="{{ route('editor-opportunities.update', $opportunity) }}" enctype="multipart/form-data"
            class="mt-4">
            @csrf
            @method('PUT')

            @include('editor.opportunities.form')

            <button class="btn btn-primary mt-3">Update</button>
        </form>

    </div>
@endsection

@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">

        <h4>Edit Opportunity</h4>

        <form method="POST" action="{{ route('admin.opportunities.update', $opportunity) }}" enctype="multipart/form-data"
            class="mt-4">
            @csrf
            @method('PUT')

            @include('admin.opportunities.form')

            <button class="btn btn-primary mt-3">Update</button>
        </form>

    </div>
@endsection

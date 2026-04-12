@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">

        <h4>Create Opportunity</h4>

        <form method="POST" action="{{ route('admin.opportunities.store') }}" enctype="multipart/form-data" class="mt-4">
            @csrf

            @include('admin.opportunities.form')

            <button class="btn btn-success mt-3">Create</button>
        </form>

    </div>
@endsection

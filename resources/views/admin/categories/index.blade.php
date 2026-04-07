@extends('layouts.app')

@section('content')
    <h2>Categories</h2>

    <form method="POST">
        @csrf
        <input class="form-control mb-2" name="name" placeholder="Category name">
        <button class="btn btn-primary btn-sm">Add</button>
    </form>

    <ul class="mt-3">
        @foreach ($categories as $category)
            <li>{{ $category->name }}</li>
        @endforeach
    </ul>
@endsection

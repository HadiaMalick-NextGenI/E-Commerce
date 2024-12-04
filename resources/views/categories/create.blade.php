@extends('layouts.app')

@section('content')
    <h2>Create New Category</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(@session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endsession

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="parent_id">Parent Category Id:</label>
            <input type="text" name="parent_id" id="parent_id" class="form-control" value="{{ old('parent_id') }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Category</button>
    </form>
@endsection
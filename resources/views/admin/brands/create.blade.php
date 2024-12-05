@extends('layouts.app')

@section('content')
    <h2>Create New Brand</h2>

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

    <form action="{{ route('brands.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Brand Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Brand Description:</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Brand</button>
    </form>
@endsection
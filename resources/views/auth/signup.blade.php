@extends('layouts.app')

@section('content')
<h2 class="mt-5">Signup Here</h2>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
            <span class="text-danger">
                @error('name')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
            <span class="text-danger">
                @error('email')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}" required>
            <span class="text-danger">
                @error('password')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
            <span class="text-danger">
                @error('phone')
                    {{ $message }}
                @enderror
            </span>
        </div>
        
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}">
            <span class="text-danger">
                @error('address')
                    {{ $message }}
                @enderror
            </span>
        </div>

        {{-- <div class="form-group">
            <input type="hidden" class="form-control" id="profile_picture" name="roles" value="user">
        </div> --}}

        <button type="submit" class="btn btn-primary">Signup</button>
    </form>
@endsection
@extends('layouts.app')

@include('partials.nav_bar')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Our Products</h2>

    <form method="GET" action="{{ route('products') }}" class="mb-4">
        <div class="row align-items-center">
            <div class="col-md-4">
                <select name="category" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-4">
                <select name="brand" class="form-control">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-4 d-flex justify-content-between mt-2 mt-md-0">
                <button type="submit" class="btn btn-primary flex-fill mr-2">Filter</button>
                <a href="{{ route('products') }}" class="btn btn-secondary flex-fill">Clear</a>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border rounded">
                <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                    <img src="{{ $product->image ? asset('/storage/' . $product->image) : asset('/storage/images/product_default.png') }}" 
                         class="card-img-top img-fluid rounded-top" 
                         alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-primary font-weight-bold">PKR{{ number_format($product->price, 2) }}</p>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
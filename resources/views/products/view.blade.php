@extends('layouts.app')

@include('partials.nav_bar')

@section('content')
<div class="container py-5">
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
    
    <div class="row">
        <div class="col-md-6">
            <div class="product-image text-center">
                <img src="{{ $product->image ? asset('/storage/' . $product->image) : asset('/storage/images/product_default.png') }}" 
                     class="img-fluid rounded" 
                     alt="{{ $product->name }}">
            </div>
        </div>

        <div class="col-md-6">
            <h2 class="product-title">{{ $product->name }}</h2>
            <h4 class="text-primary mb-3">PKR{{ number_format($product->price, 2) }}</h4>
            
            @if($product->stock_quantity > 0)
                <p class="text-success font-weight-bold">In Stock: {{ $product->stock_quantity }} available</p>
            @else
                <p class="text-danger font-weight-bold">Out of Stock</p>
            @endif
            
            <p><strong>Size:</strong> {{ $product->size }}</p>
            <p><strong>Color:</strong> {{ ucfirst($product->color) }}</p>
            
            <div class="mt-4">
                <h5>Description:</h5>
                <p>{{ $product->description }}</p>
            </div>

            <p class="mt-3"><strong>Category:</strong> {{ $product->category->name}}</p>
            <p><strong>Brand:</strong> {{ $product->brand->name }}</p>
            
            @if($product->stock_quantity > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
                </form>
            @else
                <button class="btn btn-secondary btn-lg mt-3" disabled>Out of Stock</button>
            @endif
        </div>
    </div>
</div>
@endsection
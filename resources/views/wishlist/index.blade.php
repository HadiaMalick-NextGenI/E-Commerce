@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Your Wishlist</h1>
    @if ($products->isEmpty())
        <div class="text-center">
            <p class="text-muted">Your wishlist is empty.</p>
            <a href="{{ route('products') }}" class="btn btn-primary">
                Browse Products
            </a>
        </div>
    @else
        <div class="row">
            @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border rounded position-relative">
                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                        <img src="{{ $product->image ? asset('/storage/' . $product->image) : asset('/storage/images/product_default.png') }}" 
                             class="card-img-top img-fluid rounded-top" 
                             alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <div class="text-primary font-weight-bold mb-3">
                                PKR{{ number_format($product->price, 0) }}
                            </div>
                        </div>
                    </a>

                    <form action="{{ route('wishlist.remove', $product) }}" method="POST" class="position-absolute" style="top: 10px; right: 10px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link p-0 text-danger">
                            <i class="fas fa-times-circle" style="font-size: 1.5rem;"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container py-3">
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

            <div class="mt-4">
                <h5 class="text-info">Discount & Sale Info:</h5>
                @if($product->discount_percentage > 0)
                    <p><strong>Discount:</strong> {{ round($product->discount_percentage) }}% off</p>
                    @if($product->sale_end_date)
                        <p><strong>Sale Ends On:</strong> {{ \Carbon\Carbon::parse($product->sale_end_date)->format('d M, Y') }}</p>
                    @else
                        <p><strong>Sale Ends On:</strong> Not specified</p>
                    @endif
                @else
                    <p>No discounts available.</p>
                @endif
            </div>

            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
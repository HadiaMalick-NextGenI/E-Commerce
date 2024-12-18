@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Products</h1>
    
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

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Discount Type</th>
                <th>Discount End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>PKR{{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->brand->name }}</td>
                    <td>
                        @if($product->discount_type)
                            {{ $product->discount_type }}
                        @else
                            No Discount
                        @endif
                    </td>
                    <td>
                        @if($product->discount_end_date)
                            {{ $product->discount_end_date }}
                        @else
                            No Date Specified
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-primary">View</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
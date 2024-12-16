@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>
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
    
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description" required>{{ $product->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" name="price" value="{{ $product->price }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control" name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="brand_id">Brand:</label>
            <select class="form-control" name="brand_id" required>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" class="form-control" name="stock_quantity" value="{{ $product->stock_quantity }}" required>
        </div>

        <div class="form-group">
            <label for="size">Size:</label>
            <input type="text" class="form-control" name="size" value="{{ $product->size }}" required>
        </div>

        <div class="form-group">
            <label for="color">Color:</label>
            <input type="text" class="form-control" name="color" value="{{ $product->color }}" required>
        </div>

        <div class="form-group">
            <label for="discount_type">Discount Type:</label>
            <select name="discount_type" id="discount_type" class="form-control" required>
                <option value="">Select Discount Type</option>
                <option value="flat" {{ old('discount_type') == 'flat' ? 'selected' : '' }}>Flat</option>
                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
            </select>
            @error('discount_type')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="discount_percentage">Discount Percentage:</label>
            <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" step="0.01" 
                   value="{{ $product->discount_percentage }}">
        </div>

        <div class="form-group">
            <label for="discount_price">Discount Price:</label>
            <input type="number" name="discount_price" id="discount_price" class="form-control" step="0.01" 
                   value="{{ old('discount_price') }}">
        </div>
        
        <div class="form-group">
            <label for="discount_end_date">Discount End Date:</label>
            <input type="date" name="discount_end_date" id="discount_end_date" class="form-control" 
                    value="{{ $product->discount_end_date ? $product->discount_end_date->format('Y-m-d') : '' }}">
        </div>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" name="image">
            @if ($product->image)
                <img src="{{ asset('/storage/' . $product->image) }}" width="100" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Product</h2>

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

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Category:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="brand_id">Brand:</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
                <option value="">Select Brand</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ old('stock_quantity') }}" required>
        </div>

        <div class="form-group">
            <label for="size">Size:</label>
            <input type="text" name="size" id="size" class="form-control" value="{{ old('size') }}" required>
        </div>

        <div class="form-group">
            <label for="color">Color:</label>
            <input type="text" name="color" id="color" class="form-control" value="{{ old('color') }}" required>
        </div>

        <div class="form-group">
            <label for="discount_type">Discount Type:</label>
            <select name="discount_type" id="discount_type" class="form-control">
                <option value="">Select Discount Type</option>
                <option value="flat">Flat</option>
                <option value="percentage">Percentage</option>
            </select>
            @error('discount_type')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="discount_percentage">Discount Percentage:</label>
            <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" step="0.01" 
                   value="{{ old('discount_percentage') }}">
        </div>

        <div class="form-group">
            <label for="discount_price">Discount Price:</label>
            <input type="number" name="discount_price" id="discount_price" class="form-control" step="0.01" 
                   value="{{ old('discount_price') }}">
        </div>
        
        <div class="form-group">
            <label for="discount_end_date">Discount End Date:</label>
            <input type="date" name="discount_end_date" id="discount_end_date" class="form-control" 
                   value="{{ old('discount_end_date') }}" placeholder="Select discount end date">
        </div>

        <div class="form-group">
            <label for="image">Product Image:</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Product</button>
    </form>
</div>
@endsection
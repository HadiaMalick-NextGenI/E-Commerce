<form method="GET" action="{{ route('products') }}" class="mb-4">
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search products..."
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="col-md-4 text-md-end">
            <a href="{{ route('products') }}" class="btn btn-secondary">Clear All Filters</a>
        </div>
    </div>

    <div class="row g-3">
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

        <div class="col-md-4 text-md-end">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </div>
    </div>
</form>
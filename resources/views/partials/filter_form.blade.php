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
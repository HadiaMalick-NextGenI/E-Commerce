<form id="filter-form" class="mb-4">
    <div class="row g-3 mb-3 align-items-center">
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" id="search" class="form-control" placeholder="Search products...">
                <button type="button" id="search-btn" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="col-md-4 text-md-end">
            <button type="button" id="clear-filters" class="btn btn-secondary">Clear All Filters</button>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <select id="category" class="form-control">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <select id="brand" class="form-control">
                <option value="">Select Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 text-md-end">
            <button type="button" id="apply-filters" class="btn btn-primary">Apply Filters</button>
        </div>
    </div>
</form>
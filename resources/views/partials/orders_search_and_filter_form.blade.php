<form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
    <div class="row align-items-center">
        <div class="col-md-6 mb-2">
            <div class="input-group">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control" 
                    placeholder="Search by User Name/Email or Reference ID" 
                    value="{{ request('search') }}"
                >
                <button class="btn btn-outline-primary" type="submit">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </div>

        <div class="col-md-6 d-flex align-items-center mb-2">
            <label for="status-filter" class="form-label fw-bold text-primary mr-3 mb-0">
                Filter by Status:
            </label>
            <div class="flex-grow-1">
                <select 
                    name="status" 
                    id="status-filter" 
                    class="form-select border-primary shadow-sm stylish-dropdown w-100" 
                    onchange="this.form.submit()">
                    <option value="" disabled selected hidden>Choose Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>🕒 Pending</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>📦 Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                    <option value="">Clear</option>
                </select>
            </div>
        </div>                      

        <div class="col-md-4 mb-2 d-flex">
            <input 
                type="date" 
                name="start_date" 
                class="form-control mr-2" 
                value="{{ request('start_date') }}" 
                placeholder="Start Date"
            >
            <input 
                type="date" 
                name="end_date" 
                class="form-control" 
                value="{{ request('end_date') }}" 
                placeholder="End Date"
            >
        </div>

        <div class="col-md-1 mb-2">
            <button class="btn btn-outline-success d-flex align-items-center" type="submit">
                <i class="fas fa-sort mr-2"></i>
                <span>Sort</span>
            </button>
        </div>
    </div>
</form>
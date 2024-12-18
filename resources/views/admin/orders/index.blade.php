@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Orders Management</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Reference ID</th>
                <th>User</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->reference_id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->total_amount }}</td>
                    <td>
                        <form id="status-form-{{ $order->id }}" data-order-id="{{ $order->id }}">
                            @csrf
                            @method('PATCH')
                            <div class="d-flex align-items-center">
                                <select name="status" class="form-select stylish-dropdown" id="status-select-{{ $order->id }}">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>🕒 Pending</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>📦 Shipped</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                </select>
                                <button type="button" class="btn btn-outline-primary ml-2 status-update-btn" data-order-id="{{ $order->id }}">Update</button>
                            </div>
                        </form>                        
                    </td>
                    <td>{{ $order->order_date }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">Details</a>
                    </td>
                </tr>
            @empty
                    <tr>
                        <td colspan="6" class="text-center">No orders found.</td>
                    </tr>
            @endforelse
        </tbody>
    </table>

    @include('partials.pagination', ['items' => $orders] )
    
</div>
@endsection
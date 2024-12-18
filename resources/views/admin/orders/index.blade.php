@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Orders Management</h1>

    <div class="alert alert-success d-none" id="success-message"></div>

    <div class="mb-4">
        <div class="row align-items-center">
            <div class="col-md-6 mb-2">
                <div class="input-group">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search by User Name/Email or Reference ID">
                </div>
            </div>

            <div class="col-md-6 d-flex align-items-center mb-2">
                <label for="status-filter" class="form-label fw-bold text-primary mr-3 mb-0">
                    Filter by Status:
                </label>
                <div class="flex-grow-1">
                    <select name="status" id="status-filter" class="form-select border-primary shadow-sm stylish-dropdown w-100">
                        <option value="">Choose Status</option>
                        <option value="pending">🕒 Pending</option>
                        <option value="shipped">📦 Shipped</option>
                        <option value="delivered">✅ Delivered</option>
                        <option value="cancelled">❌ Cancelled</option>
                    </select>
                </div>
            </div>                      

            <div class="col-md-4 mb-2 d-flex">
                <input type="date" name="start_date" class="form-control mr-2">
                <input type="date" name="end_date" class="form-control">
            </div>
        </div>
    </div>

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
        <tbody></tbody>
    </table>

    <nav aria-label="Page navigation">
        <ul class="pagination" id="pagination"></ul>
    </nav>
</div>
@endsection
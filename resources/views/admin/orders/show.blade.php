@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Order Details</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">Back to Orders</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Order #{{ $order->id }}</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>User:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
                    <p><strong>Order Date:</strong> {{ $order->order_date->format('d M Y, h:i A') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong> 
                        <span class="badge badge-{{ 
                            $order->status === 'delivered' ? 'success' : 
                            ($order->status === 'cancelled' ? 'danger' : 
                            ($order->status === 'shipped' ? 'info' : 'warning')) 
                        }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>                    
                    <p><strong>Total Amount:</strong> PKR{{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Shipping Address:</strong></p>
                    <p class="text-muted">{{ $order->shipping_address }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Payment Method:</strong></p>
                    <p class="text-muted">{{ ucfirst($order->payment_method) }}</p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="h5 mb-3">Order Items</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Product</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">PKR{{ number_format($item->price, 2) }}</td>
                        <td class="text-right">PKR{{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
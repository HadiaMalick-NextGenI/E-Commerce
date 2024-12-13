@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Your Order History</h1>

    @if($orders->isEmpty())
        <p>You haven't placed any orders yet.</p>
    @else
        <div class="list-group">
            @foreach($orders as $order)
                <div class="list-group-item border rounded mb-3">
                    <div class="d-flex justify-content-between">
                        <h5>Order #{{ $order->id }}</h5>
                        <span class="badge badge-{{ orderStatusBadge($order->status) }}">{{ ucfirst($order->status) }}</span>
                    </div>
                    <p><strong>Date:</strong> {{ $order->order_date->format('d M Y, h:i A') }}</p>
                    <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                    <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>

                    <button class="btn btn-info btn-sm mt-2" data-toggle="collapse" data-target="#orderItems{{ $order->id }}" aria-expanded="false" aria-controls="orderItems{{ $order->id }}">
                        View Order Items
                    </button>

                    <div id="orderItems{{ $order->id }}" class="collapse mt-3">
                        <h6>Order Items:</h6>
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        @include('partials.pagination', ['items' => $orders])

    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let orders = document.querySelectorAll('.collapse');
        orders.forEach(order => {
            order.classList.remove('show');
        });
    });
</script>
@endpush
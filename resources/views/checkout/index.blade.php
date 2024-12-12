@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0 text-center">Checkout</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="shipping_address" class="font-weight-bold">Shipping Address</label>
                    <textarea 
                        name="shipping_address" 
                        id="shipping_address" 
                        class="form-control" 
                        rows="3" 
                        placeholder="Enter your shipping address" 
                        required></textarea>
                </div>

                <div class="form-group">
                    <label for="payment_method" class="font-weight-bold">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="" disabled selected>Select a payment method</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Cash on Delivery">Cash on Delivery</option>
                    </select>
                </div>

                <div class="card bg-light p-4 mt-4">
                    <h5 class="font-weight-bold">Order Summary</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($cartItems as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                {{ $item->product->name }} 
                                <small class="text-muted">(x{{ $item->quantity }})</small>
                            </span>
                            <span class="text-success font-weight-bold">PKR{{ number_format(getProductPrice($item->product) * $item->quantity, 2) }}</span>
                        </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Subtotal</span>
                            <span class="text-bold">PKR{{ number_format($totalPrice, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Tax</span>
                            <span class="text-muted">{{ $tax * 100}}%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Delivery Charges</span>
                            <span class="text-muted">PKR120</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                            <span>Total</span>
                            <span class="text-primary">PKR{{ number_format($totalAmount, 2) }}</span>
                        </li>
                    </ul>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        Place Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
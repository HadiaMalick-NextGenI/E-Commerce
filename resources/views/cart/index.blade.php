@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Your Cart</h1>

    @if ($cartItems->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col" class="text-center">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item->product->image ? asset('/storage/' . $item->product->image) : asset('/storage/images/product_default.png') }}" 
                                         class="img-thumbnail rounded me-3" 
                                         alt="{{ $item->product->name }}" 
                                         style="width: 80px; height: 80px;">
                                    <div>
                                        <h5 class="mb-1">{{ $item->product->name }}</h5>
                                        <small class="text-muted">{{ $item->product->size }} | {{ ucfirst($item->product->color) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                   
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </form>

                                    <input type="number" class="form-control text-center mx-2" value="{{ $item->quantity }}" min="1" style="width: 60px;" readonly>

                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>PKR {{ number_format($item->product->price, 2) }}</td>
                            <td>PKR {{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('cart.remove', $item->id) }}" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this item?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card bg-light p-4 mt-4">
            <h4 class="mb-3">Order Summary</h4>
            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal:</span>
                <span>PKR {{ number_format($totalPrice, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Tax (10%):</span>
                <span>PKR {{ number_format($tax_amount) }}</span>
            </div>
            <div class="d-flex justify-content-between font-weight-bold mb-3">
                <span>Grand Total:</span>
                <span>PKR {{ number_format($totalPrice + $tax_amount, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('products') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
                <a href="{{ route('checkout.form') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-credit-card"></i> Proceed to Checkout
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h3 class="mb-4">Your cart is empty!</h3>
            <a href="{{ route('products') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-left"></i> Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection
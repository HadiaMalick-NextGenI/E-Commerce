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
                                    
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="decrease-{{ $item->id }}">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                
                                    <input type="number" class="form-control text-center mx-2" value="{{ $item->quantity }}" min="1" style="width: 60px;" id="quantity-{{ $item->id }}" readonly>
                                
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="increase-{{ $item->id }}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                
                            </td>
                            <td id="product-price-{{ $item->id }}" data-price="{{ getProductPrice($item->product) }}">
                                PKR {{ number_format(getProductPrice($item->product), 2) }}
                            </td>
                            <td id="total-price-{{ $item->id }}">
                                PKR {{ number_format(getProductPrice($item->product) * $item->quantity, 2) }}
                            </td>
                            <td class="text-center">
                                <form method="POST" id="remove-cart-item-{{ $item->id }}" action="{{ route('cart.remove', $item->id) }}" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" id="remove-btn-{{ $item->id }}">
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
                <span id="subtotal">PKR {{ number_format($totalPrice, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Tax {{ $tax * 100}}%:</span>
                <span id="tax">PKR {{ number_format($tax_amount) }}</span>
            </div>
            <div class="d-flex justify-content-between font-weight-bold mb-3">
                <span>Grand Total:</span>
                <span id="grand-total">PKR {{ number_format($totalAmount, 2) }}</span>
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
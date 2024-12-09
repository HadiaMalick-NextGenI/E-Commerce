@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body text-center">
        <h4 class="text-success">Order Placed Successfully!</h4>
        <p>Thank you for your purchase. Your order is being processed.</p>
        <a href="{{ url('products') }}" class="btn btn-primary">Return to Shop</a>
    </div>
</div>
@endsection
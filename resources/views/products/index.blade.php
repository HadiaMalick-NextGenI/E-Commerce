@extends('layouts.app')

@include('partials.nav_bar')

@include('partials.alerts')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Our Products</h2>

    @include('partials.filter_form')

    <div class="row">
        @foreach($products as $product)
            @include('partials.product_card', ['product' => $product])
        @endforeach
    </div>    

    @include('partials.pagination', ['items' => $products])

</div>
@endsection
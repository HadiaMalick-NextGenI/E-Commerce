<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/products') }}">E-commerce App</a>
    
    <div class="ml-auto">
        <a href="{{ route('cart.view') }}" class="btn btn-outline-primary position-relative">
            <i class="fas fa-shopping-cart fa-lg"></i>
            @if(session('cartItems') && count(session('cartItems')) > 0)
                <span class="badge badge-danger position-absolute" style="top: -8px; right: -8px;">
                    {{ count(session('cartItems')) }}
                </span>
            @endif
        </a>
    </div>
</nav>
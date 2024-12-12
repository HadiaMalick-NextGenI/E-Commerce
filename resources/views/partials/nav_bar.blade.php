<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/products') }}">E-commerce App</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('wishlist.index') }}" class="btn btn-outline-secondary position-relative mr-2" title="Wishlist">
                        <i class="fas fa-heart fa-lg"></i>
                        @php
                            $wishlistCount = Auth::user() ? Auth::user()->wishlists()->count() : 0;
                        @endphp
                        @if($wishlistCount > 0)
                        <span class="badge badge-danger position-absolute" style="top: -8px; right: -8px;">
                            {{ $wishlistCount }}
                        </span>
                    @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cart.view') }}" class="btn btn-outline-primary position-relative" title="Cart">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        @php
                            $cartCount = Auth::user() ? Auth::user()->cart()->count() : 0;
                        @endphp
                        @if($cartCount > 0)
                            <span class="badge badge-danger position-absolute" style="top: -8px; right: -8px;">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
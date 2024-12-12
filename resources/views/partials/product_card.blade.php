<div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm border rounded position-relative">
        @if ($product->on_sale)
            <div class="position-absolute bg-danger text-white px-2 py-1" style="top: 10px; left: 10px; border-radius: 5px;">
                Sale {{ round($product->discount_percentage) }}%
            </div>
        @endif

        <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
            <img src="{{ $product->image ? asset('/storage/' . $product->image) : asset('/storage/images/product_default.png') }}" 
                 class="card-img-top img-fluid rounded-top" 
                 alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $product->name }}</h5>
            
                <div class="d-flex align-items-center">
                    @if ($product->on_sale)
                        <span class="text-muted mr-2" style="text-decoration: line-through;">
                            PKR{{ number_format($product->price, 0) }}
                        </span>
                        <span class="text-danger font-weight-bold">
                            PKR{{ number_format($product->discounted_price, 0) }}
                        </span>
                    @else
                        <span class="text-primary font-weight-bold">
                            PKR{{ number_format($product->price, 0) }}
                        </span>
                    @endif
                </div>
            
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                        Add to Cart
                    </button>
                </form>
            </div>                                                
        </a>

        <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="wishlist-form">
            @csrf
            <button type="submit" class="btn btn-link p-0 position-absolute" style="top: 10px; right: 10px;">
                <i class="fa{{ in_array($product->id, $wishlistProductIds ?? []) ? 's' : 'r' }} fa-heart text-danger" 
                   style="font-size: 1.5rem;"></i>
            </button>
        </form>
    </div>
</div>
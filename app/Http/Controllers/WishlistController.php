<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function addToWishlist(Product $product){
        $user = auth()->user();
        $user->wishlists()->attach($product->id);

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    public function removeFromWishlist(Product $product)
    {
        $user = auth()->user();
        $user->wishlists()->detach($product->id);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist!',
            ], 200);
        }
        
        return redirect()->back()->with('success', 'Product removed from wishlist!');
    }

    public function viewWishlist()
    {
        $user = auth()->user();
        $products = $user->wishlists;

        return view('wishlist.index', compact('products'));
    }

    public function toggle(Request $request, Product $product){
        $user = Auth::user();

        $exists = $user->wishlists()->where('product_id', $product->id)->exists();

        if($exists){
            $user->wishlists()->detach($product->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from wishlist!',
                'isInWishlist' => false,
                'productId' => $product->id
            ]);
            //return redirect()->back()->with('success', 'Product removed from wishlist!');
        } else {
            $user->wishlists()->attach($product->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to wishlist!',
                'isInWishlist' => true,
                'productId' => $product->id
            ]);
            //return redirect()->back()->with('success', 'Product added to wishlist!');
        }
    }
}

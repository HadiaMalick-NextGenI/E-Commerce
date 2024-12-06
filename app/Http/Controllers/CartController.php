<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId){
        Product::findOrFail($productId);

        Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $productId
            ],
            [
                'quantity' => DB::raw('quantity + ' . $request->input('quantity', 1))
            ]
        );

        return back()->with('success', 'Product added to cart!');
    }

    public function viewCart()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    public function removeFromCart($cartId)
    {
        $cartItem = Cart::findOrFail($cartId);
        $cartItem->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    public function updateQuantity(Request $request, $cartId)
    {
        $cartItem = Cart::findOrFail($cartId);
        $cartItem->update(['quantity' => $request->input('quantity')]);

        return back()->with('success', 'Quantity updated!');
    }
}

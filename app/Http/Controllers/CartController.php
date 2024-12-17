<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId){
        try{
            Product::findOrFail($productId);

            $cart = Cart::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $productId
                ],
                [
                    'quantity' => DB::raw('quantity + ' . $request->input('quantity', 1))
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart' => $cart,
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function viewCart()
    {
        try{
            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
            $totalPrice = calculateTotalAmount($cartItems);

            $tax = config('ecommerce.tax');
            $tax_amount = $totalPrice * $tax;

            $totalAmount = $totalPrice + $tax_amount;

            return view('cart.index', compact('cartItems', 'totalPrice', 'tax_amount', 'tax', 'totalAmount'));
        }catch(Exception $e){
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    public function removeFromCart($cartId)
    {
        try{
            $cartItem = Cart::findOrFail($cartId);
            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully!'
            ]);
            //return back()->with('success', 'Item removed from cart!');
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error!'
            ]);
            //return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    public function updateQuantity(Request $request, $cartId)
    {
        try{
            $cartItem = Cart::findOrFail($cartId);
            $cartItem->update(['quantity' => $request->input('quantity')]);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}

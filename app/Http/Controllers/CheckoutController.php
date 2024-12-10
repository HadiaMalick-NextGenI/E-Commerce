<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
        try{
            $user = Auth::user();
            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

            $totalAmount = calculateTotalAmount($cartItems);

            $tax_amount = $totalAmount * config('ecommerce.tax');
            $delivery_charges = config('ecommerce.delivery_charges');
            $totalAmount = $tax_amount + $totalAmount + $delivery_charges;

            return view('checkout.index', compact('cartItems', 'totalAmount'));
        }catch(Exception $e){
            return redirect()->back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    public function processCheckout(Request $request){
        try{
            $request->validate([
                'shipping_address' => 'required|string',
                'payment_method' => 'required|string',
            ]);
    
            $user = Auth::user();
            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
    
            if ($cartItems->isEmpty()) {
                return redirect()->route('checkout.form')->with('error', 'Your cart is empty.');
            }
    
            $totalAmount = calculateTotalAmount($cartItems);

            $deliveryCharges = config('ecommerce.delivery_charges');
            $tax_amount = $totalAmount * config('ecommerce.tax');

            $totalAmount = $tax_amount + $deliveryCharges + $totalAmount;
    
            $order = Order::create([
                'user_id' => $user->id,
                'order_date' => now(),
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
            ]);
    
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }
    
            Cart::where('user_id', $user->id)->delete();
    
            return redirect()->route('checkout.success')->with('success', 'Order placed successfully!');
        }catch(Exception $e){
            return redirect()->back()-with('error','Error while placing order: '.$e->getMessage());
        }
    }

    public function success(){
        return view('checkout.success');
    }
}

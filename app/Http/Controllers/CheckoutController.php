<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
        try{
            $user = Auth::user();
            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

            $totalPrice = calculateTotalAmount($cartItems);

            $tax = config('ecommerce.tax');
            $tax_amount = $totalPrice * $tax;
            $delivery_charges = config('ecommerce.delivery_charges');
            $totalAmount = $tax_amount + $totalPrice + $delivery_charges;

            return view('checkout.index', compact('cartItems', 'totalAmount', 'totalPrice', 'tax'));
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
                $product = $item->product; 
            
                $price = getProductPrice($product);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
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

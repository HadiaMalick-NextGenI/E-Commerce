<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function history(){
        $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->paginate(5);

        return view('orders.history', compact('orders'));
    }
}

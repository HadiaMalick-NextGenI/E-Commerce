<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){

        $query = Order::query();

        $query = $this->applySearch($query, $request->search);

        $query = $this->filterByStatus($query, $request->status);

        $query = $this->sortByDate($query, $request->start_date, $request->end_date);

        $orders = $query->with('user')->paginate(5);

        return view('admin.orders.index', compact('orders'));
    }

    protected function applySearch($query, $search)
    {
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhere('reference_id', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }

    protected function filterByStatus($query, $status)
    {
        if (!empty($status)) {
            $query->where('status', $status);
        }
        return $query;
    }

    protected function sortByDate($query, $start_date, $end_date)
    {
        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('order_date', [$start_date, $end_date]);
        }
        return $query;
    }

    public function show(Order $order){
        $order->load('user', 'orderItems.product'); 
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order){
        $request->validate([
            'status' => 'required|in:pending,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Order status updated successfully!',
            'status' => $order->status,
        ]);
    }
}

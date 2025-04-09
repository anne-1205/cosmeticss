<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch orders with pagination
        $orders = Order::with('user') // Assuming 'user' is the relationship to the User model
            ->latest()
            ->paginate(10); // Adjust the pagination as needed

        return view('admin.dashboard', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout', [
            'order' => $order,
            'items' => $order->items,
            'total' => $order->total
        ]);
    }
}

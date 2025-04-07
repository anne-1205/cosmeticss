<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // ✅ You need to import the Order model

class OrderController extends Controller
{
    public function index()
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Get orders with error handling
        try {
            $orders = auth()->user()->orders()->latest()->get();
            return view('orders.index', compact('orders'));
        } catch (\Exception $e) {
            // Optionally log the error
            // Log::error($e->getMessage());

            return back()->with('error', 'Unable to retrieve your orders. Please try again later.');
        }

        
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

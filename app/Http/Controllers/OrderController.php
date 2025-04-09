<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display the orders with pagination.
     */
    public function index()
    {
        $orders = Order::with('user') // Assuming 'user' is the relationship to the User model
            ->latest()
            ->paginate(10); // Adjust the pagination as needed

        return view('admin.dashboard', compact('orders'));
    }

    /**
     * Show the details of a specific order.
     */
    public function show(Order $order)
    {
        return response()->json([
            'success' => true,
            'order' => $order->load('user') // Include user details
        ]);
    }

    /**
     * Update the details of a specific order.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
            'shipping_address' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        $order->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully!',
        ]);
    }

    /**
     * Delete a specific order.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Order deleted successfully!');
    }
}
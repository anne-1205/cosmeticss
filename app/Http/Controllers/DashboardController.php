<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product; // Import the Product model

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Fetch orders with pagination
        $categories = Category::all();
        $orders = Order::with('user')->latest()->paginate(10); // Adjust pagination as needed
        $products = Product::with('category')->get(); // Fetch products with their categories

        return view('admin.dashboard', compact('orders', 'categories', 'products'));
    }
}
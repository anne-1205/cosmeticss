<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category; // Don't forget to import this if using categories
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $products = Product::all();
        $categories = Category::all();
       
        return view('admin.dashboard', compact('users', 
        'products', 'categories', ));
    }

    public function showUsers()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }
    public function showProducts()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function showCategories()
    {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function showOrders()
    {
        $orders = Order::with('orderItems.product')->get(); // Eager load order items and products
        return view('admin.orders', compact('orders'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        // other fields...
    ]);

    $product = Product::create([
        'name' => $validated['name'],
        'price' => $validated['price'],
        'is_visible' => true, // Make sure this is set
        // other fields...
    ]);

    return response()->json(['success' => true]);
}
}

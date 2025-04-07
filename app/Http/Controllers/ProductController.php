<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Import the Request class
use App\Models\Product; // Import the Product model

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description ?? ''; 
        $product->price = $request->price;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            // Upload new image and update path
        } elseif ($request->exists('existing_image')) {
            $product->image = $request->input('existing_image');
        } else {
            // No image provided, keep existing or set to null
        }

        $product->save();

        return response()->json(['success' => true, 'message' => 'Product added successfully']);
    }

    public function success()
{
    // Fetch all orders or just display a success message
    $orders = auth()->user()->orders()->latest()->get();
    return view('checkout_success', compact('orders'));
}
}
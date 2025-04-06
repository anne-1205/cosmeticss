<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Fetch all products
        return view('admin.dashboard', compact('products'));
    }

    public function create()
    {
        $categories = Category::all(); // Make sure to import the Category model
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Changed from 'category'
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if the product already exists
        $existingProduct = Product::where('name', $request->name)
            ->where('category_id', $request->category_id) // Changed from 'category'
            ->first();

        if ($existingProduct) {
            return response()->json(['success' => false, 'message' => 'Product already exists!']);
        }

        // Handle image upload
        $imagePath = $request->file('image')->store('products', 'public');

        // Save product to the database
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id, // Changed from 'category'
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return response()->json(['success' => true, 'message' => 'Product added successfully!', 'product' => $product]);
    }

    public function show(Product $product)
    {
        $product->load('images');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('images');
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return response()->json(['success' => true, 'message' => 'Product updated successfully']);
    }

    public function destroy(Product $product)
    {
        // Delete associated images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully.');
    }

    public function destroyProductImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function destroyById($id)
    {
        \Log::info("Delete request received for product ID: $id");

        $product = Product::find($id);

        if ($product) {
            // Delete the product image from storage
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Delete the product from the database
            $product->delete();

            return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Product not found!'], 404);
    }
}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products = Product::all(); // Fetch all products
        $categories = ['Lips', 'Eyes', 'Face']; // Example categories
        return view('admin.dashboard', compact('products', 'categories'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class UserHomeController extends Controller
{
    /**
     * Display the user home page with products and categories.
     */
    public function index()
    {
        $categories = Category::all(); // Fetch all categories
        $products = Product::all(); // Fetch all products
        return view('userHome', compact('categories', 'products'));
    }
}

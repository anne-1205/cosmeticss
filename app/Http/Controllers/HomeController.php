<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Fetch all products from the database
        $categories = Category::all(); // Fetch all categories from the database
        return view('home', compact('products', 'categories'));
    }
}


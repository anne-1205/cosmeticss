<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class UserHomeController extends Controller
{
    /**
     * Display the user home page with active products and categories
     * 
     * @return \Illuminate\View\View
     */
   


public function index()
    {
        $products = Product::all();
        $categories = Category::with('products')->get();
        
        return view('userHome', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    
}
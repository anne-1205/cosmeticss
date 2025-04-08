<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
public function index()
{
    $products = Product::all(); // Fetch all products from the database
    $categories = Category::all(); // Fetch all categories if needed

    return view('admin.dashboard', compact('products', 'categories'));
}
}
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
}

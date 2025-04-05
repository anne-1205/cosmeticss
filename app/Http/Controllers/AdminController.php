<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch all users
        $users = User::all(); // Fetch all users
    return view('admin.dashboard', compact('users'));

        
    }
}
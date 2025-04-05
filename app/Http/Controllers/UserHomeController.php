<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    /**
     * Display the user home page.
     */
    public function index()
    {
        return view('userHome'); // Ensure this view exists in the resources/views directory
    }
}

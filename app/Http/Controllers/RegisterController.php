<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    // Manually implement registration logic as RegistersUsers is no longer available

    // Handle user registration manually
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        event(new Registered($user));

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Registration successful. Please verify your email.']);
    }

    // Add additional methods or customizations as needed
}

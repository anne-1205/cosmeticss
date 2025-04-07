<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // Fail fast if user doesn't exist or is inactive
        if (!$user) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Check account status before password verification
        if ($user->status !== 'active') { // Assuming 'active' is the only allowed status
            Log::warning('Inactive user attempt to login', ['user_id' => $user->id, 'email' => $user->email]);
            return response()->json(['message' => 'Your account is inactive. Please contact administrator.'], 403);
        }

        // Verify password only for active users
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Create token only for active users with valid credentials
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role' => $user->role,
            'user' => $user,
        ]);
    }
}
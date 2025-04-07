<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    use RegistersUsers;

    // Override the registered method to send email verification
    protected function registered(Request $request, User $user)
    {
        // Send email verification after registration
        $user->sendEmailVerificationNotification();
    }

    // Add additional methods or customizations as needed
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Attempt to log the user in.
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');

        // Check if the user exists
        $user = User::where($this->username(), $credentials[$this->username()])->first();

        // Prevent login if the user is inactive
        if (!$user || $user->status !== 'active') {
            return false; // Block login for inactive users
        }

        // Attempt login only for active users
        return $this->guard()->attempt($credentials, $request->filled('remember'));
    }

    /**
     * Handle a failed login attempt.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where($this->username(), $request->{$this->username()})->first();

        if ($user && $user->status !== 'active') {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.inactive')],
            ]);
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     */
    public function username()
    {
        return 'email'; // Assuming email is used for login
    }

    /**
     * Get the guard to be used during authentication.
     */
    protected function guard()
    {
        return auth()->guard();
    }
}
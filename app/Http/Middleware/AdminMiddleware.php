<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has an 'admin' role
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }
        
        // Redirect to home with an error message if not authorized
        return redirect('/')->with('error', 'Unauthorized access');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUserAndCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if either User or Customer is authenticated
        if (Auth::guard('api')->check() || Auth::guard('customer-api')->check()) {
            return $next($request); // Proceed with the request
        }

        // If neither User nor Customer is authenticated, return an error response
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }
}

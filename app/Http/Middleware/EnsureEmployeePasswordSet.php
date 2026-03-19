<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureEmployeePasswordSet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is employee
        if (Auth::check() && Auth::user()->isEmployee()) {
            // Check if employee has set password
            if (!Auth::user()->is_password_set) {
                Auth::logout();
                return redirect()->route('employee.set-password.show', ['email' => Auth::user()->email]);
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IpRestriction;
use App\Models\User;

class EmployeeLoginController extends Controller
{
    /**
     * Show the employee login form
     */
    public function showLoginForm()
    {
        return view('auth.employee-login');
    }

    /**
     * Handle employee login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check IP restriction
        $ipAddress = $request->ip();
        // if (!IpRestriction::isAllowed($ipAddress)) {
        //     return back()->withErrors([
        //         'ip' => 'Access denied from this IP address.',
        //     ]);
        // }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Check if user is employee
            if (!$user->isEmployee()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You do not have employee access.',
                ]);
            }

            // Check if employee has set password
            if (!$user->is_password_set) {
                Auth::logout();
                return redirect()->route('employee.set-password.show', ['email' => $user->email]);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('employee.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log the user out of the application
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

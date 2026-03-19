<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SetPasswordController extends Controller
{
    /**
     * Show the set password form
     */
    public function showSetPasswordForm(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->where('is_password_set', false)->first();

        if (!$user) {
            return redirect()->route('employee.login')->withErrors([
                'email' => 'Invalid or expired link.',
            ]);
        }

        return view('auth.set-password', compact('email'));
    }

    /**
     * Handle setting the password
     */
    public function setPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->where('is_password_set', false)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Invalid or expired link.',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->is_password_set = true;
        $user->save();

        return redirect()->route('employee.login')->with('success', 'Password set successfully. Please login.');
    }
}

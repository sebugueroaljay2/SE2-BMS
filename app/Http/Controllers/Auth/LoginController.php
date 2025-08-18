<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Get selected role from session
        $selectedRole = session('login_role');

        if (!$selectedRole) {
            return back()->withErrors([
                'email' => 'Please select a role before logging in.',
            ])->onlyInput('email');
        }

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();

            // Check if logged-in user has the selected role
            if (!$user->hasRole($selectedRole)) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Invalid account.',
                    'password' => 'Invalid account.',
                ])->onlyInput('email','password');
            }

            // Redirect based on role
            return $selectedRole === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('resident.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }
}
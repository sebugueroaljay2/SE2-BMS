<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleForLogin
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->hasRole($role)) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'You are not authorized to access this section.',
            ]);
        }

        return $next($request);
    }
}
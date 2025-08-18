<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * 
     * 
     */

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check the user's role and redirect accordingly
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard'); // Change to your admin route
            } elseif ($user->hasRole('mis-director')) {
                return redirect()->route('mis-director.dashboard'); // Change to your editor route
            } elseif ($user->hasRole('technician')) {
                return redirect()->route('technician.dashboard'); // Change to your user route
            }
             elseif ($user->hasRole('user')) {
                return redirect()->route('resident.dashboard'); // Change to your user route
            }
        }

        return $next($request);
    }
}

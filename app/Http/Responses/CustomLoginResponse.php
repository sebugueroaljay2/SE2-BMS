<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $expectedRole = session('login_role');

        if ($expectedRole && !Auth::user()->hasRole($expectedRole)) {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'email' => 'Invalid account for this section.',
            ]);
        }

        // Normal redirect kapag tama role
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::user()->hasRole('user')) {
            return redirect()->route('resident.dashboard');
        }

        return redirect('/');
    }
}
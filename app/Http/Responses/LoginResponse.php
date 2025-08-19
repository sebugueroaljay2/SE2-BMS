<?php

namespace App\Http\Responses;

use Spatie\Permission\Models\Role;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return redirect()->intended('/admin/dashboard');
        }

        if ($user->hasRole('user')) {
            return redirect()->intended('/user/dashboard');
        }

        return redirect()->intended('/'); 
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomRegisterController extends Controller
{


    public function store(Request $request)
    {
        $user = app(CreateNewUser::class)->create($request->all());

        Auth::login($user);

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('resident.dashboard');
        }
    }
}

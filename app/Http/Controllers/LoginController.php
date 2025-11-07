<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ...

    protected function authenticated(Request $request, $user)
    {
        if ($user->isSuperAdmin()) {
            return redirect()->route('superadmin.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Jika pengguna tidak terautentikasi atau role tidak sesuai
        if (!$request->user() || $request->user()->role !== $role) {
            // Arahkan ke dashboard berdasarkan role pengguna
            return redirect()->route($request->user()->role . '.dashboard');
        }

        // Lanjutkan ke request berikutnya jika role sesuai
        return $next($request);
    }
}

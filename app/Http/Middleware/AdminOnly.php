<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     * Hanya user dengan is_admin = true yang diizinkan masuk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->is_admin) {
            abort(403, 'Akses ditolak. Hanya administrator yang diizinkan mengakses halaman ini.');
        }

        return $next($request);
    }
}

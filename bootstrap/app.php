<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust proxies (Cloudflare, cPanel reverse proxy, load balancer)
        // Default '*' agar header HTTPS & client IP terdeteksi dengan benar di hosting
        $middleware->trustProxies(
            at: env('TRUSTED_PROXIES', '*')
        );

        // Setelah login, redirect ke dashboard admin
        $middleware->redirectUsersTo(fn ($request) => route('admin.dashboard'));

        // Hanya Midtrans server-to-server webhook yang dikecualikan dari CSRF.
        // /payment/confirm dipanggil dari frontend JS, jadi WAJIB ada CSRF token.
        $middleware->validateCsrfTokens(except: [
            'payment/notification',  // Midtrans server-to-server webhook
            'payment/confirm',       // Midtrans Snap callback dari frontend
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // Menangani sesi / CSRF token kadaluwarsa (419 Page Expired)
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, Request $request) {
            if ($request->is('logout')) {
                auth()->guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('status', 'Anda telah berhasil keluar.');
            }

            return redirect()->back()
                ->withInput($request->except(['password', 'password_confirmation', '_token']))
                ->withErrors(['session_expired' => 'Sesi Anda telah berakhir. Silakan ulangi kembali.']);
        });
    })->create();
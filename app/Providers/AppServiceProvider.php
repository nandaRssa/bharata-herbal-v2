<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            try {
                $host = request()->getHost();
                if ($host !== 'localhost' && $host !== '127.0.0.1') {
                    \Illuminate\Support\Facades\URL::forceScheme('https');
                }
            } catch (\Throwable $e) {
                // If console or no request
            }
        }
    }
}

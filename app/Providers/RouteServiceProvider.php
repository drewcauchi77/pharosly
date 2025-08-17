<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        RateLimiter::for('forgot-password', function (Request $request) {
            $email = (string) $request->get('email');

            return [
                Limit::perMinute(3)->by($request->ip() . ':' . $email),
                Limit::perMinute(6)->by('email:' . $email),
            ];
        });
    }
}

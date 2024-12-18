<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        $allowedDomain = '127.0.0.1';
        $host = parse_url(URL::current(), PHP_URL_HOST);
        if ($host !== $allowedDomain) {
            abort(403, 'Access denied');
        }
    }
}

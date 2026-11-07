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
        // Di belakang proxy Vercel, request terlihat http dari container.
        // Paksa https untuk URL generation agar tidak mixed-content.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

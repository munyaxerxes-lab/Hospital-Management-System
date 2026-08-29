<?php

namespace App\Providers;

use App\Models\cart;
use App\Models\User;
use Illuminate\Support\Facades\View;
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
        if ($this->app->environment('production') || env('VERCEL')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}

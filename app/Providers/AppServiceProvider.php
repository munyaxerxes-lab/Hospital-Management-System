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
        // View::composer('layout.sidebar', function ($view) {
        //     $userId = auth()->check()
        //         ? auth()->id()
        //         : User::firstOrCreate(
        //             ['email' => 'default@example.com'],
        //             ['name' => 'Default User', 'password' => bcrypt('secret')]
        //         )->id;

        //     $cartCount = cart::where('user_id', $userId)->sum('quantity');
        //     $view->with('cartCount', $cartCount);
        // });
    }
}

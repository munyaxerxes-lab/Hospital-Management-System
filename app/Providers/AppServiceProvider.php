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

        // Auto-initialize serverless SQLite database on /tmp if needed
        if (env('VERCEL') && config('database.default') === 'sqlite') {
            $sqlitePath = config('database.connections.sqlite.database');
            if ($sqlitePath === '/tmp/database.sqlite') {
                if (!file_exists($sqlitePath)) {
                    @touch($sqlitePath);
                }
                try {
                    if (!\Illuminate\Support\Facades\Schema::hasTable('users') || !\App\Models\User::where('email', 'admin@medilink.com')->exists()) {
                        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
                        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
                    }
                } catch (\Throwable $e) {
                    // Ignore or log if already seeded by concurrent worker
                }
            }
        }
    }
}

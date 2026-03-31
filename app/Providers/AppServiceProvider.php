<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default string length to avoid "Specified key was too long" error
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
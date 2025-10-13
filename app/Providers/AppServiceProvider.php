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
<<<<<<< HEAD
        //
=======
    // Register the module service provider so modules in /modules are loaded
    $this->app->register(\App\Providers\ModuleServiceProvider::class);
>>>>>>> origin/Spencer-Verses
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
<<<<<<< HEAD
        \Illuminate\Support\Facades\Blade::component('layouts.public', 'public-layout');
=======
        //
>>>>>>> origin/Spencer-Verses
    }
}

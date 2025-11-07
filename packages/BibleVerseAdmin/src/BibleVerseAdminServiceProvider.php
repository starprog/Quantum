<?php

namespace Starprog\BibleVerseAdmin;

use Illuminate\Support\ServiceProvider;
use Starprog\BibleVerseAdmin\Console\Commands\MakeUserAdmin;
use Starprog\BibleVerseAdmin\Http\Middleware\IsAdmin;

class BibleVerseAdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge package config
        $this->mergeConfigFrom(__DIR__.'/../config/bible-verse-admin.php', 'bible-verse-admin');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/admin.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'bible-verse-admin');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeUserAdmin::class,
            ]);

            // Publish configuration
            $this->publishes([
                __DIR__.'/../config/bible-verse-admin.php' => config_path('bible-verse-admin.php'),
            ], 'bible-verse-admin-config');

            // Publish views
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/bible-verse-admin'),
            ], 'bible-verse-admin-views');

            // Publish migrations
            $this->publishes([
                __DIR__.'/Database/Migrations' => database_path('migrations'),
            ], 'bible-verse-admin-migrations');
        }

        // Register middleware
        $this->app['router']->aliasMiddleware('admin', IsAdmin::class);
    }
}

<?php

namespace Modules\BibleVerse\src;

use Illuminate\Support\ServiceProvider;

class BibleVerseServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register the BibleVerseService
        $this->app->singleton('bible-verse', function ($app) {
            return new BibleVerseService();
        });
    }

    public function boot()
    {
        $modulePath = dirname(__DIR__);
        
        // Load routes
        $routePath = $modulePath . '/routes/web.php';
        if (file_exists($routePath)) {
            $this->loadRoutesFrom($routePath);
        }
        
        // Load views
        $viewPath = $modulePath . '/resources/views';
        if (is_dir($viewPath)) {
            $this->loadViewsFrom($viewPath, 'bible-verse');
        }
        
        // Load migrations
        $migrationPath = $modulePath . '/database/migrations';
        if (is_dir($migrationPath)) {
            $this->loadMigrationsFrom($migrationPath);
        }
    }
}
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

        // Register Blade components
        $this->loadViewComponentsAs('bible-verse', [
            'share-buttons' => \View\Components\ShareButtons::class,
        ]);
        
        // Load routes
        $routePath = $modulePath . '/routes/web.php';
        if (file_exists($routePath)) {
            $this->loadRoutesFrom($routePath);
        }
        
        // Load views
        $viewPath = $modulePath . '/resources/views';
        if (is_dir($viewPath)) {
            $this->loadViewsFrom($viewPath, 'bible-verse');
            $this->publishes([
                $viewPath => resource_path('views/vendor/bible-verse'),
            ], 'bible-verse-views');
        }
        
        // Load migrations
        $migrationPath = $modulePath . '/database/migrations';
        if (is_dir($migrationPath)) {
            $this->loadMigrationsFrom($migrationPath);
        }

        // Register Livewire Components
        if (class_exists(\Livewire\Livewire::class)) {
            \Livewire\Livewire::component('bible-verse', \Modules\BibleVerse\src\Http\Livewire\BibleVerse::class);
        }

        // Publish assets
        $this->publishes([
            $modulePath . '/resources/css' => public_path('modules/BibleVerse/css'),
            $modulePath . '/resources/images' => public_path('modules/BibleVerse/images'),
        ], 'bible-verse-assets');
    }
}
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services: register autoloaders and providers for enabled modules.
     */
    public function register(): void
    {
        // Try to load enabled modules from the database and register their autoloads/providers
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('modules')) {
                return;
            }

            $modules = \App\Models\Module::where('enabled', true)->get();

            foreach ($modules as $module) {
                $modulePath = base_path($module->path);
                $moduleFile = $modulePath . '/module.php';
                if (!file_exists($moduleFile)) {
                    continue;
                }

                $config = include $moduleFile;

                // register PSR-4 autoloading dynamically
                if (!empty($config['autoload']['namespace']) && !empty($config['autoload']['path'])) {
                    $autoloadPath = $modulePath . '/' . $config['autoload']['path'];
                    if (is_dir($autoloadPath)) {
                        $loader = require base_path('vendor/autoload.php');
                        if (method_exists($loader, 'addPsr4')) {
                            $loader->addPsr4($config['autoload']['namespace'], $autoloadPath);
                        }
                    }
                }

                // register module-specific provider if provided
                if (!empty($config['provider'])) {
                    // provider class may become available after adding psr4 mapping
                    if (class_exists($config['provider'])) {
                        $this->app->register($config['provider']);
                    }
                }
            }
        } catch (\Exception $e) {
            // don't crash the application if DB isn't ready during early artisan commands
            // Log::debug('Module loader skipped: ' . $e->getMessage());
        }
    }

    /**
     * Bootstrap services: load routes and views for enabled modules.
     */
    public function boot(): void
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('modules')) {
                return;
            }

            $modules = \App\Models\Module::where('enabled', true)->get();

            foreach ($modules as $module) {
                $modulePath = base_path($module->path);
                $moduleFile = $modulePath . '/module.php';
                if (!file_exists($moduleFile)) {
                    continue;
                }

                $config = include $moduleFile;

                if (!empty($config['routes']) && file_exists($modulePath . '/' . $config['routes'])) {
                    $this->loadRoutesFrom($modulePath . '/' . $config['routes']);
                }

                if (!empty($config['views']) && is_dir($modulePath . '/' . $config['views'])) {
                    $this->loadViewsFrom($modulePath . '/' . $config['views'], $config['name']);
                }
            }
        } catch (\Exception $e) {
            // ignore
        }
    }
}

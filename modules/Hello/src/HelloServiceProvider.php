<?php

namespace Modules\Hello;

use Illuminate\Support\ServiceProvider;

class HelloServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // module-specific bindings
    }

    public function boot(): void
    {
        // module-specific boot actions
    }
}

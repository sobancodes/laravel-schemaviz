<?php

namespace Soban\LaravelErBlueprint\Providers;

use Illuminate\Support\ServiceProvider;

class ErBlueprintServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/columns.php',
            'columns',
        );
    }

    public function boot(): void {}
}
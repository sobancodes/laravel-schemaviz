<?php

namespace Soban\LaravelErBlueprint\Providers;

use Illuminate\Support\ServiceProvider;
use Soban\LaravelErBlueprint\Commands\GenerateSchemavizCommand;

class SchemaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/columns.php',
            'columns',
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateSchemavizCommand::class,
            ]);
        }
    }
}
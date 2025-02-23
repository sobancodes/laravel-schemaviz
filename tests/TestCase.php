<?php

namespace Soban\LaravelErBlueprint\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;
use Soban\LaravelErBlueprint\Providers\ErBlueprintServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Load package service provider.
     *
     * @param  Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            ErBlueprintServiceProvider::class,
        ];
    }
}
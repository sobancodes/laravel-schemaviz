<?php

namespace Soban\LaravelErBlueprint\Commands;

use Illuminate\Console\Command;
use Soban\LaravelErBlueprint\Renderers\MermaidRenderer;

class GenerateSchemavizCommand extends Command
{
    protected $signature = 'generate:schemaviz';

    protected $description = 'Generates the schema from migrations';

    public function handle(): void
    {
        app(MermaidRenderer::class)->build(getMigrationPaths());
    }
}

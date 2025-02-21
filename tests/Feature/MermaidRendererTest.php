<?php

declare(strict_types=1);

use Soban\LaravelErBlueprint\Renderers\MermaidRenderer;

it('can generate mermaid diagram', function () {
    dd(app(MermaidRenderer::class)->build());
});
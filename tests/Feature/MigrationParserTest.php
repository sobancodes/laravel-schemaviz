<?php

declare(strict_types=1);

todo('migration parser', function () {
    dd(
        app(\Soban\LaravelErBlueprint\Renderers\MermaidRenderer::class)->build(
        ),
    );
});
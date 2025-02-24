<?php

declare(strict_types=1);

use Soban\LaravelErBlueprint\Extractors\MigrationExtractor;

todo('migration parser');

it('example test', function () {
    $output = app(MigrationExtractor::class)->comment(
        getMigrationContent('create_users_table'),
    );
    dd($output);
});
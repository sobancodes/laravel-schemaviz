<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Tests\Feature;

use Soban\LaravelErBlueprint\Parsers\MigrationParser;
use SplFileInfo;

it('can fetch migration files', function () {
    expect(fetchMigrations())
        ->toBeArray()
        ->and(
            fetchMigrations(['create_users_table', 'create_posts_table']),
        )->toHaveCount(2)
        ->and(
            fetchMigrations('create_users_table'),
        )->toBeInstanceOf(SplFileInfo::class);
});

it('can extract table name', function () {
    expect(
        app(MigrationParser::class)->tableName(
            getMigrationContent('create_users_table'),
        ),
    )->toBe('users');
});

it('can extract column name', function () {
    expect(
        app(MigrationParser::class)->columnType(
            getMigrationContent('create_users_table'),
        ),
    )->toBeArray();
});

it('can extract data type', function () {
    expect(
        app(MigrationParser::class)->columnName(
            getMigrationContent('create_users_table'),
        ),
    )->toBeArray();
});

it('can extract foreign keys', function () {
    expect(
        app(MigrationParser::class)->foreignKeys(
            getMigrationContent('create_posts_table'),
        ),
    )->toBeArray()->toHaveCount(1);
});

todo('can extract foreign keys with unsignedBigInteger datatype');
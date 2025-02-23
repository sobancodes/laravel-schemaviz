<?php

declare(strict_types=1);


use Soban\LaravelErBlueprint\Extractors\MigrationExtractor;
use Soban\LaravelErBlueprint\Parsers\MigrationParser;

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
        app(MigrationExtractor::class)->tableName(
            getMigrationContent('create_users_table'),
        ),
    )->toBe('users');
});

it('can extract column name', function () {
    expect(
        app(MigrationExtractor::class)->columnType(
            getMigrationContent('create_users_table'),
        ),
    )->toBeArray();
});

it('can extract data type', function () {
    expect(
        app(MigrationExtractor::class)->columnName(
            getMigrationContent('create_users_table'),
        ),
    )->toBeArray();
});

todo('can extract foreign keys with unsignedBigInteger datatype');

it('can parse a migration file', function () {
    expect(
        app(MigrationParser::class)->parse(
            fetchMigrations('create_posts_table'),
        ),
    )->toBeArray()->toHaveCount(3);
});


// what happens if the column is extracted, but it does not exist in columns mapping?
// it could be that it is not a valid type / method so it does not exist in the column mapping config,
// or it is invalid so it naturally does not exist in the column mapping
// if the method is invalid it would throw an error while running the migration so it is highly unlikely
// so if the method exists that is not mappable through column mapping, we should simply add it as it is
// so the test should not fail in that case

it(
    'should return the method name if it is not found in column mapping',
    function () {
        expect(getSqlEquivalentType('columnTypeThatDoesNotExist'))
            ->toBe('columnTypeThatDoesNotExist');
    },
);

it(
    'can map laravel migration methods to valid sql column data types',
    function (string $key): void {
        $sqlEquivalentColumns = [
            'string'     => 'VARCHAR',
            'foreign_id' => 'UNSIGNED BIGINT',
            'float'      => 'FLOAT',
        ];

        expect(getSqlEquivalentType($key))->toBe($sqlEquivalentColumns[$key]);
    },
)->with([
    [
        'string',
        'foreign_id',
        'float',
    ],
]);
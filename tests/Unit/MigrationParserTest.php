<?php

declare(strict_types=1);


use Soban\LaravelErBlueprint\Extractors\MigrationExtractor;
use Soban\LaravelErBlueprint\Models\Column;
use Soban\LaravelErBlueprint\Models\Table;

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

it('can build instance of table class from a migration', function () {
    $migration = migration();
    expect(
        app(MigrationExtractor::class)
            ->getTable($migration),
    )->toBeInstanceOf(Table::class);
});

it('can extract table name', function () {
    $migration = migration();
    $table = app(MigrationExtractor::class)
        ->getTable($migration);
    expect($table->name)->toBe('users');
});

it('can extract all columns from a migration', function () {
    $columns = app(MigrationExtractor::class)
        ->getMigrationColumns(migration());

    expect($columns)->not
        ->toBeEmpty()
        ->and($columns)->toBeArray();

    foreach ($columns as $column) {
        expect($column)->toBeInstanceOf(Column::class);
    }
});

it('can extract column name', function () {
    $columns = app(MigrationExtractor::class)
        ->getMigrationColumns(column());

    expect($columns)
        ->toBeArray()
        ->and($columns)->toHaveCount(1)
        ->and($columns[0])->toBeInstanceOf(Column::class);
});

it('can extract laravel column type from a migration column', function () {
    expect(extractColumn())
        ->toBeInstanceOf(Column::class)
        ->and(extractColumn())->getType()->toBe('string');
});

it('can extract sql column type from a migration column', function () {
    expect(extractColumn())
        ->getSqlEquivalentType()->toBe('VARCHAR')
        ->and(extractColumn('foreignId'))
        ->getSqlEquivalentType()->toBe('UNSIGNED BIGINT');
});

it('can extract enum type and params from a migration column', function () {
    expect(extractColumn('enum'))
        ->getType()->toBe('enum')
        ->getParams()->toBe("[18, 20]");
});

todo('can parse a migration file', function () {});


// what happens if the column is extracted, but it does not exist in columns mapping?
// it could be that it is not a valid type / method so it does not exist in the column mapping config,
// or it is invalid so it naturally does not exist in the column mapping
// if the method is invalid it would throw an error while running the migration so it is highly unlikely
// so if the method exists that is not mappable through column mapping, we should simply add it as it is
// so the test should not fail in that case

todo(
    'should return the method name if it is not found in column mapping',
    function () {
        expect(Column::getSqlEquivalentType('columnTypeThatDoesNotExist'))
            ->toBe('columnTypeThatDoesNotExist');
    },
);

todo(
    'can map laravel migration methods to valid sql column data types',
    function (string $key): void {
        $sqlEquivalentColumns = [
            'string'     => 'VARCHAR',
            'foreign_id' => 'UNSIGNED BIGINT',
            'float'      => 'FLOAT',
        ];

        expect(Column::getSqlEquivalentType($key))->toBe(
            $sqlEquivalentColumns[$key],
        );
    },
)->with([
    [
        'string',
        'foreign_id',
        'float',
    ],
]);
<?php

declare(strict_types=1);


use Soban\LaravelErBlueprint\Models\Column;

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

todo('can extract table name', function () {});

todo('can extract column name', function () {});

todo('can extract data type', function () {});

todo('can extract foreign keys with unsignedBigInteger datatype');

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
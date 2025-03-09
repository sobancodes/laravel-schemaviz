<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

// pest()->extend(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

use Soban\LaravelErBlueprint\Extractors\MigrationExtractor;
use Soban\LaravelErBlueprint\Models\Column;
use Soban\LaravelErBlueprint\Tests\TestCase;

pest()->extend(TestCase::class)->in(__DIR__);

function migration(): string
{
    return <<<'MIGRATION'
        Schema::create('users', function (Blueprint $table) {
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->decimal('balance')->default('0.00')->comment('Account balance');
        });
        MIGRATION;
}

function column(string $type = 'string'): string
{
    if ($type === 'enum') {
        return "\$table->enum('age', [18, 20])->nullable()->index()->unique()->default(18)->comment('Age of birth');";
    }

    return "\$table->{$type}('name', 255);";
}

function extractColumn(string $type = 'string'): Column
{
    $column = app(MigrationExtractor::class)
        ->getMigrationColumns(column($type));

    return $column[0];
}
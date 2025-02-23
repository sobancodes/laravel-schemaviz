<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

if (!function_exists('fetchMigrations')) {
    function fetchMigrations(null|string|array $filtered = null,
    ): array|SplFileInfo {
        $migrations = File::files('./tests/database/migrations');

        if ($filtered === null) {
            return $migrations;
        }

        if (gettype($filtered) === 'string') {
            return collect($migrations)->first(
                fn(string $migration): bool
                    => str_contains(
                    $migration,
                    $filtered,
                ),
            );
        }

        if (gettype($filtered) === 'array') {
            return collect($migrations)->filter(fn(string $file)
                => str_contains($file, 'create_users_table')
                || str_contains(
                    $file,
                    'create_posts_table',
                ),
            )->toArray();
        }

        return $migrations;
    }
}

if (!function_exists('getMigrationContent')) {
    function getMigrationContent(string $fileName): ?string
    {
        return File::get(fetchMigrations($fileName)->getRealPath());
    }
}

if (!function_exists('getSqlEquivalentType')) {
    function getSqlEquivalentType(string $laravelType): string
    {
        $type = config('columns.map');
        return isset($type[$laravelType])
            ? $type[$laravelType]
            : $laravelType;
    }
}
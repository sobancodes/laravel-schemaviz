<?php

declare(strict_types=1);

if (!function_exists('getMigrationPaths')) {
    function getMigrationPaths(null|string|array $filtered = null): array
    {
        $migrationPaths = database_path('migrations');
        $migrationPaths = File::glob("$migrationPaths/*.php");

        if ($filtered === null) {
            return $migrationPaths;
        }

        if (gettype($filtered) === 'string') {
            return [
                collect($migrationPaths)->first(
                    fn(string $migrationPath): bool
                        => str_contains(
                        $migrationPath,
                        $filtered,
                    ),
                ),
            ];
        }

        if (gettype($filtered) === 'array') {
            return collect($migrationPaths)->filter(fn(string $migrationPath)
                => \in_array(
                $migrationPath,
                \array_map(
                    fn($string) => str_contains($migrationPath, $string),
                    $filtered,
                ),
            ),
            )->toArray();
        }

        return $migrationPaths;
    }
}

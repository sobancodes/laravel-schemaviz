<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Parsers;

class MigrationParser
{
    public function parse(string $file): void
    {

    }

    public function tableName(string $content): ?string
    {
        if (preg_match('/Schema::create\(\'(\w+)\'/', $content, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function columnType(string $content): ?array
    {
        if (preg_match_all('/\$table->(\w+)\(\'(\w+)\'/', $content, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function columnName(string $content): ?array
    {
        if (preg_match_all('/\$table->(\w+)\(\'(\w+)\'/', $content, $matches)) {
            return $matches[2];
        }

        return null;
    }
}
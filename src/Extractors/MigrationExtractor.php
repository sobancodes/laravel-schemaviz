<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Extractors;

use Soban\LaravelErBlueprint\Contracts\MigrationExtractorInterface;

class MigrationExtractor implements MigrationExtractorInterface
{
    private array $patterns
        = [
            'table'     => '/Schema::create\(\'(\w+)\'/',
            'column'    => '/\$table->(\w+)\(\'(\w+)\'/',
            'foreignId' => '/\$table->foreignId\(\'(\w+)\'/',
        ];

    public function tableName(string $content): ?string
    {
        if (preg_match($this->patterns['table'], $content, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function columnType(string $content): ?array
    {
        if (preg_match_all($this->patterns['column'], $content, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function columnName(string $content): ?array
    {
        if (preg_match_all($this->patterns['column'], $content, $matches)) {
            return $matches[2];
        }

        return null;
    }

    public function foreignKeys(string $content): ?array
    {
        if (preg_match_all($this->patterns['foreignId'], $content, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Contracts;

interface MigrationExtractorInterface
{
    public function getTable(string $content);

    public function getAllColumns(string $content): array;

    public function getColumnByName(
        string $content,
        string $columnName,
    ): string;
}
<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Contracts;

use Soban\LaravelErBlueprint\Models\Column;

interface MigrationExtractorInterface
{
    public function getTable(string $content);

    public function getAllColumns(string $content): array;

    public function getColumnByName(
        string $content,
        string $columnName,
    ): ?Column;
}
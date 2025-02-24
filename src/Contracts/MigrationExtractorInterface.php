<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Contracts;

use Soban\LaravelErBlueprint\Models\Column;
use Soban\LaravelErBlueprint\Models\Table;

interface MigrationExtractorInterface
{
    public function getTable(string $content): Table;

    public function getAllColumns(string $content): array;

    public function getColumnByName(
        string $content,
        string $columnName,
    ): ?Column;
}
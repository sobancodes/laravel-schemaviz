<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Contracts;

interface MigrationExtractorInterface
{
    public function extractAll(string $content): array;

    public function tableName(string $content): ?string;

    public function columnType(string $content): ?array;

    public function columnName(string $content): ?array;
}
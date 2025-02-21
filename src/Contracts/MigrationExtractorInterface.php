<?php

declare(strict_types=1);

namespace Soban\LaravelPlayground\Contracts;

interface MigrationExtractorInterface
{
    public function tableName(string $content): ?string;

    public function columnType(string $content): ?array;

    public function columnName(string $content): ?array;

    public function foreignKeys(string $content): ?array;
}
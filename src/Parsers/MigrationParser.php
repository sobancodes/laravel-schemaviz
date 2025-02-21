<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Parsers;

use Illuminate\Support\Facades\File;

class MigrationParser
{
    public function parse(\SplFileInfo $file): ?array
    {
        if (!($content = File::get($file->getRealPath()))) {
            return null;
        }

        $tableName = $this->tableName($content);
        $columnTypes = $this->columnType($content);
        $columnName = $this->columnName($content);

        return [
            'table_name'   => $tableName,
            'column_types' => $columnTypes,
            'column_name'  => $columnName,
        ];
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

    public function foreignKeys(string $content): ?array
    {
        if (preg_match_all(
            '/\$table->foreignId\(\'(\w+)\'/',
            $content,
            $matches,
        )
        ) {
            return $matches[1];
        }

        return null;
    }
}
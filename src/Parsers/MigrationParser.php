<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Parsers;

use Illuminate\Support\Facades\File;
use Soban\LaravelErBlueprint\Contracts\ParserInterface;
use Soban\LaravelErBlueprint\Extractors\MigrationExtractor;

class MigrationParser implements ParserInterface
{
    public function parse(\SplFileInfo $file): ?array
    {
        if (!($content = File::get($file->getRealPath()))) {
            return null;
        }

        $extractor = new MigrationExtractor();

        return [
            'table_name'   => $extractor->tableName($content),
            'column_types' => $extractor->columnType($content),
            'column_name'  => $extractor->columnName($content),
        ];
    }
}
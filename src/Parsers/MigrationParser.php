<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Parsers;

use Illuminate\Support\Facades\File;
use Soban\LaravelErBlueprint\Contracts\ParserInterface;
use Soban\LaravelErBlueprint\Extractors\MigrationExtractor;
use Soban\LaravelErBlueprint\Models\Table;

class MigrationParser implements ParserInterface
{
    public static function parse(string $filePath): ?Table
    {
        if (!($content = File::get($filePath))) {
            return null;
        }

        return app(MigrationExtractor::class)->getTable($content);
    }
}
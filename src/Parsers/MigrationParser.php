<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Parsers;

use Illuminate\Support\Facades\File;
use Soban\LaravelErBlueprint\Contracts\ParserInterface;
use Soban\LaravelErBlueprint\Extractors\MigrationExtractor;
use Soban\LaravelErBlueprint\Models\Table;

class MigrationParser implements ParserInterface
{
    public function parse(\SplFileInfo $file): ?Table
    {
        if (!($content = File::get($file->getRealPath()))) {
            return null;
        }

        return app(MigrationExtractor::class)->getTable($content);
    }
}
<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Extractors;

use Soban\LaravelErBlueprint\Contracts\MigrationCacheInterface;
use Soban\LaravelErBlueprint\Contracts\MigrationExtractorInterface;
use Soban\LaravelErBlueprint\Models\Column;
use Soban\LaravelErBlueprint\Models\Table;
use Soban\LaravelErBlueprint\Traits\CacheExtractedMigration;
use Soban\LaravelErBlueprint\Traits\MigrationExtractorTrait;

use function in_array;

class MigrationExtractor
    implements MigrationExtractorInterface, MigrationCacheInterface
{
    use MigrationExtractorTrait;
    use CacheExtractedMigration;

    protected const patterns
        = [
            'table'    => '/Schema::create\(\'(\w+)\'/',
            'column'   => '/\$table->(\w+)\(\'(\w+)\'(?:,\s*([^\)]+))?\)(.*?);/',
            'nullable' => '/->nullable\(\)/',
            'index'    => '/->index\(\)/',
            'unique'   => '/->unique\(\)/',
            'default'  => '/->default\(\'?(.*?)\'?\)/',
            'comment'  => '/->comment\(\'?(.*?)\'?\)/',
        ];

    public function getTable(string $content): Table
    {
        return new Table(
            $this->tableName($content),
            $this->getAllColumns($content),
        );
    }

    public function getAllColumns(string $content): array
    {
        $columns = [];

        $rawColumns = $this->getCachedOrRunRawExtractor(
            $content,
            'column',
            false,
        );

        foreach ($rawColumns as $column) {
            $columns[] = $this->getColumn($column);
        }

        return $columns;
    }

    public function getColumn(array $column): Column
    {
        return new Column(
            $this->columnName($column),
            $this->columnType($column),
            $this->isNullable($column),
            $this->isIndex($column),
            $this->isUnique($column),
            null,
            $this->columnDefault($column),
            $this->columnComment($column),
        );
    }

    public function getColumnByName(
        string $content,
        string $columnName,
    ): ?Column
    {
        $rawColumns = $this->getCachedOrRunRawExtractor(
            $content,
            'column',
            false,
        );

        foreach ($rawColumns as $column) {
            if (!in_array($columnName, $column)) {
                return $this->getColumn($column);
            }
        }

        return null;
    }

    private function tableName(string $content): string
    {
        return $this->getCachedOrRunRawExtractor($content, 'table');
    }

    private function columnType(
        array $arg,
        bool $receivesColumn = true,
    ): string|array
    {
        if ($receivesColumn) {
            return $arg[1];
        }

        return $this->extractFromRawByIndex($arg, 1);
    }

    private function columnName(
        array $arg,
        bool $receivesColumn = true,
    ): string|array
    {
        if ($receivesColumn) {
            return $arg[2];
        }

        return $this->extractFromRawByIndex($arg, 2);
    }

    public function isNullable(
        array $arg,
        bool $receivesColumn = true,
    ): null|bool|string|array
    {
        return $this->getModifiers(
            $arg,
            'nullable',
            0,
            $receivesColumn,
        );
    }

    private function isIndex(
        array $arg,
        bool $receivesColumn = true,
    ): null|bool|string|array
    {
        return $this->getModifiers(
            $arg,
            'index',
            0,
            $receivesColumn,
        );
    }

    private function isUnique(
        array $arg,
        bool $receivesColumn = true,
    ): null|bool|string|array
    {
        return $this->getModifiers(
            $arg,
            'unique',
            0,
            $receivesColumn,
        );
    }

    private function columnDefault(
        array $arg,
        bool $receivesColumn = true,
    ): null|bool|string|array
    {
        return $this->getModifiers(
            $arg,
            'default',
            1,
            $receivesColumn,
            false,
        );
    }

    private function columnComment(
        array $arg,
        bool $receivesColumn = true,
    ): null|bool|string|array
    {
        return $this->getModifiers(
            $arg,
            'comment',
            1,
            $receivesColumn,
            false,
        );
    }

}
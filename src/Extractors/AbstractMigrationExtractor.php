<?php

namespace Soban\LaravelErBlueprint\Extractors;

use Soban\LaravelErBlueprint\Contracts\MigrationCacheInterface;
use Soban\LaravelErBlueprint\Contracts\MigrationExtractorInterface;
use Soban\LaravelErBlueprint\Models\Column;
use Soban\LaravelErBlueprint\Models\Table;
use Soban\LaravelErBlueprint\Traits\SingletonPatternFinder;

abstract class AbstractMigrationExtractor
    implements MigrationExtractorInterface, MigrationCacheInterface
{
    use SingletonPatternFinder;

    public function getTable(string $content): Table
    {
        return new Table(
            $this->tableName($content),
            $this->getMigrationColumns($content),
        );
    }

    public function getMigrationColumns(string $content): array
    {
        $columns = [];

        $rawColumns = $this->getResolvedPatternOrBuild(
            $content,
            'column',
            false,
        );

        foreach ($rawColumns as $column) {
            $columns[] = $this->getColumn($column);
        }

        return $columns;
    }

    protected function getColumn(array $column): Column
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

    abstract protected function extractAttributes(
        string $content,
        string $forPattern,
        bool $matchSingle = true,
    );

    public function getColumnByName(
        string $content,
        string $columnName,
    ): ?Column {
        $rawColumns = $this->getResolvedPatternOrBuild(
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

    abstract protected function tableName(string $content): string;

    abstract protected function columnType(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): string|array;

    abstract protected function columnName(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): string|array;

    abstract protected function isNullable(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): null|bool|string|array;

    abstract protected function isIndex(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): null|bool|string|array;

    abstract protected function isUnique(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): null|bool|string|array;

    abstract protected function columnDefault(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): null|bool|string|array;

    abstract protected function columnComment(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): null|bool|string|array;
}
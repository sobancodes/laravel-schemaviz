<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Extractors;

use Soban\LaravelErBlueprint\Traits\PatternMatcher;

use function array_map;

class MigrationExtractor extends AbstractMigrationExtractor
{
    use PatternMatcher;

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

    protected function extractAttributes(
        string $content,
        string $forPattern,
        bool $matchSingle = true,
    ): array|string|null {
        return $this->matchPatterns($content, $forPattern, $matchSingle);
    }

    protected function tableName(string $content): string
    {
        return $this->getResolvedPatternOrBuild($content, 'table');
    }

    protected function columnType(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): string|array
    {
        if ($retrieveSingleColumn) {
            return $arg[1];
        }

        return $this->getSubAttributes($arg, 1);
    }


    protected function columnParam(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): string|array {
        if ($retrieveSingleColumn) {
            return $arg[3];
        }

        return $this->getSubAttributes($arg, 1);
    }

    protected function columnName(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): string|array
    {
        if ($retrieveSingleColumn) {
            return $arg[2];
        }

        return $this->getSubAttributes($arg, 2);
    }

    public function isNullable(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): null|bool|string|array
    {
        return $this->getModifiers(
            $arg,
            'nullable',
            0,
            $retrieveSingleColumn,
        );
    }

    protected function isIndex(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): null|bool|string|array
    {
        return $this->getModifiers(
            $arg,
            'index',
            0,
            $retrieveSingleColumn,
        );
    }

    protected function isUnique(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): null|bool|string|array
    {
        return $this->getModifiers(
            $arg,
            'unique',
            0,
            $retrieveSingleColumn,
        );
    }

    protected function columnDefault(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): null|bool|string|array
    {
        return $this->getModifiers(
            $arg,
            'default',
            1,
            $retrieveSingleColumn,
            false,
        );
    }

    protected function columnComment(
        array $arg,
        bool $retrieveSingleColumn = true,
    ): null|bool|string|array
    {
        return $this->getModifiers(
            $arg,
            'comment',
            1,
            $retrieveSingleColumn,
            false,
        );
    }

    private function getModifiers(
        array $arg,
        string $forPattern,
        int $matchAt,
        bool $retrieveSingleColumn,
        bool $boolOrValue = true,
    ): null|bool|string|array {
        if ($retrieveSingleColumn) {
            return $this->getModifier(
                $arg[4],
                $forPattern,
                $matchAt,
                $boolOrValue,
            );
        }

        return array_map(
            function (string $modifier) use (
                $forPattern,
                $matchAt,
                $boolOrValue,
            ) {
                $this->getModifier(
                    $modifier,
                    $forPattern,
                    $matchAt,
                    $boolOrValue,
                );
            },
            $this->getSubAttributes($arg, 4),
        );
    }

    private function getModifier(
        string $modifier,
        string $forPattern,
        int $matchAt,
        bool $boolOrValue,
    ): null|bool|string {
        $match = $this->matchSingle(
            $modifier,
            $forPattern,
            $matchAt,
        );

        return $boolOrValue ? (bool)$match : $match;
    }

    private function getSubAttributes(
        array $migrationMetaData,
        int $at,
    ): array {
        return \array_map(
            fn(array $column) => $column[$at],
            $migrationMetaData,
        );
    }

}
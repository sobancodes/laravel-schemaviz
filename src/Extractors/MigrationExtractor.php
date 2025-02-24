<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Extractors;

use Soban\LaravelErBBlueprint\Traits\CacheExtractedMigration;
use Soban\LaravelErBBlueprint\Traits\MigrationExtractorTrait;
use Soban\LaravelErBlueprint\Contracts\MigrationCacheInterface;
use Soban\LaravelErBlueprint\Contracts\MigrationExtractorInterface;

class MigrationExtractor
    implements MigrationExtractorInterface, MigrationCacheInterface
{
    use MigrationExtractorTrait;
    use CacheExtractedMigration;

    private const patterns
        = [
            'table'    => '/Schema::create\(\'(\w+)\'/',
            'column'   => '/\$table->(\w+)\(\'(\w+)\'(?:,\s*([^\)]+))?\)(.*?);/',
            'nullable' => '/->nullable\(\)/',
            'index'    => '/->index\(\)/',
            'unique'   => '/->unique\(\)/',
            'default'  => '/->default\(\'?(.*?)\'?\)/',
            'comment'  => '/->comment\(\'?(.*?)\'?\)/',
        ];

    public function getTable(string $content) {}

    public function getAllColumns(string $content): array
    {
        return [];
    }

    public function getColumnByName(
        string $content,
        string $columnName,
    ): string {
        return '';
    }

    private function tableName(string $content): string
    {
        return $this->getCached($content, 'table');
    }

    private function columnType(string $content): array
    {
        return $this->getMigrationDataByIndex(
            $this->getCached($content, 'column', false),
            1,
        );
    }

    private function columnName(string $content): array
    {
        return $this->getMigrationDataByIndex(
            $this->getCached($content, 'column', false),
            2,
        );
    }

    private function isNullable(string $content): array
    {
        return $this->getModifiers(
            $this->getMigrationDataByIndex(
                $this->getCached($content, 'column', false),
                4,
            ),
            'nullable',
            0,
        );
    }

    private function isIndex(string $content): array
    {
        return $this->getModifiers(
            $this->getMigrationDataByIndex(
                $this->getCached($content, 'column', false),
                4,
            ),
            'index',
            0,
        );
    }

    private function isUnique(string $content): array
    {
        return $this->getModifiers(
            $this->getMigrationDataByIndex(
                $this->getCached($content, 'column', false),
                4,
            ),
            'unique',
            0,
        );
    }

    private function columnDefault(string $content): array
    {
        return $this->getModifiers(
            $this->getMigrationDataByIndex(
                $this->getCached($content, 'column', false),
                4,
            ),
            'default',
            1,
            false,
        );
    }

    private function columnComment(string $content): array
    {
        return $this->getModifiers(
            $this->getMigrationDataByIndex(
                $this->getCached($content, 'column', false),
                4,
            ),
            'comment',
            1,
            false,
        );
    }

}
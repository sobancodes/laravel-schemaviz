<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Extractors;

use Soban\LaravelErBlueprint\Contracts\MigrationExtractorInterface;

class MigrationExtractor implements MigrationExtractorInterface
{
    private const patterns
        = [
            'table'  => '/Schema::create\(\'(\w+)\'/',
            'column' => '/\$table->(\w+)\(\'(\w+)\'(?:,\s*(\d+))?\)(.*?);/',
        ];

    private array $cached = [];

    public function extractAll(string $content): array
    {
        return [];
    }

    private function matchPatterns(
        string $content,
        string $forPattern,
        bool $matchSingle = true,
    ): string|array {
        if ($matchSingle) {
            return $this->matchSingle($content, $forPattern);
        }

        return $this->matchAll($content, $forPattern);
    }

    private function matchSingle(
        string $content,
        string $forPattern,
    ): string {
        if (preg_match(self::patterns[$forPattern], $content, $matches)) {
            return $matches[1];
        }

        return "unknown_{$forPattern}";
    }

    private function matchAll($content, string $forPattern): array
    {
        \preg_match_all(
            self::patterns[$forPattern],
            $content,
            $matches,
            PREG_SET_ORDER,
        );

        return $matches;
    }

    private function getCached(
        string $content,
        string $forPattern,
        bool $matchSingle = true,
    ): string|array {
        if (isset($this->cached[$forPattern])) {
            return $this->cached[$forPattern];
        }

        return $this->cached[$forPattern] = $this->matchPatterns(
            $content,
            $forPattern,
            $matchSingle,
        );
    }

    public function tableName(string $content): string
    {
        return $this->getCached($content, 'table');
    }

    public function columnType(string $content): array
    {
        return $this->getCached($content, 'column', false);
    }

    public function columnName(string $content): array
    {
        return $this->getCached($content, 'column', false);
    }

}
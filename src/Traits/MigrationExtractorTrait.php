<?php

namespace Soban\LaravelErBlueprint\Traits;

trait MigrationExtractorTrait
{
    private function matchPatterns(
        string $content,
        string $forPattern,
        bool $matchSingle = true,
    ): null|string|array {
        if ($matchSingle) {
            return $this->matchSingle($content, $forPattern);
        }

        return $this->matchAll($content, $forPattern);
    }

    private function matchSingle(
        string $content,
        string $forPattern,
        int $at = 1,
    ): ?string {
        if (preg_match(self::patterns[$forPattern], $content, $matches)) {
            return $matches[$at];
        }

        return null;
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

    protected function extractFromRawByIndex(
        array $migrationMetaData,
        int $at,
    ): array {
        return \array_map(
            fn(array $column) => $column[$at],
            $migrationMetaData,
        );
    }

    private function getModifiers(
        array $arg,
        string $forPattern,
        int $matchAt,
        bool $singleColumn,
        bool $getTruthyOrValue = true,
    ): null|bool|string|array {
        if ($singleColumn) {
            return $this->getModifier(
                $arg[4],
                $forPattern,
                $matchAt,
                $getTruthyOrValue,
            );
        }

        return \array_map(
            function (string $modifier) use (
                $forPattern,
                $matchAt,
                $getTruthyOrValue,
            ) {
                $this->getModifier(
                    $modifier,
                    $forPattern,
                    $matchAt,
                    $getTruthyOrValue,
                );
            },
            $this->extractFromRawByIndex($arg, 4),
        );
    }

    private function getModifier(
        string $modifier,
        string $forPattern,
        int $matchAt,
        bool $getTruthyOrValue,
    ): null|bool|string {
        $match = $this->matchSingle(
            $modifier,
            $forPattern,
            $matchAt,
        );

        return $getTruthyOrValue ? (bool)$match : $match;
    }
}
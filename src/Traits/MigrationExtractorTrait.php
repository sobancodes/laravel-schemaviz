<?php

namespace Soban\LaravelErBBlueprint\Traits;

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

    protected function getDataFromExtract(
        array $migrationMetaData,
        int $at,
    ): array {
        return \array_map(
            fn(array $column) => $column[$at],
            $migrationMetaData,
        );
    }

    private function getModifiers(
        array $modifiers,
        string $forPattern,
        int $matchAt,
        bool $bool = true,
    ): array {
        return \array_map(
            function (string $modifier) use ($forPattern, $matchAt, $bool) {
                $match = $this->matchSingle(
                    $modifier,
                    $forPattern,
                    $matchAt,
                );

                return $bool ? (bool)$match : $match;
            },
            $modifiers,
        );
    }
}
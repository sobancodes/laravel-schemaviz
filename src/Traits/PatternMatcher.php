<?php

namespace Soban\LaravelErBlueprint\Traits;

trait PatternMatcher
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
}
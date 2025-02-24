<?php

namespace Soban\LaravelErBlueprint\Traits;

trait CacheExtractedMigration
{
    public const cached = [];

    public function getCachedOrRunRawExtractor(
        string $content,
        string $forPattern,
        bool $matchSingle = true,
    ): null|string|array {
        if (isset(self::cached[$forPattern])) {
            return self::cached[$forPattern];
        }

        return $this->matchPatterns(
            $content,
            $forPattern,
            $matchSingle,
        );
    }
}
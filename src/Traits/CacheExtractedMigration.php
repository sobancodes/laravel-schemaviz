<?php

namespace Soban\LaravelErBBlueprint\Traits;

trait CacheExtractedMigration
{
    public const cached = [];

    public function getCached(
        string $content,
        string $forPattern,
        bool $matchSingle = true,
    ): null|string|array {
        if (isset(self::cached[$forPattern])) {
            return self::cached[$forPattern];
        }

        return self::cached[$forPattern] = $this->matchPatterns(
            $content,
            $forPattern,
            $matchSingle,
        );
    }
}
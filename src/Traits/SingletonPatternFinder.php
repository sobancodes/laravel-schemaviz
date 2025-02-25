<?php

namespace Soban\LaravelErBlueprint\Traits;

trait SingletonPatternFinder
{
    protected array $resolvedPattern = [];

    public function getResolvedPatternOrBuild(
        string $content,
        string $forPattern,
        bool $matchSingle = true,
    ): null|string|array {
        if (isset($this->resolvedPattern[$forPattern])) {
            return $this->resolvedPattern[$forPattern];
        }

        return $this->extractAttributes(
            $content,
            $forPattern,
            $matchSingle,
        );
    }
}
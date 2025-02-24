<?php

namespace Soban\LaravelErBlueprint\Models;

class Column
{
    public function __construct(
        public string $name,
        public string $type,
        public bool $nullable,
        public bool $index,
        public bool $unique,
        public ?string $length,
        public ?string $default,
        public ?string $comment,
    ) {}
}
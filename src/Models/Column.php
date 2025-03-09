<?php

namespace Soban\LaravelErBlueprint\Models;

readonly class Column
{
    public function __construct(
        private string $name,
        private string $type,
        private mixed $param,
        private bool $nullable,
        private bool $index,
        private bool $unique,
        private ?string $default,
        private ?string $comment,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getParams(): mixed
    {
        return $this->param;
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }

    public function isIndex(): bool
    {
        return $this->index;
    }

    public function isUnique(): bool
    {
        return $this->unique;
    }

    public function getDefault(): ?string
    {
        return $this->default;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getSqlEquivalentType(): string
    {
        $type = config('columns.map');
        return isset($type[str()->snake($this->getType())])
            ? $type[str()->snake($this->getType())]
            : $this->getType();
    }

    public function __toString(): string
    {
        $formattedString = $this->getName()." {$this->getSqlEquivalentType()}".
        !empty($this->getParams()) ? " {$this->getParams()}" : '';

        $formattedString .= $this->isNullable() ? ' NULLABLE' : '';

        $formattedString .= $this->isIndex() ? ' INDEX' : '';

        $formattedString .= $this->isUnique() ? ' UNIQUE' : '';

        $formattedString .= $this->getDefault()
            ? " DEFAULT {$this->getDefault()}" : '';

        $formattedString .= $this->getComment()
            ? " COMMENT {$this->getComment()}" : '';

        return "{$formattedString}\n";
    }
}
<?php

namespace Soban\LaravelErBlueprint\Contracts;

interface ParserInterface
{
    public static function parse(string $filePath);
}
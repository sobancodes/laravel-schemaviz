<?php

namespace Soban\LaravelErBlueprint\Contracts;

interface ParserInterface
{
    public function parse(\SplFileInfo $file);
}
<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Renderers;

use Soban\LaravelErBlueprint\Parsers\MigrationParser;

class MermaidRenderer
{
    public function build(array $migrationPaths): ?string
    {
        $diagram = "erDiagram\n";

        foreach ($migrationPaths as $migrationPath) {
            $table = MigrationParser::parse($migrationPath);
            $diagram .= $this->indentBySpace().$table->name
                ." {\n";
            foreach ($table->getColumns() as $key => $column) {
                $diagram .= $this->indentBySpace(2).
                    $column->__toString();
            }
            $diagram .= $this->indentBySpace()."}\n";
        }

        return $diagram;
    }

    private function indentBySpace(int $indentation = 1): string
    {
        return str_replace(
            "\t",
            "    ",
            str_repeat("\t", $indentation),
        );
    }
}

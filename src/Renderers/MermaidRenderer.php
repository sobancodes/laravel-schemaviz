<?php

declare(strict_types=1);

namespace Soban\LaravelErBlueprint\Renderers;

use Soban\LaravelErBlueprint\Parsers\MigrationParser;

class MermaidRenderer
{
    public function build(
        null|string|array $migrationContaining = null,
    ): ?string {
        $migrations = fetchMigrations($migrationContaining);

        if (!$migrations) {
            return null;
        }

        $diagram = "erDiagram\n";

        foreach ($migrations as $migration) {
            $table = app(MigrationParser::class)->parse($migration);
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

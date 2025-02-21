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
            $parsedMigration = app(MigrationParser::class)->parse($migration);
            $diagram .= $this->indentBySpace().$parsedMigration['table_name']
                ." {\n";
            foreach ($parsedMigration['column_types'] as $key => $column) {
                $diagram .= $this->indentBySpace(2).$column
                    ." {$parsedMigration['column_name'][$key]}\n";
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

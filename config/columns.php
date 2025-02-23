<?php

return [
    'map' => [
        // Numeric Types
        'big_increments'          => 'BIGINT UNSIGNED AUTO_INCREMENT',
        'big_integer'             => 'BIGINT',
        'decimal'                 => 'DECIMAL',
        'double'                  => 'DOUBLE',
        'float'                   => 'FLOAT',
        'increments'              => 'INT UNSIGNED AUTO_INCREMENT',
        'integer'                 => 'INT',
        'medium_increments'       => 'MEDIUMINT UNSIGNED AUTO_INCREMENT',
        'medium_integer'          => 'MEDIUMINT',
        'small_increments'        => 'SMALLINT UNSIGNED AUTO_INCREMENT',
        'small_integer'           => 'SMALLINT',
        'tiny_increments'         => 'TINYINT UNSIGNED AUTO_INCREMENT',
        'tiny_integer'            => 'TINYINT',

        // String Types
        'binary'                  => 'BLOB',
        'char'                    => 'CHAR',
        'enum'                    => 'ENUM',
        'json'                    => 'JSON',
        'jsonb'                   => 'JSONB',
        'long_text'               => 'LONGTEXT',
        'medium_text'             => 'MEDIUMTEXT',
        'string'                  => 'VARCHAR',
        'text'                    => 'TEXT',
        'uuid'                    => 'UUID',
        'ulid'                    => 'ULID',

        // Date and Time Types
        'date'                    => 'DATE',
        'date_time'               => 'DATETIME',
        'date_time_tz'            => 'DATETIME (with timezone)',
        'time'                    => 'TIME',
        'time_tz'                 => 'TIME (with timezone)',
        'timestamp'               => 'TIMESTAMP',
        'timestamp_tz'            => 'TIMESTAMP (with timezone)',
        'year'                    => 'YEAR',

        // Boolean Types
        'boolean'                 => 'BOOLEAN',

        // Spatial Types
        'geometry'                => 'GEOMETRY',
        'geometry_collection'     => 'GEOMETRYCOLLECTION',
        'line_string'             => 'LINESTRING',
        'multi_line_string'       => 'MULTILINESTRING',
        'multi_point'             => 'MULTIPOINT',
        'multi_polygon'           => 'MULTIPOLYGON',
        'point'                   => 'POINT',
        'polygon'                 => 'POLYGON',

        // Foreign Key Types
        'foreign_id'              => 'UNSIGNED BIGINT',
        'foreign_ulid'            => 'ULID',
        'foreign_uuid'            => 'UUID',

        // Miscellaneous Types
        'ip_address'              => 'VARCHAR(45)',
        'mac_address'             => 'VARCHAR(17)',
        'morphs'                  => 'UNSIGNED BIGINT + VARCHAR',
        'nullable_morphs'         => 'UNSIGNED BIGINT + VARCHAR (nullable)',
        'remember_token'          => 'VARCHAR(100)',
        'soft_deletes'            => 'TIMESTAMP',
        'soft_deletes_tz'         => 'TIMESTAMP (with timezone)',
        'set'                     => 'SET',
        'unsigned_big_integer'    => 'UNSIGNED BIGINT',
        'unsigned_decimal'        => 'UNSIGNED DECIMAL',
        'unsigned_integer'        => 'UNSIGNED INT',
        'unsigned_medium_integer' => 'UNSIGNED MEDIUMINT',
        'unsigned_small_integer'  => 'UNSIGNED SMALLINT',
        'unsigned_tiny_integer'   => 'UNSIGNED TINYINT',
    ],
];
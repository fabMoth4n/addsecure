<?php

declare(strict_types=1);

namespace model;

use Interfaces\CloseInterface;
use Interfaces\InsertInterface;
use Interfaces\SelectInterface;
use Interfaces\UpdateInterface;
use PgSql\Connection;
use PgSql\Result;

class Db implements SelectInterface, InsertInterface, UpdateInterface, CloseInterface
{
    private Connection $_conn;

    public function __construct()
    {
        $this->_conn = pg_connect("host=127.0.0.1 port=5432 dbname=fabian user=postgres password=fabian");
    }

    public function createSelect(string $table_name, array $conditions, int $flags = PGSQL_DML_EXEC, int $mode = PGSQL_ASSOC): false|array|string
    {
        return pg_select(
            $this->_conn,
            $table_name,
            $conditions,
            $flags,
            $mode);
    }

    public function createInsert(string $table_name, array $values, int $flags = PGSQL_DML_EXEC): Result|string|bool
    {
        return pg_insert(
            $this->_conn, $table_name,
            $values,
            $flags
        );
    }

    public function createUpdate(string $table_name,
                           array  $values,
                           array  $conditions,
                           int    $flags = PGSQL_DML_EXEC): string|bool
    {
        return pg_update(
            $this->_conn,
            $table_name,
            $values,
            $conditions,
            $flags
        );
    }

    public function close(): bool
    {
        return pg_close($this->_conn);
    }
}
<?php

declare(strict_types=1);

namespace model\Tables;

use model\Db;
use PgSql\Result;

class CarsModel extends Db
{
    protected string $_tableName = 'cars';

    public function select(array $conditions): false|array|string
    {
        return $this->createSelect($this->_tableName, $conditions);
    }

    public function insert(array $values): Result|string|bool
    {
        return $this->createInsert($this->_tableName, $values);
    }

    public function update(array $values, array $conditions): string|bool
    {
        return $this->createUpdate($this->_tableName, $values, $conditions);
    }
}
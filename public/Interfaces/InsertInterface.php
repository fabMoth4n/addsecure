<?php

declare(strict_types=1);

namespace Interfaces;

interface InsertInterface
{
    public function createInsert(string $table_name,
                           array $values,
                           int $flags);
}
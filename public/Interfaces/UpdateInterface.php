<?php

declare(strict_types=1);

namespace Interfaces;

interface UpdateInterface
{
    public function createUpdate(string $table_name,
                           array $values,
                           array $conditions,
                           int $flags);
}
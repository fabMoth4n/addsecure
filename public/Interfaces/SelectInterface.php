<?php

declare(strict_types=1);

namespace Interfaces;

interface SelectInterface
{
    public function createSelect(string $table_name,
                           array  $conditions,
                           int    $flags,
                           int    $mode);
}
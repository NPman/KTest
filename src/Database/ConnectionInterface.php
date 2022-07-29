<?php
declare(strict_types=1);

namespace Kelnik\Database;

interface ConnectionInterface
{
    public function query(string $query): QueryResult;
    public function prepareValue($value);
}

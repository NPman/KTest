<?php
declare(strict_types=1);

namespace Kelnik\Database;

abstract class AbstractConnection
{
    abstract protected function prepareValue($value);
}

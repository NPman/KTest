<?php
declare(strict_types=1);

namespace Kelnik\Repository;

use Kelnik\App;
use Kelnik\Database\ConnectionInterface;
use Kelnik\Database\QueryResult;

class BaseMysqlRepository
{
    protected const DATABASE_DATE_FORMAT = 'Y-m-d H:i:s';

    protected function query(string $query): QueryResult
    {
        return $this->getConnection()->query($query);
    }

    protected function getConnection(): ConnectionInterface
    {
        return App::getInstance()->getConnection();
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function prepareValue($value)
    {
        if (is_int($value) || is_float($value)) {
            return $value;
        }

        return $this->getConnection()->prepareValue($value);
    }
}

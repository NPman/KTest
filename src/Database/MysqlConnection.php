<?php
declare(strict_types=1);

namespace Kelnik\Database;

use Kelnik\Exception\Database\MysqlConnectionException;

class MysqlConnection extends AbstractConnection implements ConnectionInterface
{
    private \mysqli $connection;

    public function __construct(string $host, string $user, string $password, string $database)
    {
        $connection = new \mysqli($host, $user, $password, $database);

        if ($connection->connect_errno) {
            throw new MysqlConnectionException(
                sprintf(
                    'Can\'t connect to database: host - %s, database - %s, message - %s',
                    $host,
                    $database,
                    $connection->connect_error
                )
            );
        }

        $this->connection = $connection;
    }

    /**
     * @param $value
     * @return string
     */
    public function prepareValue($value)
    {
        return $this->connection->real_escape_string($value);
    }

    public function query(string $query): QueryResult
    {
        $result = $this->connection->query($query);
        $queryResult = new QueryResult();

        $queryResult->setSuccess((bool)$result);

        if ($result instanceof \mysqli_result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);

            if (is_array($data)) {
                $queryResult->setData($data);
            }
        }

        if ($insertedId = $this->connection->insert_id) {
            $queryResult->setId((int)$insertedId);
        }

        return $queryResult;
    }
}
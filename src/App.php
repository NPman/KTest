<?php
declare(strict_types=1);

namespace Kelnik;

use Kelnik\Database\ConnectionInterface;
use Kelnik\Database\MysqlConnection;
use Kelnik\Exception\App\AppException;

class App
{
    private AppConfig $config;
    private const SUPPORTED_DB_TYPES = ['mysql'];
    private const MYSQL_DB_TYPE = 'mysql';
    private static ?self $instance = null;
    private ?ConnectionInterface $connection = null;

    public function __construct(AppConfig $appConfig)
    {
        $this->config = $appConfig;

        if (!$this->isDatabaseSupported($appConfig->getDbType())) {
            throw new AppException(sprintf('Unsupported database type %s', $appConfig->getDbType()));
        }
    }

    private function isDatabaseSupported(string $databaseType): bool
    {
        return in_array($databaseType, static::SUPPORTED_DB_TYPES);
    }

    public static function getInstance(): self
    {
        if (!isset(static::$instance)) {
            throw new AppException('App instance not initialized');
        }

        return static::$instance;
    }

    public static function init(AppConfig $appConfig): void
    {
        static::$instance = new static($appConfig);
    }

    public function getConnection(): ConnectionInterface
    {
        if (!$this->connection) {
            $this->connection = $this->getConnectionByType($this->config->getDbType());
        }

        return $this->connection;
    }

    private function getConnectionByType(string $connectionType): ConnectionInterface
    {
        if (!$this->isDatabaseSupported($connectionType)) {
            throw new AppException(sprintf('Unsupported database type %s', $connectionType));
        }

        return $this->getMysqlConnection();
    }

    private function getMysqlConnection(): ConnectionInterface
    {
        $config = $this->config;

        return new MysqlConnection(
            $config->getDbHost(),
            $config->getDbUser(),
            $config->getDbPassword(),
            $config->getDbName(),
        );
    }
}

<?php
declare(strict_types=1);

namespace Kelnik;

class AppConfig
{
    private string $dbType;
    private string $dbHost;
    private string $dbName;
    private string $dbUser;
    private string $dbPassword;

    public function __construct(string $dbType, string $dbHost, string $dbName, string $dbUser, string $dbPassword)
    {
        $this->dbType = $dbType;
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
    }

    public function getDbType(): string
    {
        return $this->dbType;
    }

    public function getDbHost(): string
    {
        return $this->dbHost;
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function getDbUser(): string
    {
        return $this->dbUser;
    }

    public function getDbPassword(): string
    {
        return $this->dbPassword;
    }
}

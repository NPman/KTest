<?php
declare(strict_types=1);

namespace Kelnik\Database;

class QueryResult
{
    private bool $success = true;
    private array $data = [];
    private ?int $id = null;

    public function setSuccess(bool $isSuccess): void
    {
        $this->success = $isSuccess;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}

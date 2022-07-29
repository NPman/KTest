<?php
declare(strict_types=1);

namespace Kelnik\Entity;

use DateTime;
use Kelnik\Exception\Entity\GuestBookException;
use Kelnik\Util\ValidationTrait;

class GuestBook
{
    use ValidationTrait;

    private ?int $id;
    private DateTime $dateCreate;
    private string $name;
    private string $email;
    private string $body;

    public function __construct(?int $id, DateTime $dateCreate, string $name, string $email, string $body)
    {
        $this->id = $id;
        $this->dateCreate = $dateCreate;
        $this->name = $name;
        $this->email = $email;
        $this->body = $body;

        $this->validate();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreate(): DateTime
    {
        return $this->dateCreate;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    private function validate(): void
    {
        if (!self::isEmailValid($this->getEmail())) {
            throw new GuestBookException('Invalid email');
        }
    }
}

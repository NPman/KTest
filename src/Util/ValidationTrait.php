<?php
declare(strict_types=1);

namespace Kelnik\Util;

trait ValidationTrait
{
    protected static function isEmailValid(string $email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

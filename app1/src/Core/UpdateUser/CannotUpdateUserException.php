<?php

declare(strict_types=1);

namespace App\Core\UpdateUser;

use Exception;

final class CannotUpdateUserException extends Exception
{
    public static function becauseEmailIsInvalid(string $invalidEmailExceptionMessage): self
    {
        return new self($invalidEmailExceptionMessage);
    }
}

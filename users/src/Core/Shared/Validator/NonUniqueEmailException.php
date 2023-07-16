<?php

declare(strict_types=1);

namespace App\Core\Shared\Validator;

use App\Core\Shared\ValueObject\Email;
use Exception;

final class NonUniqueEmailException extends Exception
{
    public static function providedEmailAlreadyExistsInSystem(Email $email): self
    {
        return new self(sprintf('Email: %s is already defined in the system.', $email->email));
    }
}

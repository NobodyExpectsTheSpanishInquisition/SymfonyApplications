<?php

declare(strict_types=1);

namespace App\Core\Shared\Validator;

use App\Core\Shared\ValueObject\Email;

final readonly class UniqueEmailValidator
{
    public function __construct(private EmailValidatorDpiInterface $emailValidatorDpi)
    {
    }

    public function validate(Email $email): bool
    {
        $userFoundByEmail = $this->emailValidatorDpi->findByEmail($email);

        return null === $userFoundByEmail;
    }
}

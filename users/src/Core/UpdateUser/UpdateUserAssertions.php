<?php

declare(strict_types=1);

namespace App\Core\UpdateUser;

use App\Core\Shared\Validator\NonUniqueEmailException;
use App\Core\Shared\Validator\UniqueEmailValidator;
use App\Core\Shared\ValueObject\Email;

final readonly class UpdateUserAssertions
{
    public function __construct(private UniqueEmailValidator $uniqueEmailValidator)
    {
    }

    /**
     * @throws CannotUpdateUserException
     */
    public function validate(Email $email): void
    {
        try {
            $this->validateEmailCorrectness($email);
        } catch (NonUniqueEmailException $e) {
            throw CannotUpdateUserException::becauseEmailIsInvalid($e->getMessage());
        }
    }

    /**
     * @throws NonUniqueEmailException
     */
    private function validateEmailCorrectness(Email $email): void
    {
        if (false === $this->uniqueEmailValidator->validate($email)) {
            throw NonUniqueEmailException::providedEmailAlreadyExistsInSystem($email);
        }
    }
}

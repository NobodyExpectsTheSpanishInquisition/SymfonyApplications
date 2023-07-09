<?php

declare(strict_types=1);

namespace App\Core\Shared\Validator;

use App\Core\Shared\Entity\User;
use App\Core\Shared\ValueObject\Email;

interface EmailValidatorDpiInterface
{
    public function findByEmail(Email $email): ?User;
}

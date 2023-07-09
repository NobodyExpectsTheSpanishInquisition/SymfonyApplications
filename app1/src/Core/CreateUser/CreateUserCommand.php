<?php

declare(strict_types=1);

namespace App\Core\CreateUser;

use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;

final readonly class CreateUserCommand
{
    public function __construct(public Uuid $userId, public Email $email)
    {
    }
}

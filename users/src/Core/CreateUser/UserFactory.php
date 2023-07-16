<?php

declare(strict_types=1);

namespace App\Core\CreateUser;

use App\Core\Shared\Entity\User;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;

final readonly class UserFactory
{
    public function create(Uuid $uuid, Email $email): User
    {
        return new User($uuid, $email);
    }
}

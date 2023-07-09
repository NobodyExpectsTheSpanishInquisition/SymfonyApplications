<?php

declare(strict_types=1);

namespace App\Core\UpdateUser;

use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;

final readonly class UpdateUserCommand
{
    public function __construct(public Uuid $userId, public Email $email)
    {
    }
}

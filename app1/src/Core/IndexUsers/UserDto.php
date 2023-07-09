<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;

final readonly class UserDto
{
    public function __construct(public Uuid $id, public Email $email)
    {
    }
}

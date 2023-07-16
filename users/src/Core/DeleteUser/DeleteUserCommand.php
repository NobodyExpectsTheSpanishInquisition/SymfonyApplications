<?php

declare(strict_types=1);

namespace App\Core\DeleteUser;

use App\Core\Shared\ValueObject\Uuid;

final readonly class DeleteUserCommand
{
    public function __construct(public Uuid $userId)
    {
    }
}

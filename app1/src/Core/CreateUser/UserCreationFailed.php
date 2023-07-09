<?php

declare(strict_types=1);

namespace App\Core\CreateUser;

use App\Core\Shared\Event\EventInterface;

final readonly class UserCreationFailed implements EventInterface
{
    public function __construct(public string $userId, public string $email)
    {
    }
}

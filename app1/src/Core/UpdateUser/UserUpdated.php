<?php

declare(strict_types=1);

namespace App\Core\UpdateUser;

use App\Core\Shared\Event\EventInterface;

final readonly class UserUpdated implements EventInterface
{
    public function __construct(public string $userId, public string $email)
    {
    }
}

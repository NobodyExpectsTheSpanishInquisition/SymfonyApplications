<?php

declare(strict_types=1);

namespace App\Core\DeleteUser;

use App\Core\Shared\Event\EventInterface;

final readonly class UserRemoved implements EventInterface
{
    public function __construct(public string $id)
    {
    }
}

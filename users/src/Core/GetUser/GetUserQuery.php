<?php

declare(strict_types=1);

namespace App\Core\GetUser;

use App\Core\Shared\ValueObject\Uuid;

final readonly class GetUserQuery
{
    public function __construct(public Uuid $userId)
    {
    }
}

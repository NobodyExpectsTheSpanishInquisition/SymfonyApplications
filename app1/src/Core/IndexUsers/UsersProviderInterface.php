<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

use App\Core\Shared\ValueObject\Paginator;

interface UsersProviderInterface
{
    /**
     * @return array<int, UserDto>
     */
    public function provide(Paginator $paginator): array;

    public function provideTotalUsers(): int;
}

<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

use App\Core\Shared\Entity\User;
use App\Core\Shared\ValueObject\Paginator;
use LogicException;

interface UsersListRepositoryInterface
{
    /**
     * @return array<int, User>
     */
    public function get(Paginator $paginator): array;

    /**
     * @throws LogicException
     */
    public function count(): int;
}

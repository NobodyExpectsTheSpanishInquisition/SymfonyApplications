<?php

declare(strict_types=1);

namespace App\Core\Shared\Repository\Port;

use App\Core\Shared\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
}

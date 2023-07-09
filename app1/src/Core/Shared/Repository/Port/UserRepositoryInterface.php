<?php

declare(strict_types=1);

namespace App\Core\Shared\Repository\Port;

use App\Core\Shared\Entity\User;
use App\Core\Shared\ValueObject\Uuid;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(Uuid $userId): ?User;

    public function remove(User $user): void;
}

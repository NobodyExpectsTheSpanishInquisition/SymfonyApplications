<?php

declare(strict_types=1);

namespace App\Core\Shared\Repository\Adapter;

use App\Core\Shared\Entity\User;
use App\Core\Shared\Repository\Port\UserRepositoryInterface;
use App\Core\Shared\ValueObject\Uuid;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineUserRepository implements UserRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
    }

    public function findById(Uuid $userId): ?User
    {
        return $this->entityManager->find(User::class, $userId->uuid);
    }

    public function remove(User $user): void
    {
        $this->entityManager->remove($user);
    }
}

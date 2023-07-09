<?php

declare(strict_types=1);

namespace App\Core\Shared\Repository\Adapter;

use App\Core\Shared\Entity\User;
use App\Core\Shared\Repository\Port\UserRepositoryInterface;
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
}

<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

use App\Core\Shared\ValueObject\Paginator;

final readonly class UsersProvider implements UsersProviderInterface
{
    public function __construct(private UsersListRepositoryInterface $repository, private UsersMapper $mapper)
    {
    }

    /**
     * @inheritDoc
     */
    public function provide(Paginator $paginator): array
    {
        $users = $this->repository->get($paginator);

        return $this->mapper->mapToDto($users);
    }

    public function provideTotalUsers(): int
    {
        return $this->repository->count();
    }
}

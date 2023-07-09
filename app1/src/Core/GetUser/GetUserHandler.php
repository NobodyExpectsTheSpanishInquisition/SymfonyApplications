<?php

declare(strict_types=1);

namespace App\Core\GetUser;

use App\Core\Shared\Entity\User;
use App\Core\Shared\Repository\Exception\NotFoundException;
use App\Core\Shared\Repository\Port\UserRepositoryInterface;

final readonly class GetUserHandler
{
    public function __construct(private UserRepositoryInterface $userRepository, private UserMapper $mapper)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function handle(GetUserQuery $query): UserView
    {
        $userId = $query->userId;
        $user = $this->userRepository->findById($userId);

        if (null === $user) {
            throw NotFoundException::notFoundById($userId->uuid, User::class);
        }

        return $this->mapper->toView($user);
    }
}

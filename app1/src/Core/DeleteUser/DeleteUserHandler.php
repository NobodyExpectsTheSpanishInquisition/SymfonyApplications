<?php

declare(strict_types=1);

namespace App\Core\DeleteUser;

use App\Core\Shared\Event\EventDispatcherInterface;
use App\Core\Shared\Repository\Port\TransactionManagerInterface;
use App\Core\Shared\Repository\Port\UserRepositoryInterface;

final readonly class DeleteUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TransactionManagerInterface $transactionManager,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function handle(DeleteUserCommand $command): void
    {
        $userId = $command->userId;

        $user = $this->userRepository->findById($userId);

        if (null === $user) {
            return;
        }

        $this->transactionManager->wrapInTransaction(function () use ($user, $userId): void {
            $this->userRepository->remove($user);

            $this->eventDispatcher->push(new UserRemoved($userId->uuid));
            $this->eventDispatcher->dispatch();
        });
    }
}

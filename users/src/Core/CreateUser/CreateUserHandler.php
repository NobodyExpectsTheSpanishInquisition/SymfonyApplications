<?php

declare(strict_types=1);

namespace App\Core\CreateUser;

use App\Core\Shared\Event\EventDispatcherInterface;
use App\Core\Shared\Repository\Exception\TransactionException;
use App\Core\Shared\Repository\Port\TransactionManagerInterface;
use App\Core\Shared\Repository\Port\UserRepositoryInterface;

final readonly class CreateUserHandler
{
    public function __construct(
        private UserFactory $userFactory,
        private TransactionManagerInterface $transactionManager,
        private UserRepositoryInterface $userRepository,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function handle(CreateUserCommand $command): void
    {
        $userId = $command->userId;
        $email = $command->email;

        $user = $this->userFactory->create($userId, $email);

        try {
            $this->transactionManager->wrapInTransaction(function () use ($user): void {
                $this->userRepository->save($user);
                $this->eventDispatcher->push(new UserCreated($user->getId()->uuid, $user->getEmail()->email));
                $this->eventDispatcher->dispatch();
            });
        } catch (TransactionException) {
            $this->eventDispatcher->push(new UserCreationFailed($userId->uuid, $email->email));
            $this->eventDispatcher->dispatch();

            return;
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Core\UpdateUser;

use App\Core\Shared\Entity\User;
use App\Core\Shared\Event\EventDispatcherInterface;
use App\Core\Shared\Repository\Exception\NotFoundException;
use App\Core\Shared\Repository\Exception\TransactionException;
use App\Core\Shared\Repository\Port\TransactionManagerInterface;
use App\Core\Shared\Repository\Port\UserRepositoryInterface;

final readonly class UpdateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UpdateUserAssertions $updateUserAssertions,
        private TransactionManagerInterface $transactionManager,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws CannotUpdateUserException
     */
    public function handle(UpdateUserCommand $command): void
    {
        $userId = $command->userId;
        $email = $command->email;

        $user = $this->userRepository->findById($userId);

        if (null === $user) {
            throw NotFoundException::notFoundById($userId->uuid, User::class);
        }

        try {
            $this->transactionManager->wrapInTransaction(function () use ($user, $email): void {
                $user->edit($email, $this->updateUserAssertions, $this->eventDispatcher);

                $this->eventDispatcher->dispatch();
            });
        } catch (TransactionException $e) {
            $this->eventDispatcher->push(new UserUpdateFailed($userId->uuid));
            $this->eventDispatcher->dispatch();

            throw new CannotUpdateUserException($e->getMessage());
        }
    }
}

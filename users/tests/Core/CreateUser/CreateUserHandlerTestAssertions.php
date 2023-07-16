<?php

declare(strict_types=1);

namespace App\Tests\Core\CreateUser;

use App\Core\CreateUser\UserCreated;
use App\Core\CreateUser\UserCreationFailed;
use App\Core\Shared\Entity\User;
use App\Core\Shared\ValueObject\Uuid;
use App\Tests\Stub\QueueClientStub;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CreateUserHandlerTestAssertions
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private QueueClientStub $queueClientStub,
        private CreateUserHandlerTest $testCase
    ) {
    }

    public function assertUserWasSavedInDatabase(Uuid $userId): void
    {
        $user = $this->entityManager->find(User::class, $userId->uuid);

        $this->testCase::assertNotNull($user);
    }

    public function assertUserCreationWasRegistered(): void
    {
        $this->testCase::assertTrue($this->queueClientStub->wasEventPushed(UserCreated::class));
    }

    public function assertUserCreationWasNotRegistered(): void
    {
        $this->testCase::assertFalse($this->queueClientStub->wasEventPushed(UserCreated::class));
    }

    public function assertUserCreationFailureWasRegistered(): void
    {
        $this->testCase::assertTrue($this->queueClientStub->wasEventPushed(UserCreationFailed::class));
    }

    public function assertUserCreationFailureWasNotRegistered(): void
    {
        $this->testCase::assertFalse($this->queueClientStub->wasEventPushed(UserCreationFailed::class));
    }

    public function assertUserWasNotSavedInDatabase(Uuid $userId): void
    {
        $user = $this->entityManager->find(User::class, $userId->uuid);

        $this->testCase::assertNull($user);
    }
}

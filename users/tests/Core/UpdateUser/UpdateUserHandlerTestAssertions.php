<?php

declare(strict_types=1);

namespace App\Tests\Core\UpdateUser;

use App\Core\Shared\Entity\User;
use App\Core\UpdateUser\UserUpdated;
use App\Core\UpdateUser\UserUpdateFailed;
use App\Tests\Stub\QueueClientStub;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UpdateUserHandlerTestAssertions
{
    public function __construct(
        private UpdateUserHandlerTest $testCase,
        private EntityManagerInterface $entityManager,
        private UpdateUserTestData $testData,
        private QueueClientStub $queueClientStub
    ) {
    }

    public function assertUserUpdated(): void
    {
        $user = $this->entityManager->find(User::class, $this->testData->getUserOneId()->uuid);

        $this->testCase::assertNotNull($user);
        $this->testCase::assertEquals($this->testData->getEmailTwo(), $user->getEmail());
    }

    public function assertUpdateRegistered(): void
    {
        $this->testCase::assertTrue($this->queueClientStub->wasEventPushed(UserUpdated::class));
    }

    public function assertUserUpdateFailureNotRegistered(): void
    {
        $this->testCase::assertFalse($this->queueClientStub->wasEventPushed(UserUpdateFailed::class));
    }

    public function assertUpdateNotRegistered(): void
    {
        $this->testCase::assertFalse($this->queueClientStub->wasEventPushed(UserUpdated::class));
    }

    public function assertUserUpdateFailureRegistered(): void
    {
        $this->testCase::assertTrue($this->queueClientStub->wasEventPushed(UserUpdateFailed::class));
    }
}

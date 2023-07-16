<?php

declare(strict_types=1);

namespace App\Tests\Core\DeleteUser;

use App\Core\DeleteUser\UserRemoved;
use App\Core\Shared\Entity\User;
use App\Tests\Stub\QueueClientStub;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DeleteUserHandlerTestAssertions
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private DeleteUserTestData $testData,
        private DeleteUserHandlerTest $testCase,
        private QueueClientStub $queueClientStub
    ) {
    }

    public function assertUserRemoved(): void
    {
        $user = $this->entityManager->find(User::class, $this->testData->getUserId()->uuid);

        $this->testCase::assertNull($user);
    }

    public function assertDeletionWasNotRegistered(): void
    {
        $this->testCase::assertFalse($this->queueClientStub->wasEventPushed(UserRemoved::class));
    }

    public function assertDeletionWasRegistered(): void
    {
        $this->testCase::assertTrue($this->queueClientStub->wasEventPushed(UserRemoved::class));
    }
}

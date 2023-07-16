<?php

/** @noinspection ALL */

declare(strict_types=1);

namespace App\Tests\Core\UpdateUser;

use App\Core\CreateUser\UserFactory;
use App\Core\Shared\Entity\User;
use App\Core\Shared\Event\EventDispatcherInterface;
use App\Core\Shared\Repository\Exception\NotFoundException;
use App\Core\Shared\Repository\Port\UserRepositoryInterface;
use App\Core\UpdateUser\CannotUpdateUserException;
use App\Core\UpdateUser\UpdateUserAssertions;
use App\Core\UpdateUser\UpdateUserHandler;
use App\Tests\IntegrationTestCase;

final class UpdateUserHandlerTest extends IntegrationTestCase
{
    private UpdateUserTestData $testData;
    private UpdateUserHandler $handler;
    private UpdateUserHandlerTestAssertions $assertions;

    public function test_Handle_ShouldThrowNotFoundException_WhenUserNotFound(): void
    {
        $command = $this->testData->getCommand();

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(
            NotFoundException::notFoundById($command->userId->uuid, User::class)->getMessage()
        );
        $this->handler->handle($this->testData->getCommand());
    }

    public function test_Handle_ShouldUpdateUser_WhenCorrectNewDataProvided(): void
    {
        $this->testData->loadUserWithEmail($this->testData->getUserOneId(), $this->testData->getEmailOne());

        $this->handler->handle($this->testData->getCommand());

        $this->assertions->assertUserUpdated();
    }

    public function test_Handle_ShouldRegisterUserUpdate_WhenUserUpdated(): void
    {
        $this->testData->loadUserWithEmail($this->testData->getUserOneId(), $this->testData->getEmailOne());

        $this->handler->handle($this->testData->getCommand());

        $this->assertions->assertUpdateRegistered();
        $this->assertions->assertUserUpdateFailureNotRegistered();
    }

    public function test_Handle_ShouldRegisterUserUpdateFailure_WhenUserUpdateFailed(): void
    {
        $transactionManagerMock = $this->mockTransactionManagerFailure();
        $this->testData->loadUserWithEmail($this->testData->getUserOneId(), $this->testData->getEmailOne());
        $handler = new UpdateUserHandler(
            self::getContainer()->get(UserRepositoryInterface::class),
            self::getContainer()->get(UpdateUserAssertions::class),
            $transactionManagerMock,
            self::getContainer()->get(EventDispatcherInterface::class)
        );

        try {
            $handler->handle($this->testData->getCommand());
        } catch (CannotUpdateUserException) {
            $this->assertions->assertUpdateNotRegistered();
            $this->assertions->assertUserUpdateFailureRegistered();
        }
    }

    public function test_Handle_ShouldThrowCannotUpdateUserException_WhenUpdateFailed(): void
    {
        $transactionManagerMock = $this->mockTransactionManagerFailure();
        $this->testData->loadUserWithEmail($this->testData->getUserOneId(), $this->testData->getEmailOne());
        $handler = new UpdateUserHandler(
            self::getContainer()->get(UserRepositoryInterface::class),
            self::getContainer()->get(UpdateUserAssertions::class),
            $transactionManagerMock,
            self::getContainer()->get(EventDispatcherInterface::class)
        );

        $this->expectException(CannotUpdateUserException::class);
        $handler->handle($this->testData->getCommand());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = new UpdateUserTestData(
            $this->getEntityManager(),
            self::getContainer()->get(UserFactory::class)
        );
        $this->handler = self::getContainer()->get(UpdateUserHandler::class);
        $this->assertions = new UpdateUserHandlerTestAssertions(
            $this,
            $this->getEntityManager(),
            $this->testData,
            $this->queueClientStub
        );

        $this->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }
}

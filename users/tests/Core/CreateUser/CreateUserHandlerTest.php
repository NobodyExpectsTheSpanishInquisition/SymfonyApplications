<?php

declare(strict_types=1);

namespace App\Tests\Core\CreateUser;

use App\Core\CreateUser\CreateUserHandler;
use App\Core\CreateUser\UserFactory;
use App\Core\Shared\Event\EventDispatcherInterface;
use App\Core\Shared\Repository\Port\UserRepositoryInterface;
use App\Tests\IntegrationTestCase;

final class CreateUserHandlerTest extends IntegrationTestCase
{
    private CreateUserTestData $testData;
    private CreateUserHandler $handler;
    private CreateUserHandlerTestAssertions $assertions;

    public function test_Handle_ShouldSaveUserInDatabase_WhenUserWasCreatedSuccessfullyAndTransactionPassed(): void
    {
        $command = $this->testData->getCommand();

        $this->handler->handle($command);

        $this->assertions->assertUserWasSavedInDatabase($command->userId);
    }

    public function test_Handle_ShouldDispatchUserCreatedEvent_WhenUserWasCreated(): void
    {
        $command = $this->testData->getCommand();

        $this->handler->handle($command);

        $this->assertions->assertUserCreationWasRegistered();
        $this->assertions->assertUserCreationFailureWasNotRegistered();
    }

    public function test_Handle_ShouldNotSaveUserInDatabase_WhenTransactionFailed(): void
    {
        $transactionManagerMock = $this->mockTransactionManagerFailure();
        $command = $this->testData->getCommand();

        $handler = new CreateUserHandler(
            self::getContainer()->get(UserFactory::class),
            $transactionManagerMock,
            self::getContainer()->get(UserRepositoryInterface::class),
            self::getContainer()->get(EventDispatcherInterface::class)
        );
        $handler->handle($command);

        $this->assertions->assertUserWasNotSavedInDatabase($command->userId);
    }

    public function test_Handle_ShouldDispatchUserCreationFailedEvent_WhenTransactionFailed(): void
    {
        $transactionManagerMock = $this->mockTransactionManagerFailure();
        $command = $this->testData->getCommand();

        $handler = new CreateUserHandler(
            self::getContainer()->get(UserFactory::class),
            $transactionManagerMock,
            self::getContainer()->get(UserRepositoryInterface::class),
            self::getContainer()->get(EventDispatcherInterface::class)
        );
        $handler->handle($command);

        $this->assertions->assertUserCreationFailureWasRegistered();
        $this->assertions->assertUserCreationWasNotRegistered();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = new CreateUserTestData();
        $this->handler = self::getContainer()->get(CreateUserHandler::class);
        $this->assertions = new CreateUserHandlerTestAssertions(
            $this->getEntityManager(),
            $this->queueClientStub,
            $this
        );

        $this->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Core\DeleteUser;

use App\Core\CreateUser\UserFactory;
use App\Core\DeleteUser\DeleteUserHandler;
use App\Tests\IntegrationTestCase;

final class DeleteUserHandlerTest extends IntegrationTestCase
{
    private DeleteUserTestData $testData;
    private DeleteUserHandler $handler;
    private DeleteUserHandlerTestAssertions $assertions;

    public function test_Handle_ShouldNotRegisterUserDelete_WhenUserNotFound(): void
    {
        $this->handler->handle($this->testData->getCommand());

        $this->assertions->assertDeletionWasNotRegistered();
    }

    public function test_Handle_ShouldDeleteUser_WhenUserFound(): void
    {
        $this->testData->loadUser();

        $this->handler->handle($this->testData->getCommand());

        $this->assertions->assertUserRemoved();
        $this->assertions->assertDeletionWasRegistered();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = new DeleteUserTestData(
            $this->getEntityManager(),
            self::getContainer()->get(UserFactory::class)
        );
        $this->handler = self::getContainer()->get(DeleteUserHandler::class);
        $this->assertions = new DeleteUserHandlerTestAssertions(
            $this->getEntityManager(),
            $this->testData,
            $this,
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

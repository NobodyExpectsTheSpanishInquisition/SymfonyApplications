<?php

declare(strict_types=1);

namespace App\Tests\Core\GetUser;

use App\Core\CreateUser\UserFactory;
use App\Core\GetUser\GetUserHandler;
use App\Core\Shared\Entity\User;
use App\Core\Shared\Repository\Exception\NotFoundException;
use App\Tests\IntegrationTestCase;

final class GetUserHandlerTest extends IntegrationTestCase
{
    private GetUserTestData $testData;
    private GetUserHandler $handler;

    public function test_Handle_ShouldReturnUser_WhenUserFound(): void
    {
        $this->testData->loadData();

        $result = $this->handler->handle($this->testData->getQuery());

        self::assertEquals($this->testData->getExpectedUser(), $result);
    }

    public function test_Handle_ShouldThrowNotFoundException_WhenUserNotFound(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(
            NotFoundException::notFoundById(
                $this->testData->getUserId()->uuid,
                User::class
            )->getMessage()
        );
        $this->handler->handle($this->testData->getQuery());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = new GetUserTestData(self::getContainer()->get(UserFactory::class), $this->getEntityManager());
        $this->handler = self::getContainer()->get(GetUserHandler::class);

        $this->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }
}

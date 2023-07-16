<?php

declare(strict_types=1);

namespace App\Tests\Core\IndexUsers;

use App\Core\CreateUser\UserFactory;
use App\Core\IndexUsers\IndexUsersHandler;
use App\Tests\IntegrationTestCase;

final class IndexUsersHandlerTest extends IntegrationTestCase
{
    private IndexUsersHandler $handler;
    private IndexUsersTestData $testData;

    public function test_Handle_ShouldReturnEmptyListOfUsers_WhenNoUsersInSystem(): void
    {
        $list = $this->handler->handle($this->testData->getQuery());

        self::assertEmpty($list->users);
        self::assertEquals(0, $list->totalUsers);
    }

    public function test_Handle_ShouldReturnListWithNoMoreUsersThanPaginationAllows(): void
    {
        $this->testData->loadMoreUsersThanLimitAllowsToReturn();

        $list = $this->handler->handle($this->testData->getQuery());

        self::assertCount($this->testData->getLimit()->limit, $list->users);
        self::assertEquals(6, $list->totalUsers);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = new IndexUsersTestData(
            $this->getEntityManager(),
            self::getContainer()->get(UserFactory::class)
        );
        $this->handler = self::getContainer()->get(IndexUsersHandler::class);

        $this->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }
}

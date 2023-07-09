<?php

declare(strict_types=1);

namespace App\Tests\Core\IndexUsers;

use App\Core\CreateUser\UserFactory;
use App\Tests\SmokeTestCase;

final class IndexUsersControllerTest extends SmokeTestCase
{
    private const ROUTE_NAME = 'api.users.index';
    private IndexUsersTestData $testData;

    public function test_Index_ShouldReturn200StatusCode_WhenUsersListNotReturned(): void
    {
        $response = $this->sendGetRequest(
            self::ROUTE_NAME,
            [
                'offset' => $this->testData->getOffset()->offset,
                'limit' => $this->testData->getLimit()->limit,
            ]
        );

        self::assertResponseIsSuccessful();
        self::assertEquals($this->testData->getExpectedEmptyUsersList(), $response->getContent());
    }

    public function test_Index_ShouldReturn200StatusCode_WhenUsersListReturned(): void
    {
        $this->testData->loadUsers();

        $response = $this->sendGetRequest(
            self::ROUTE_NAME,
            [
                'offset' => $this->testData->getOffset()->offset,
                'limit' => $this->testData->getLimit()->limit,
            ]
        );

        self::assertResponseIsSuccessful();
        self::assertEquals($this->testData->getExpectedFilledUsersList(), $response->getContent());
    }

    public function test_Index_ShouldReturn400StatusCode_WhenOffsetNotProvided(): void
    {
        $this->sendGetRequest(
            self::ROUTE_NAME,
            [
                'limit' => $this->testData->getLimit()->limit,
            ]
        );

        self::assertResponseStatusCodeSame(400);
    }

    public function test_Index_ShouldReturn400StatusCode_WhenLimitNotProvided(): void
    {
        $this->sendGetRequest(
            self::ROUTE_NAME,
            [
                'offset' => $this->testData->getOffset()->offset,
            ]
        );

        self::assertResponseStatusCodeSame(400);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = new IndexUsersTestData(
            $this->getEntityManager(),
            self::getContainer()->get(UserFactory::class)
        );
    }
}

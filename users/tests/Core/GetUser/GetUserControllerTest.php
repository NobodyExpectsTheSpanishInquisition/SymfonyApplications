<?php

declare(strict_types=1);

namespace App\Tests\Core\GetUser;

use App\Core\CreateUser\UserFactory;
use App\Tests\SmokeTestCase;

final class GetUserControllerTest extends SmokeTestCase
{
    private const ROUTE_NAME = 'api.users.get';
    private GetUserTestData $testData;

    public function test_Get_ShouldReturn200StatusCode_WhenUserFound(): void
    {
        $this->testData->loadData();

        $this->sendGetRequest(self::ROUTE_NAME, ['id' => $this->testData->getUserId()->uuid]);

        self::assertResponseIsSuccessful();
    }

    public function test_Get_ShouldReturn404StatusCode_WhenUserNotFound(): void
    {
        $this->sendGetRequest(self::ROUTE_NAME, ['id' => $this->testData->getUserId()->uuid]);

        self::assertResponseStatusCodeSame(404);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = new GetUserTestData(new UserFactory(), $this->getEntityManager());
    }
}

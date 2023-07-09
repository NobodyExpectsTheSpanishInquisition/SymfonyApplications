<?php

declare(strict_types=1);

namespace App\Tests\Core\DeleteUser;

use App\Core\CreateUser\UserFactory;
use App\Tests\SmokeTestCase;

final class DeleteUserControllerTest extends SmokeTestCase
{
    private const ROUTE_NAME = 'api.users.delete';

    private DeleteUserTestData $testData;

    public function test_Delete_ShouldReturn204StatusCode_WhenUserRemoved(): void
    {
        $this->testData->loadUser();

        $this->sendDeleteRequest(self::ROUTE_NAME, ['id' => $this->testData->getUserId()->uuid]);

        self::assertResponseStatusCodeSame(204);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = new DeleteUserTestData(
            $this->getEntityManager(),
            self::getContainer()->get(UserFactory::class)
        );
    }
}

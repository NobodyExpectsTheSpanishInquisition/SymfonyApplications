<?php

declare(strict_types=1);

namespace App\Tests\Core\UpdateUser;

use App\Core\CreateUser\UserFactory;
use App\Tests\SmokeTestCase;

final class UpdateUserControllerTest extends SmokeTestCase
{
    private const ROUTE_NAME = 'api.users.update';
    private UpdateUserTestData $testData;
    private UpdateUserControllerTestAssertions $assertions;

    public function test_Update_ShouldReturn200StatusCodeAndReturnUpdatedRecord_WhenEmailUpdatedSuccessfully(): void
    {
        $this->testData->loadUserWithEmail($this->testData->getUserOneId(), $this->testData->getEmailOne());

        $response = $this->sendPatchRequestWithResponse(
            self::ROUTE_NAME,
            ['id' => $this->testData->getUserOneId()->uuid],
            ['email' => $this->testData->getEmailTwo()->email]
        );

        self::assertResponseIsSuccessful();
        $this->assertions->assertUpdatedUserReturned($response);
    }

    public function test_Update_ShouldReturn404StatusCode_WhenUserNotFound(): void
    {
        $this->sendPatchRequestWithResponse(
            self::ROUTE_NAME,
            ['id' => $this->testData->getUserOneId()->uuid],
            ['email' => $this->testData->getEmailTwo()->email]
        );

        self::assertResponseStatusCodeSame(404);
    }

    public function test_Update_ShouldReturn422StatusCode_WhenUserWithProvidedEmailAlreadyExists(): void
    {
        $this->testData->loadUserWithEmail($this->testData->getUserOneId(), $this->testData->getEmailOne());
        $this->testData->loadUserWithEmail($this->testData->getUserTwoId(), $this->testData->getEmailTwo());

        $this->sendPatchRequestWithResponse(
            self::ROUTE_NAME,
            ['id' => $this->testData->getUserTwoId()->uuid],
            ['email' => $this->testData->getEmailOne()->email]
        );

        self::assertResponseStatusCodeSame(422);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = new UpdateUserTestData(
            $this->getEntityManager(),
            self::getContainer()->get(UserFactory::class)
        );
        $this->assertions = new UpdateUserControllerTestAssertions($this, $this->testData);
    }
}

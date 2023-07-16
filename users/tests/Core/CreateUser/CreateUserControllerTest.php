<?php

declare(strict_types=1);

namespace App\Tests\Core\CreateUser;

use App\Tests\SmokeTestCase;

final class CreateUserControllerTest extends SmokeTestCase
{
    private const ROUTE_NAME = 'api.users.create';
    private CreateUserTestData $testData;

    public function test_Create_ShouldReturnCreatedUser_WhenAllPassedValuesAreCorrect(): void
    {
        $response = $this->sendPostRequestWithResponse(self::ROUTE_NAME, [
            'id' => $this->testData->getUserId()->uuid,
            'email' => $this->testData->getEmail()->email,
        ]);

        self::assertResponseStatusCodeSame(201);
        self::assertEquals(
            json_encode($this->testData->getExpectedCreatedUser()->jsonSerialize()),
            $response->getContent()
        );
    }

    public function test_Create_ShouldThrowBadRequestHttpException_WhenIncorrectIdPassed(): void
    {
        $this->sendPostRequestWithResponse(self::ROUTE_NAME, [
            'id' => 'incorrect id',
            'email' => $this->testData->getEmail()->email,
        ]);

        self::assertResponseStatusCodeSame(400);
    }

    public function test_Create_ShouldThrowBadRequestHttpException_WhenIncorrectEmailPassed(): void
    {
        $this->sendPostRequestWithResponse(self::ROUTE_NAME, [
            'id' => $this->testData->getUserId()->uuid,
            'email' => 'test    @email.com',
        ]);

        self::assertResponseStatusCodeSame(400);
    }

    public function test_Create_ShouldThrowBadRequestHttpException_WhenIdFieldIsMissing(): void
    {
        $this->sendPostRequestWithResponse(self::ROUTE_NAME, [
            'email' => $this->testData->getEmail()->email,
        ]);

        self::assertResponseStatusCodeSame(400);
    }

    public function test_Create_ShouldThrowBadRequestHttpException_WhenEmailFieldIsMissing(): void
    {
        $this->sendPostRequestWithResponse(self::ROUTE_NAME, [
            'id' => $this->testData->getUserId()->uuid,
        ]);

        self::assertResponseStatusCodeSame(400);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = new CreateUserTestData();
    }
}

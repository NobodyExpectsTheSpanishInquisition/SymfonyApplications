<?php

declare(strict_types=1);

namespace App\Tests\Core\CreateUser;

use App\Tests\SmokeTestCase;

final class CreateUserControllerTest extends SmokeTestCase
{
    private const ROUTE_NAME = 'api.users.create';

    public function test_Create_ShouldReturnCreatedUser_WhenAllPassedValuesAreCorrect(): void
    {
        $this->sendPostRequest(self::ROUTE_NAME, [
            'id' => 'C831F4D0-1B54-46C2-9C72-3BB041079579',
            'email' => 'test@email.com',
        ]);

        self::assertResponseStatusCodeSame(201);
    }

    public function test_Create_ShouldThrowBadRequestHttpException_WhenIncorrectIdPassed(): void
    {
        $this->sendPostRequest(self::ROUTE_NAME, [
            'id' => 'incorrect id',
            'email' => 'test@email.com',
        ]);

        self::assertResponseStatusCodeSame(400);
    }

    public function test_Create_ShouldThrowBadRequestHttpException_WhenIncorrectEmailPassed(): void
    {
        $this->sendPostRequest(self::ROUTE_NAME, [
            'id' => 'C831F4D0-1B54-46C2-9C72-3BB041079579',
            'email' => 'test    @email.com',
        ]);

        self::assertResponseStatusCodeSame(400);
    }

    public function test_Create_ShouldThrowBadRequestHttpException_WhenIdFieldIsMissing(): void
    {
        $this->sendPostRequest(self::ROUTE_NAME, [
            'email' => 'test@email.com',
        ]);

        self::assertResponseStatusCodeSame(400);
    }

    public function test_Create_ShouldThrowBadRequestHttpException_WhenEmailFieldIsMissing(): void
    {
        $this->sendPostRequest(self::ROUTE_NAME, [
            'id' => 'C831F4D0-1B54-46C2-9C72-3BB041079579',
        ]);

        self::assertResponseStatusCodeSame(400);
    }
}

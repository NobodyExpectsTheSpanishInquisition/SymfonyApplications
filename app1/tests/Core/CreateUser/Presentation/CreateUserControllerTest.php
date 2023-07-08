<?php

declare(strict_types=1);

namespace App\Tests\Core\CreateUser\Presentation;

use App\Tests\SmokeTestCase;

final class CreateUserControllerTest extends SmokeTestCase
{
    private const ROUTE_NAME = 'user.create';

    public function test_Create_ShouldReturnCreatedUser_WhenAllPassedValuesAreCorrect(): void
    {
        $this->sendPostRequest(self::ROUTE_NAME, []);

        self::assertResponseStatusCodeSame(201);
    }
}

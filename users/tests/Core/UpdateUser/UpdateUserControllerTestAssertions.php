<?php

declare(strict_types=1);

namespace App\Tests\Core\UpdateUser;

use Symfony\Component\HttpFoundation\Response;

final readonly class UpdateUserControllerTestAssertions
{
    public function __construct(private UpdateUserControllerTest $testCase, private UpdateUserTestData $testData)
    {
    }

    public function assertUpdatedUserReturned(Response $response): void
    {
        $this->testCase::assertEquals(
            json_encode([
                'id' => $this->testData->getUserOneId()->uuid,
                'email' => $this->testData->getEmailTwo()->email,
            ]),
            $response->getContent()
        );
    }
}

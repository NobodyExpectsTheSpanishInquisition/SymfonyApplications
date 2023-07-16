<?php

declare(strict_types=1);

namespace App\Tests\Core\Shared\Validator;

use App\Core\CreateUser\UserFactory;
use App\Core\Shared\Validator\UniqueEmailValidator;
use App\Tests\IntegrationTestCase;

final class UniqueEmailValidatorTest extends IntegrationTestCase
{
    private UniqueEmailValidatorTestData $testData;

    private UniqueEmailValidator $validator;

    public function test_Validate_ShouldReturnFalse_WhenUserWithProvidedEmailAlreadyExists(): void
    {
        $email = $this->testData->getEmail();
        $this->testData->loadUserWithEmail($email);

        $result = $this->validator->validate($email);

        self::assertFalse($result);
    }

    public function test_Validate_ShouldReturnTrue_WhenUserWithProvidedEmailDoesNotExists(): void
    {
        $email = $this->testData->getEmail();

        $result = $this->validator->validate($email);

        self::assertTrue($result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = new UniqueEmailValidatorTestData(new UserFactory(), $this->getEntityManager());
        $this->validator = self::getContainer()->get(UniqueEmailValidator::class);

        $this->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Core\UpdateUser;

use App\Core\CreateUser\UserFactory;
use App\Core\Shared\Entity\User;
use App\Core\Shared\Validator\EmailValidatorDpiInterface;
use App\Core\Shared\Validator\UniqueEmailValidator;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
use App\Core\UpdateUser\CannotUpdateUserException;
use App\Core\UpdateUser\UpdateUserAssertions;
use App\Core\UpdateUser\UserUpdated;
use App\Tests\Stub\EventStoreStub;
use App\Tests\UnitTestCase;

final class UpdateUserTest extends UnitTestCase
{
    private User $user;
    private EventStoreStub $eventStoreStub;

    public function test_Edit_ShouldThrowCannotUpdateUserException_WhenAssertionsFailed(): void
    {
        $assertions = $this->createAssertions(shouldFindUserWithProvidedEmail: true);

        $this->expectException(CannotUpdateUserException::class);
        $this->user->edit(new Email('test2@email.com'), $assertions, $this->eventStoreStub);
    }

    public function test_Edit_ShouldNotRegisterUserUpdate_WhenEmailAlreadyExistsInSystem(): void
    {
        $assertions = $this->createAssertions(shouldFindUserWithProvidedEmail: true);

        try {
            $this->user->edit(new Email('test2@email.com'), $assertions, $this->eventStoreStub);
        } catch (CannotUpdateUserException) {
            self::assertEmpty($this->eventStoreStub->getStoredEvents());
        }
    }

    public function test_Edit_ShouldUpdateUserAndRegisterUpdate_WhenUniqueEmailIsProvided(): void
    {
        $assertions = $this->createAssertions(shouldFindUserWithProvidedEmail: false);
        $newEmail = new Email('test2@email.com');

        $this->user->edit($newEmail, $assertions, $this->eventStoreStub);

        self::assertEquals($newEmail, $this->user->getEmail());
        self::assertNotEmpty($this->eventStoreStub->getStoredEvents());
        self::assertInstanceOf(UserUpdated::class, $this->eventStoreStub->getStoredEvents()[0]);
    }

    public function setUp(): void
    {
        $userFactory = new UserFactory();
        $userId = new Uuid('5779DD66-EE05-4E01-8CC6-41E56ADFF2C2');
        $oldEmail = new Email('test@email.com');
        $this->user = $userFactory->create($userId, $oldEmail);
        $this->eventStoreStub = new EventStoreStub();
    }

    private function createAssertions(bool $shouldFindUserWithProvidedEmail): UpdateUserAssertions
    {
        $findByEmailResponse = $shouldFindUserWithProvidedEmail ? $this->createMock(User::class) : null;
        $emailValidatorDpiMock = $this->createMock(EmailValidatorDpiInterface::class);
        $emailValidatorDpiMock
            ->method('findByEmail')
            ->willReturn($findByEmailResponse);

        return new UpdateUserAssertions(new UniqueEmailValidator($emailValidatorDpiMock));
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Core\CreateUser;

use App\Core\CreateUser\CreateUserCommand;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
use App\Core\Shared\View\UserView;

final readonly class CreateUserTestData
{
    public function getCommand(): CreateUserCommand
    {
        return new CreateUserCommand(
            $this->getUserId(),
            $this->getEmail()
        );
    }

    public function getUserId(): Uuid
    {
        return new Uuid('BA2836E4-E820-4E5A-A6B7-3BC9320F8883');
    }

    public function getEmail(): Email
    {
        return new Email('test@email.com');
    }

    public function getExpectedCreatedUser(): UserView
    {
        return new UserView($this->getUserId()->uuid, $this->getEmail()->email);
    }
}

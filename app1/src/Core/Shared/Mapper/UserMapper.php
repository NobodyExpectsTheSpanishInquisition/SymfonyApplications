<?php

declare(strict_types=1);

namespace App\Core\Shared\Mapper;

use App\Core\Shared\Entity\User;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
use App\Core\Shared\View\UserView;

final readonly class UserMapper
{
    public function toView(User $user): UserView
    {
        return new UserView($user->getId()->uuid, $user->getEmail()->email);
    }

    public function toViewByParameters(Uuid $id, Email $email): UserView
    {
        return new UserView($id->uuid, $email->email);
    }
}

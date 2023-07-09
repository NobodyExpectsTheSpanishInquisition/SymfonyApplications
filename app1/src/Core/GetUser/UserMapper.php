<?php

declare(strict_types=1);

namespace App\Core\GetUser;

use App\Core\Shared\Entity\User;
use App\Core\Shared\View\UserView;

final readonly class UserMapper
{
    public function toView(User $user): UserView
    {
        return new UserView($user->getId()->uuid, $user->getEmail()->email);
    }
}
<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

use App\Core\Shared\Entity\User;
use App\Core\Shared\Mapper\UserMapper;
use App\Core\Shared\View\UserView;

final readonly class UsersMapper
{
    public function __construct(private UserMapper $userMapper)
    {
    }

    /**
     * @param array<int, UserDto> $users
     */
    public function mapToListView(array $users, int $totalUsers): UsersListView
    {
        $userViews = array_map(
            fn(UserDto $user): UserView => $this->userMapper->toViewByParameters($user->id, $user->email),
            $users
        );

        return new UsersListView($userViews, $totalUsers);
    }

    /**
     * @param array<int, User> $users
     * @return array<int, UserDto>
     */
    public function mapToDto(array $users): array
    {
        return array_map(static fn(User $user): UserDto => new UserDto($user->getId(), $user->getEmail()), $users);
    }
}

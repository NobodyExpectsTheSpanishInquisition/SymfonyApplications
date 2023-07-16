<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

use App\Core\Shared\View\UserView;
use JsonSerializable;

final readonly class UsersListView implements JsonSerializable
{
    /**
     * @param array<int, UserView> $users
     */
    public function __construct(public array $users, public int $totalUsers)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'users' => $this->users,
            'totalUsers' => $this->totalUsers,
        ];
    }
}

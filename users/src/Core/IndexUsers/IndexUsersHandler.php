<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

final readonly class IndexUsersHandler
{
    public function __construct(private UsersProviderInterface $usersProvider, private UsersMapper $mapper)
    {
    }

    public function handle(IndexUsersQuery $query): UsersListView
    {
        $users = $this->usersProvider->provide($query->paginator);
        $totalUsers = $this->usersProvider->provideTotalUsers();

        return $this->mapper->mapToListView($users, $totalUsers);
    }
}

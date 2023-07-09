<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

use App\Core\Shared\ValueObject\Paginator;

final readonly class IndexUsersQuery
{
    public function __construct(public Paginator $paginator)
    {
    }
}

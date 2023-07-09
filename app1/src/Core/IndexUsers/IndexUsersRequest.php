<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

use App\Core\Shared\ValueObject\Paginator;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class IndexUsersRequest
{
    public function __construct(#[Assert\Valid] public Paginator $paginator)
    {
    }
}

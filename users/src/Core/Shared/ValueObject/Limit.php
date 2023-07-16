<?php

declare(strict_types=1);

namespace App\Core\Shared\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class Limit
{
    public function __construct(#[Assert\GreaterThan(1)] public int $limit)
    {
    }
}

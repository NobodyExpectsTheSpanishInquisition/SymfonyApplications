<?php

declare(strict_types=1);

namespace App\Core\Shared\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class Offset
{
    public function __construct(#[Assert\PositiveOrZero] public int $offset)
    {
    }
}

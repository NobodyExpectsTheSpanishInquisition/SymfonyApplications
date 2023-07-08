<?php

declare(strict_types=1);

namespace App\Core\Shared\ValueObject;

final readonly class Uuid
{
    public function __construct(public string $uuid)
    {
    }
}

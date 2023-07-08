<?php

declare(strict_types=1);

namespace App\Core\Shared\ValueObject;

final readonly class Email
{
    public function __construct(public string $email)
    {
    }
}

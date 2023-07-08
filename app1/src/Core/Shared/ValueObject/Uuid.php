<?php

declare(strict_types=1);

namespace App\Core\Shared\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class Uuid
{
    public function __construct(
        #[Assert\Uuid(options: ['versions' => [Assert\Uuid::V4_RANDOM]])] public string $uuid
    ) {
    }
}

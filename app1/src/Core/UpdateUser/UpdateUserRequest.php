<?php

declare(strict_types=1);

namespace App\Core\UpdateUser;

use App\Core\Shared\ValueObject\Email;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateUserRequest
{
    public function __construct(
        #[Assert\Valid] public Email $email,
    ) {
    }
}

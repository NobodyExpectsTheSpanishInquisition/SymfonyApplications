<?php

declare(strict_types=1);

namespace App\Core\CreateUser\Presentation;

use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateUserRequest
{
    public function __construct(
        #[Assert\Valid] public Uuid $id,
        #[Assert\Valid] public Email $email
    ) {

    }
}

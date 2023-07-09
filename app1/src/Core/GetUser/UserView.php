<?php

declare(strict_types=1);

namespace App\Core\GetUser;

use JsonSerializable;

final readonly class UserView implements JsonSerializable
{
    public function __construct(public string $id, public string $email)
    {
    }

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
        ];
    }
}

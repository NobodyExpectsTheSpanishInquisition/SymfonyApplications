<?php

declare(strict_types=1);

namespace App\Core\Shared\Dpi;

use App\Core\GetUser\GetUserHandler;
use App\Core\GetUser\GetUserQuery;
use App\Core\Shared\ValueObject\Uuid;
use App\Core\Shared\View\UserView;

final readonly class UserDpi implements UserDpiInterface
{
    public function __construct(private GetUserHandler $getUserHandler)
    {
    }

    /**
     * @inheritDoc
     */
    public function getById(Uuid $uuid): UserView
    {
        try {
            return $this->getUserHandler->handle(new GetUserQuery($uuid));
        } catch (\App\Core\Shared\Repository\Exception\NotFoundException $e) {
            throw new NotFoundException($e->getMessage());
        }
    }
}

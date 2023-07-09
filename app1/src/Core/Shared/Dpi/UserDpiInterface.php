<?php

declare(strict_types=1);

namespace App\Core\Shared\Dpi;

use App\Core\Shared\ValueObject\Uuid;
use App\Core\Shared\View\UserView;

interface UserDpiInterface
{
    /**
     * @throws NotFoundException
     */
    public function getById(Uuid $uuid): UserView;
}

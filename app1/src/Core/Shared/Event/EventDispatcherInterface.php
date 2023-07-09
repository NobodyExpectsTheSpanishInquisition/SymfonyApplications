<?php

declare(strict_types=1);

namespace App\Core\Shared\Event;

interface EventDispatcherInterface extends EventStoreInterface
{
    public function dispatch(): void;
}

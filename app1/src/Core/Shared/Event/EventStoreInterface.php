<?php

declare(strict_types=1);

namespace App\Core\Shared\Event;

interface EventStoreInterface
{
    public function push(EventInterface $event): void;
}

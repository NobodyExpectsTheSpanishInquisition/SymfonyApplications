<?php

declare(strict_types=1);

namespace App\Core\Shared\Event;

interface QueueClientInterface
{
    public function pushOnQueue(EventInterface $event): void;
}

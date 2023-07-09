<?php

declare(strict_types=1);

namespace App\Tests\Stub;

use App\Core\Shared\Event\EventInterface;
use App\Core\Shared\Event\QueueClientInterface;

final class QueueClientStub implements QueueClientInterface
{
    /**
     * @var array<int, EventInterface> $dispatchedEvents
     */
    private array $dispatchedEvents;

    public function __construct()
    {
        $this->dispatchedEvents = [];
    }

    public function pushOnQueue(EventInterface $event): void
    {
        $this->dispatchedEvents[] = $event;
    }

    /**
     * @param class-string<EventInterface> $eventClassName
     */
    public function wasEventPushed(string $eventClassName): bool
    {
        foreach ($this->dispatchedEvents as $dispatchedEvent) {
            if ($dispatchedEvent instanceof $eventClassName) {
                return true;
            }
        }

        return false;
    }
}

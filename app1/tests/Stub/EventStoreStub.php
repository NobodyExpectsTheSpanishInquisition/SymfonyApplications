<?php

declare(strict_types=1);

namespace App\Tests\Stub;

use App\Core\Shared\Event\EventInterface;

final class EventStoreStub implements \App\Core\Shared\Event\EventStoreInterface
{
    /**
     * @var array<int, EventInterface> $storedEvents
     */
    private array $storedEvents;

    public function __construct()
    {
        $this->storedEvents = [];
    }

    public function push(EventInterface $event): void
    {
        $this->storedEvents[] = $event;
    }

    /**
     * @return array<int, EventInterface>
     */
    public function getStoredEvents(): array
    {
        return $this->storedEvents;
    }
}

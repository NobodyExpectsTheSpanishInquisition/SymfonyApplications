<?php

declare(strict_types=1);

namespace App\Core\Shared\Event;

final class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array<int, EventInterface>
     */
    private array $events = [];

    public function __construct(private QueueClientInterface $client)
    {
    }

    public function dispatch(): void
    {
        foreach ($this->events as $event) {
            $this->client->pushOnQueue($event);
        }

        $this->events = [];
    }

    public function push(EventInterface $event): void
    {
        $this->events[] = $event;
    }
}

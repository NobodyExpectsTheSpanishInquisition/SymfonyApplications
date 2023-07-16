<?php

declare(strict_types=1);

namespace App\Core\Shared\Event;

use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerQueueClient implements QueueClientInterface
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function pushOnQueue(EventInterface $event): void
    {
        $this->messageBus->dispatch($event);
    }
}

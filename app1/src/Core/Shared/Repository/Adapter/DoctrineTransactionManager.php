<?php

declare(strict_types=1);

namespace App\Core\Shared\Repository\Adapter;

use App\Core\Shared\Repository\Exception\TransactionException;
use App\Core\Shared\Repository\Port\TransactionManagerInterface;
use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

final readonly class DoctrineTransactionManager implements TransactionManagerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function wrapInTransaction(Closure $closure): void
    {
        try {
            $this->entityManager->wrapInTransaction($closure);
        } catch (Throwable $e) {
            throw new TransactionException($e->getMessage());
        }
    }
}

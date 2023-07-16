<?php

declare(strict_types=1);

namespace App\Tests;

use App\Core\Shared\Event\QueueClientInterface;
use App\Core\Shared\Repository\Exception\TransactionException;
use App\Core\Shared\Repository\Port\TransactionManagerInterface;
use App\Tests\Stub\QueueClientStub;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTestCase extends KernelTestCase
{
    protected QueueClientStub $queueClientStub;

    protected function beginTransaction(): void
    {
        $this->getEntityManager()->beginTransaction();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return self::getContainer()->get(EntityManagerInterface::class);
    }

    protected function rollbackTransaction(): void
    {
        $this->getEntityManager()->rollback();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->replaceQueueClientWithStub();
    }

    private function replaceQueueClientWithStub(): void
    {
        $queueClientStub = new QueueClientStub();

        self::getContainer()->set(QueueClientInterface::class, $queueClientStub);

        $this->queueClientStub = $queueClientStub;
    }

    protected function mockTransactionManagerFailure(): MockObject|TransactionManagerInterface
    {
        $transactionManagerMock = $this->createMock(TransactionManagerInterface::class);
        $transactionManagerMock
            ->method('wrapInTransaction')
            ->willThrowException(new TransactionException());

        return $transactionManagerMock;
    }
}

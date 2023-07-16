<?php

declare(strict_types=1);

namespace App\Core\Shared\Repository\Port;

use App\Core\Shared\Repository\Exception\TransactionException;
use Closure;

interface TransactionManagerInterface
{
    /**
     * @throws TransactionException
     */
    public function wrapInTransaction(Closure $closure): void;
}

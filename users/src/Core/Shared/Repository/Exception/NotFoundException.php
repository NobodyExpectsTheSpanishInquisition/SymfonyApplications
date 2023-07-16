<?php

declare(strict_types=1);

namespace App\Core\Shared\Repository\Exception;

use Exception;

final class NotFoundException extends Exception
{
    /**
     * @param class-string $targetClassName
     */
    public static function notFoundById(string $id, string $targetClassName): self
    {
        return new self(sprintf('Target: %s not found by id: %s', $targetClassName, $id));
    }
}

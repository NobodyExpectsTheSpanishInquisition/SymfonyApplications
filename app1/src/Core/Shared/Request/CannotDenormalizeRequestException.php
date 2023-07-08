<?php

declare(strict_types=1);

namespace App\Core\Shared\Request;

use LogicException;

final class CannotDenormalizeRequestException extends LogicException
{
    /**
     * @param array<int, string> $requiredFields
     */
    public static function becauseRequiredFieldsAreMissing(array $requiredFields)
    {
        return new self(sprintf('Required fields are missing. Required fields: %s.', implode(', ', $requiredFields)));
    }
}

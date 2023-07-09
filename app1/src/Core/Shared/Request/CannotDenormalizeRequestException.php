<?php

declare(strict_types=1);

namespace App\Core\Shared\Request;

use LogicException;

final class CannotDenormalizeRequestException extends LogicException
{
    /**
     * @param array<int, string> $missingFields
     */
    public static function becauseRequiredFieldsAreMissing(array $missingFields): self
    {
        return new self(sprintf('Required fields are missing. Missing fields: %s.', implode(', ', $missingFields)));
    }

    /**
     * @param array<int, string> $violations
     */
    public static function becauseRequestViolatesRules(array $violations): self
    {
        return new self(sprintf('Request violates rules. Violated rules: %s', implode(', ', $violations)));
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Shared\Request;

use Symfony\Component\Validator\ConstraintViolationListInterface;

final readonly class ViolationsExtractor
{
    /**
     * @return array<int<0, max>, string>
     */
    public function extractToArray(ConstraintViolationListInterface $violationList): array
    {
        $numberOfViolations = $violationList->count();
        $violationsArray = [];

        for ($i = 0; $i < $numberOfViolations; $i++) {
            $violationsArray[] = (string) $violationList->get($i)->getMessage();
        }

        return $violationsArray;
    }
}

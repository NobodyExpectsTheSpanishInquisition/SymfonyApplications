<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

use App\Core\Shared\Request\CannotDenormalizeRequestException;
use App\Core\Shared\Request\ViolationsExtractor;
use App\Core\Shared\ValueObject\Limit;
use App\Core\Shared\ValueObject\Offset;
use App\Core\Shared\ValueObject\Paginator;
use LogicException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class IndexUsersRequestDenormalizer
{
    private const OFFSET_FIELD = 'offset';

    private const LIMiT_FIELD = 'limit';

    private const REQUIRED_FIELDS = [
        self::OFFSET_FIELD,
        self::LIMiT_FIELD,
    ];

    public function __construct(private ViolationsExtractor $violationsExtractor, private ValidatorInterface $validator)
    {
    }

    /**
     * @param array<string, string> $data
     * @return IndexUsersRequest
     * @throws CannotDenormalizeRequestException
     */
    public function denormalize(array $data): IndexUsersRequest
    {
        $missingRequiredFields = $this->findMissingRequiredFields($data);

        if (0 !== count($missingRequiredFields)) {
            throw CannotDenormalizeRequestException::becauseRequiredFieldsAreMissing($missingRequiredFields);
        }

        try {
            $request = new IndexUsersRequest(
                new Paginator(
                    new Offset((int) $data[self::OFFSET_FIELD]),
                    new Limit((int) $data[self::LIMiT_FIELD])
                )
            );
        } catch (LogicException $e) {
            throw CannotDenormalizeRequestException::becausePaginationIsIncorrect($e->getMessage());
        }

        $violations = $this->validator->validate($request);

        if (0 !== $violations->count()) {
            throw CannotDenormalizeRequestException::becauseRequestViolatesRules(
                $this->violationsExtractor->extractToArray($violations)
            );
        }

        return $request;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<int, string>
     */
    private function findMissingRequiredFields(array $data): array
    {
        $missingFields = [];

        foreach (self::REQUIRED_FIELDS as $requiredField) {
            if (false === array_key_exists($requiredField, $data)) {
                $missingFields[] = $requiredField;
            }
        }

        return $missingFields;
    }
}

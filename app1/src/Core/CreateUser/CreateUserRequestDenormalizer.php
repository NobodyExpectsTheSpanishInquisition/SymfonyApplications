<?php

declare(strict_types=1);

namespace App\Core\CreateUser;

use App\Core\Shared\Request\CannotDenormalizeRequestException;
use App\Core\Shared\Request\ViolationsExtractor;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class CreateUserRequestDenormalizer
{
    private const ID_FIELD = 'id';

    private const EMAIL_FIELD = 'email';

    private const REQUIRED_FIELDS = [
        self::ID_FIELD,
        self::EMAIL_FIELD,
    ];

    public function __construct(private ValidatorInterface $validator, private ViolationsExtractor $violationsExtractor)
    {
    }

    /**
     * @param array<string, mixed> $data
     * @throws CannotDenormalizeRequestException
     */
    public function denormalize(array $data): CreateUserRequest
    {
        $missingRequiredFields = $this->findMissingRequiredFields($data);

        if (0 !== count($missingRequiredFields)) {
            throw CannotDenormalizeRequestException::becauseRequiredFieldsAreMissing($missingRequiredFields);
        }

        $request = new CreateUserRequest(new Uuid($data['id']), new Email($data['email']));

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

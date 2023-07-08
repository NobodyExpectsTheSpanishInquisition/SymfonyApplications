<?php

declare(strict_types=1);

namespace App\Core\CreateUser\Presentation;

use App\Core\Shared\Request\CannotDenormalizeRequestException;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class CreateUserRequestDenormalizer
{
    private const ID_FIELD = 'id';
    private const EMAIL_FIELD = 'email';
    private const REQUIRED_FIELDS = [
        self::ID_FIELD,
        self::EMAIL_FIELD
    ];

    public function __construct(private ValidatorInterface $validator)
    {
    }

    /**
     * @param array<string, string> $data
     * @throws CannotDenormalizeRequestException
     */
    public function denormalize(array $data): CreateUserRequest
    {
        if (false === $this->hasAllRequiredFields($data)) {
            throw CannotDenormalizeRequestException::becauseRequiredFieldsAreMissing(self::REQUIRED_FIELDS);
        }

        $request = new CreateUserRequest(new Uuid($data['id']), new Email($data['email']));

        $violations = $this->validator->validate($request);

        if (0 !== $violations->count()) {
            throw CannotDenormalizeRequestException::becauseRequestViolatesRules((string) $violations);
        }

        return $request;

    }

    private function hasAllRequiredFields(array $data): bool
    {
        foreach (self::REQUIRED_FIELDS as $requiredField) {
            if (false === array_key_exists($requiredField, $data)) {
                return false;
            }
        }

        return true;
    }
}

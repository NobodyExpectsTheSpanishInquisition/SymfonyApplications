<?php

declare(strict_types=1);

namespace App\Tests\Core\Shared\Validator;

use App\Core\CreateUser\UserFactory;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UniqueEmailValidatorTestData
{
    public function __construct(private UserFactory $userFactory, private EntityManagerInterface $entityManager)
    {
    }

    public function loadUserWithEmail(Email $email): void
    {
        $user = $this->userFactory->create($this->getUserId(), $email);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function getEmail(): Email
    {
        return new Email('test@gmail.com');
    }

    private function getUserId(): Uuid
    {
        return new Uuid('F0CBA341-B808-445C-8942-5CF48D3D9EE4');
    }
}

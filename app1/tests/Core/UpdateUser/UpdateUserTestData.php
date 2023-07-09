<?php

declare(strict_types=1);

namespace App\Tests\Core\UpdateUser;

use App\Core\CreateUser\UserFactory;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
use App\Core\UpdateUser\UpdateUserCommand;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UpdateUserTestData
{
    public function __construct(private EntityManagerInterface $entityManager, private UserFactory $userFactory)
    {
    }

    public function loadUserWithEmail(Uuid $userId, Email $email): void
    {
        $user = $this->userFactory->create($userId, $email);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function getCommand(): UpdateUserCommand
    {
        return new UpdateUserCommand($this->getUserOneId(), $this->getEmailTwo());
    }

    public function getUserOneId(): Uuid
    {
        return new Uuid('10D5312C-47CF-42FC-A5A2-794BB91AAB8F');
    }

    public function getEmailTwo(): Email
    {
        return new Email('test2@email.com');
    }

    public function getUserTwoId(): Uuid
    {
        return new Uuid('C9C04106-FBC5-4486-9044-6A28C960140E');
    }

    public function getEmailOne(): Email
    {
        return new Email('test1@email.com');
    }
}

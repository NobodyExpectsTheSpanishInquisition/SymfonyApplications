<?php

declare(strict_types=1);

namespace App\Tests\Core\DeleteUser;

use App\Core\CreateUser\UserFactory;
use App\Core\DeleteUser\DeleteUserCommand;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DeleteUserTestData
{
    public function __construct(private EntityManagerInterface $entityManager, private UserFactory $userFactory)
    {
    }

    public function loadUser(): void
    {
        $user = $this->userFactory->create($this->getUserId(), new Email('5D545D8B-528A-4706-9C46-694EDFC39388'));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function getUserId(): Uuid
    {
        return new Uuid('F6ABC301-A0FD-472A-90BA-F21270C1DDB3');
    }

    public function getCommand(): DeleteUserCommand
    {
        return new DeleteUserCommand($this->getUserId());
    }
}

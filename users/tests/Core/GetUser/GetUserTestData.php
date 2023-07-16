<?php

declare(strict_types=1);

namespace App\Tests\Core\GetUser;

use App\Core\CreateUser\UserFactory;
use App\Core\GetUser\GetUserQuery;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
use App\Core\Shared\View\UserView;
use Doctrine\ORM\EntityManagerInterface;

final readonly class GetUserTestData
{
    public function __construct(
        private UserFactory $userFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function loadData(): void
    {
        $user = $this->userFactory->create($this->getUserId(), $this->getEmail());

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function getUserId(): Uuid
    {
        return new Uuid('351D967B-8463-4ED9-9C32-E1E91AE2EA22');
    }

    public function getExpectedUser(): UserView
    {
        return new UserView($this->getUserId()->uuid, $this->getEmail()->email);
    }

    public function getQuery(): GetUserQuery
    {
        return new GetUserQuery($this->getUserId());
    }

    private function getEmail(): Email
    {
        return new Email('test@email.com');
    }
}

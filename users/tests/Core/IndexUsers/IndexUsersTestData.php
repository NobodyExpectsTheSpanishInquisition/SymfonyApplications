<?php

declare(strict_types=1);

namespace App\Tests\Core\IndexUsers;

use App\Core\CreateUser\UserFactory;
use App\Core\IndexUsers\IndexUsersQuery;
use App\Core\IndexUsers\UsersListView;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Limit;
use App\Core\Shared\ValueObject\Offset;
use App\Core\Shared\ValueObject\Paginator;
use App\Core\Shared\ValueObject\Uuid;
use App\Core\Shared\View\UserView;
use Doctrine\ORM\EntityManagerInterface;

final readonly class IndexUsersTestData
{
    private const OFFSET = 0;

    private const LIMIT = 5;

    public function __construct(private EntityManagerInterface $entityManager, private UserFactory $userFactory)
    {
    }

    public function getExpectedFilledUsersList(): string
    {
        return json_encode(
            new UsersListView(
                [
                    new UserView(
                        $this->getUserOneId()->uuid,
                        $this->getUserOneEmail()->email,
                    ),
                    new UserView(
                        $this->getUserTwoId()->uuid,
                        $this->getUserTwoEmail()->email,
                    ),
                    new UserView(
                        $this->getUserThreeId()->uuid,
                        $this->getUserThreeEmail()->email,
                    ),
                ],
                3
            )
        );
    }

    public function getExpectedEmptyUsersList(): string
    {
        return json_encode(new UsersListView(users: [], totalUsers: 0));
    }

    public function loadUsers(): void
    {
        $userOne = $this->userFactory->create($this->getUserOneId(), $this->getUserOneEmail());
        $userTwo = $this->userFactory->create($this->getUserTwoId(), $this->getUserTwoEmail());
        $userThree = $this->userFactory->create($this->getUserThreeId(), $this->getUserThreeEmail());

        $this->entityManager->persist($userOne);
        $this->entityManager->persist($userTwo);
        $this->entityManager->persist($userThree);

        $this->entityManager->flush();
    }

    public function getQuery(): IndexUsersQuery
    {
        return new IndexUsersQuery(new Paginator($this->getOffset(), $this->getLimit()));
    }

    public function getOffset(): Offset
    {
        return new Offset(self::OFFSET);
    }

    public function getLimit(): Limit
    {
        return new Limit(self::LIMIT);
    }

    public function loadMoreUsersThanLimitAllowsToReturn(): void
    {
        $userOne = $this->userFactory->create($this->getUserOneId(), $this->getUserOneEmail());
        $userTwo = $this->userFactory->create($this->getUserTwoId(), $this->getUserTwoEmail());
        $userThree = $this->userFactory->create($this->getUserThreeId(), $this->getUserThreeEmail());
        $userFour = $this->userFactory->create($this->getUserFourId(), $this->getUserFourEmail());
        $userFive = $this->userFactory->create($this->getUserFiveId(), $this->getUserFiveEmail());
        $userSix = $this->userFactory->create($this->getUserSixId(), $this->getUserSixEmail());

        $this->entityManager->persist($userOne);
        $this->entityManager->persist($userTwo);
        $this->entityManager->persist($userThree);
        $this->entityManager->persist($userFour);
        $this->entityManager->persist($userFive);
        $this->entityManager->persist($userSix);

        $this->entityManager->flush();
    }

    private function getUserOneId(): Uuid
    {
        return new Uuid('59BA5AB4-5219-4413-A2CB-1AC0B3E9FC1C');
    }

    private function getUserOneEmail(): Email
    {
        return new Email('test1@email.com');
    }

    private function getUserTwoId(): Uuid
    {
        return new Uuid('D278A624-C2BF-421E-962B-23EEC4070711');
    }

    private function getUserTwoEmail(): Email
    {
        return new Email('test2@email.com');
    }

    private function getUserThreeId(): Uuid
    {
        return new Uuid('7841B2A5-611C-4A90-82CE-0587BEB75F1C');
    }

    private function getUserThreeEmail(): Email
    {
        return new Email('test2@email.com');
    }

    private function getUserFourId(): Uuid
    {
        return new Uuid('9827A4C9-2407-424F-8E79-4E1A55AA0F95');
    }

    private function getUserFourEmail(): Email
    {
        return new Email('test4@email.com');
    }

    private function getUserFiveId(): Uuid
    {
        return new Uuid('729C39C0-FB18-4ADF-B541-411E9C8DB678');
    }

    private function getUserFiveEmail(): Email
    {
        return new Email('test5@email.com');
    }

    private function getUserSixId(): Uuid
    {
        return new Uuid('89B4552B-1024-4C84-BC1A-118269A18CA4');
    }

    private function getUserSixEmail(): Email
    {
        return new Email('test6@email.com');
    }
}

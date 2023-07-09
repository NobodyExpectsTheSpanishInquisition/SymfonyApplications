<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

use App\Core\Shared\Entity\User;
use App\Core\Shared\ValueObject\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use LogicException;

final readonly class DoctrineIndexUsersRepository implements UsersListRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function get(Paginator $paginator): array
    {
        $qb = $this->getBaseQuery();

        $qb->select('user')
            ->setFirstResult($paginator->offset->offset)
            ->setMaxResults($paginator->limit->limit);

        /** @var array<int, User> */
        return $qb->getQuery()->getResult();
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        $qb = $this->getBaseQuery();

        $qb->select($qb->expr()->count('user.id'));

        try {
            return (int) $qb->getQuery()->getSingleScalarResult();
        } catch (NoResultException | NonUniqueResultException $e) {
            throw new LogicException($e->getMessage());
        }
    }

    private function getBaseQuery(): QueryBuilder
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->from(User::class, 'user');

        return $qb;
    }
}

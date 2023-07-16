<?php

declare(strict_types=1);

namespace App\Core\Shared\Repository\Adapter;

use App\Core\Shared\Entity\User;
use App\Core\Shared\Validator\EmailValidatorDpiInterface;
use App\Core\Shared\ValueObject\Email;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

final readonly class DoctrineEmailValidatorRepository implements EmailValidatorDpiInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function findByEmail(Email $email): ?User
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('user')
            ->from(User::class, 'user')
            ->andWhere($qb->expr()->eq('user.email', ':email'))
            ->setParameter('email', $email->email);

        try {
            /** @var User */
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException | NonUniqueResultException) {
            return null;
        }
    }
}

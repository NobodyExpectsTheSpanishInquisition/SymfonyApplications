<?php

declare(strict_types=1);

namespace App\Core\Shared\Entity;

use App\Core\Shared\Event\EventStoreInterface;
use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
use App\Core\UpdateUser\CannotUpdateUserException;
use App\Core\UpdateUser\UpdateUserAssertions;
use App\Core\UpdateUser\UserUpdated;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID)]
    private readonly string $id;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private string $email;

    public function __construct(Uuid $id, Email $email)
    {
        $this->id = $id->uuid;
        $this->email = $email->email;
    }

    /**
     * @throws CannotUpdateUserException
     */
    public function edit(Email $email, UpdateUserAssertions $updateUserValidator, EventStoreInterface $eventStore): void
    {
        $updateUserValidator->validate($email);

        $this->editEmail($email);

        $eventStore->push(new UserUpdated($this->getId()->uuid, $this->getEmail()->email));
    }

    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getEmail(): Email
    {
        return new Email($this->email);
    }

    private function editEmail(Email $email): void
    {
        $this->email = $email->email;
    }
}

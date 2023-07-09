<?php

declare(strict_types=1);

namespace App\Core\Shared\Entity;

use App\Core\Shared\ValueObject\Email;
use App\Core\Shared\ValueObject\Uuid;
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

    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }


    public function getEmail(): Email
    {
        return new Email($this->email);
    }
}

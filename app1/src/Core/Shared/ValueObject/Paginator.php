<?php

declare(strict_types=1);

namespace App\Core\Shared\ValueObject;

use LogicException;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class Paginator
{
    /**
     * @throws LogicException
     */
    public function __construct(
        #[Assert\Valid] public Offset $offset,
        #[Assert\Valid] public Limit $limit,
    ) {
        $this->assert();
    }

    /**
     * @throws LogicException
     */
    private function assert(): void
    {
        if ($this->offset > $this->limit) {
            throw new LogicException("Offset has to be lower or equals to limit.");
        }
    }
}

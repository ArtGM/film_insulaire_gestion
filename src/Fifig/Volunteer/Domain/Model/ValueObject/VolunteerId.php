<?php

namespace Fifig\Volunteer\Domain\Model\ValueObject;

use Symfony\Component\Uid\Uuid;

class VolunteerId implements \Stringable
{

    private function __construct(private string $id)
    {
    }

    public static function create(): self
    {
        return new self(Uuid::v4());
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
<?php

namespace Fifig\Volunteer\Domain\Model\ValueObject;

use Symfony\Component\Uid\Uuid;

class VolunteerId
{

    private function __construct(private string $id)
    {
    }

    public static function create(): self
    {
        return new self(Uuid::v4());
    }

}
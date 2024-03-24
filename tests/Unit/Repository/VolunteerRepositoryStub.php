<?php

namespace App\Tests\Unit\Repository;

use Fifig\Volunteer\Domain\Model\ValueObject\VolunteerId;
use Fifig\Volunteer\Domain\Model\Volunteer;
use Fifig\Volunteer\Domain\Repository\VolunteerRepository;

class VolunteerRepositoryStub implements VolunteerRepository
{
    private array $volunteers = [];

    public function save(Volunteer $volunteer): void
    {
        $this->volunteers[$volunteer->getId()->__toString()] = $volunteer;
    }

    public function get(VolunteerId $volunteerId): ?Volunteer
    {
        return $this->volunteers[$volunteerId->__toString()] ?? null;
    }
}
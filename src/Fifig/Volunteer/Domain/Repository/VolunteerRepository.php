<?php

namespace Fifig\Volunteer\Domain\Repository;
use Fifig\Volunteer\Domain\Model\ValueObject\VolunteerId;
use Fifig\Volunteer\Domain\Model\Volunteer;

interface VolunteerRepository
{

    public function save(Volunteer $volunteer): void;

    public function get(VolunteerId $volunteerId): ?Volunteer;

}
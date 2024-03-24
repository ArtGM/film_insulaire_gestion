<?php

namespace Fifig\Volunteer\Domain\Model;

use Fifig\Volunteer\Domain\Model\Entity\Availabilities;
use Fifig\Volunteer\Domain\Model\Entity\Team;
use Fifig\Volunteer\Domain\Model\Entity\VolunteerInformation;
use Fifig\Volunteer\Domain\Model\ValueObject\VolunteerId;

class Volunteer
{
    public function __construct(
        private VolunteerId $id,
        private VolunteerInformation $volunteerInformations,
        private Availabilities $disponibilities
    )
    {
    }


    public function getId(): VolunteerId
    {
        return $this->id;
    }

    public function getInformations(): VolunteerInformation
    {
        return $this->volunteerInformations;
    }

    public function getDisponibilities(): Availabilities
    {
        return $this->disponibilities;
    }

    public function getTeam()
    {
        return new Team();
    }
}
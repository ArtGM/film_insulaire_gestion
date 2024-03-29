<?php

namespace Fifig\Volunteer\Domain\Model;

use Fifig\Volunteer\Domain\Model\ValueObject\Availabilities;
use Fifig\Volunteer\Domain\Model\ValueObject\Team;
use Fifig\Volunteer\Domain\Model\ValueObject\VolunteerInformation;
use Fifig\Volunteer\Domain\Model\ValueObject\VolunteerId;

readonly class Volunteer
{
    public function __construct(
        private VolunteerId          $id,
        private VolunteerInformation $volunteerInformation,
        private Availabilities $availabilities,
        private Team $team
    )
    {
    }


    public function getId(): VolunteerId
    {
        return $this->id;
    }

    public function getInformations(): VolunteerInformation
    {
        return $this->volunteerInformation;
    }

    public function getAvailabilities(): Availabilities
    {
        return $this->availabilities;
    }

    public function getTeam()
    {
        return $this->team;
    }
}
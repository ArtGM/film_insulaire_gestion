<?php


use Fifig\Volunteer\Domain\Model\Entity\Availabilities;
use Fifig\Volunteer\Domain\Model\Entity\Team;
use Fifig\Volunteer\Domain\Model\Entity\VolunteerInformation;
use Fifig\Volunteer\Domain\Model\Volunteer;
use Fifig\Volunteer\Domain\Model\ValueObject\VolunteerId;
use Symfony\Component\Uid\Uuid;

it('can create a volunteer', function () {
    $volunteer = new Volunteer(
        id: VolunteerId::create(),
        volunteerInformations: new VolunteerInformation(),
        disponibilities: new Availabilities(),
    );

    expect($volunteer)->toBeInstanceOf(Volunteer::class)
    ->and($volunteer->getId())->toBeInstanceOf(VolunteerId::class)
    ->and($volunteer->getInformations())->toBeInstanceOf(VolunteerInformation::class)
    ->and($volunteer->getDisponibilities())->toBeInstanceOf(Availabilities::class)
    ->and($volunteer->getTeam())->toBeInstanceOf(Team::class);
});
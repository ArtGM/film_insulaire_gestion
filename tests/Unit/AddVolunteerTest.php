<?php


use Fifig\Volunteer\Domain\Model\Entity\Availabilities;
use Fifig\Volunteer\Domain\Model\Entity\Team;
use Fifig\Volunteer\Domain\Model\Entity\VolunteerInformation;
use Fifig\Volunteer\Domain\Model\Volunteer;
use Fifig\Volunteer\Domain\Model\ValueObject\VolunteerId;
use App\Tests\Unit\Repository\VolunteerRepositoryStub;

it('can create a volunteer', function () {
    $volunteer = aVolunteer();

    expect($volunteer)->toBeInstanceOf(Volunteer::class)
    ->and($volunteer->getId())->toBeInstanceOf(VolunteerId::class)
    ->and($volunteer->getInformations())->toBeInstanceOf(VolunteerInformation::class)
    ->and($volunteer->getAvailabilities())->toBeInstanceOf(Availabilities::class)
    ->and($volunteer->getTeam())->toBeInstanceOf(Team::class);


});

it('can save a volunteer', function () {
    $volunteer = aVolunteer();

    $volunteerRepository = new VolunteerRepositoryStub();

    $volunteerRepository->save($volunteer);

    expect($volunteerRepository->get($volunteer->getId()))->toBe($volunteer);

});


function aVolunteer(): Volunteer
{
    return new Volunteer(
        VolunteerId::create(),
        new VolunteerInformation(),
        new Availabilities(),
        new Team()
    );
}
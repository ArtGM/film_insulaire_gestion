<?php


use Fifig\Volunteer\Domain\Model\Entity\Team;
use Fifig\Volunteer\Domain\Model\Volunteer;

it('can add a volunteer', function () {
    $volunteer = new Volunteer(
        id: Uu
    );

    expect($volunteer)->toBeInstanceOf(Volunteer::class)
    ->and($volunteer->getId())->toBeUuid()
    ->and($volunteer->getInformations())->toBeArray()
    ->and($volunteer->getDisponibilities())->toBeArray()
    ->and($volunteer->getTeam())->toBeInstanceOf(Team::class);

});
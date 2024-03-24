<?php


use Fifig\Volunteer\Domain\Model\Volunteer;

it('can add a volunteer', function () {
    $volunteer = new Volunteer();

    expect($volunteer)->toBeInstanceOf(Volunteer::class)
    ->and($volunteer->getId())->toBeUuid()
    ->and($volunteer->getInformations())->toBeArray()
    ->and($volunteer->getDisponibilities())->toBeArray()
    ->and(($volunteer->getTeam())->toBeInstanceOf(Team::class));

});
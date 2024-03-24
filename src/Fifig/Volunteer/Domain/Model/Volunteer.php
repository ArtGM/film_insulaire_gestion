<?php

namespace Fifig\Volunteer\Domain\Model;

use Fifig\Volunteer\Domain\Model\Entity\Team;

class Volunteer
{

    public function getId()
    {
        return '123e4567-e89b-12d3-a456-426614174000';
    }

    public function getInformations()
    {
        return [];
    }

    public function getDisponibilities()
    {
        return [];
    }

    public function getTeam()
    {
        return new Team();
    }
}
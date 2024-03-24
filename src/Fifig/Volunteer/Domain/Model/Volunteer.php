<?php

namespace Fifig\Volunteer\Domain\Model;

use Fifig\Volunteer\Domain\Model\Entity\Team;

class Volunteer
{
    public function __construct(
        private string $id
    )
    {
    }


    public function getId()
    {
        return $this->id;
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
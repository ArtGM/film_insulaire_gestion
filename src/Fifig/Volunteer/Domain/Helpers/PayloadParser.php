<?php

namespace Fifig\Volunteer\Domain\Helpers;

interface PayloadParser
{
    public function parse(string $payload): array;
}
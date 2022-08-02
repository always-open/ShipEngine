<?php

namespace AlwaysOpen\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ParsedAddress extends DataTransferObject
{
    public float $score;
    public Address $address;
    public array $entities;
}

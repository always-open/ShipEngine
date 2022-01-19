<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use BluefynInternational\ShipEngine\DTO\Validators\MaxLength;
use BluefynInternational\ShipEngine\DTO\Validators\MinLength;
use Spatie\DataTransferObject\DataTransferObject;

class ParsedAddress extends DataTransferObject
{
    public float $score;
    public Address $address;
    public array $entities;
}

<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use Spatie\DataTransferObject\DataTransferObject;

class Dimensions extends DataTransferObject
{
    #[InArray(['inch', 'centimeter'])]
    public string $unit;
    #[GreaterThanOrEquals(0)]
    public float $length;
    #[GreaterThanOrEquals(0)]
    public float $width;
    #[GreaterThanOrEquals(0)]
    public float $height;
}

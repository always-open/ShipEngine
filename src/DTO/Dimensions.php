<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
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

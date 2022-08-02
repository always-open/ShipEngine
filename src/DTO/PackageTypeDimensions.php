<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use Spatie\DataTransferObject\DataTransferObject;

class PackageTypeDimensions extends DataTransferObject
{
    public string $unit;
    #[GreaterThanOrEquals(0)]
    public float $length;
    #[GreaterThanOrEquals(0)]
    public float $width;
    #[GreaterThanOrEquals(0)]
    public float $height;
}

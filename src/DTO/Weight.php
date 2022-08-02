<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
use Spatie\DataTransferObject\DataTransferObject;

class Weight extends DataTransferObject
{
    #[GreaterThanOrEquals(0)]
    public float $value;
    #[InArray(\AlwaysOpen\ShipEngine\Util\Constants\Weight::ALL_SOURCES)]
    public string $unit;
}

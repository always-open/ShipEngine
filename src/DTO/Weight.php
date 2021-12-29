<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use Spatie\DataTransferObject\DataTransferObject;

class Weight extends DataTransferObject
{
    #[GreaterThanOrEquals(0)]
    public float $value;
    #[InArray(\BluefynInternational\ShipEngine\Util\Constants\Weight::ALL_SOURCES)]
    public string $unit;
}

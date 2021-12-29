<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\MinLength;
use Spatie\DataTransferObject\DataTransferObject;

class Tag extends DataTransferObject
{
    #[MinLength(1)]
    public string $name;
}

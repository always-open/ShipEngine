<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\MinLength;
use Spatie\DataTransferObject\DataTransferObject;

class VoidLabel extends DataTransferObject
{
    public bool $approved;
    #[MinLength(0)]
    public string $message;
}

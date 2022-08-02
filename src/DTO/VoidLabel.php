<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\MinLength;
use Spatie\DataTransferObject\DataTransferObject;

class VoidLabel extends DataTransferObject
{
    public bool $approved;
    #[MinLength(0)]
    public string $message;
}

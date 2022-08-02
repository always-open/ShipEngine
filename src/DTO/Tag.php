<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\MinLength;
use Spatie\DataTransferObject\DataTransferObject;

class Tag extends DataTransferObject
{
    #[MinLength(1)]
    public string $name;
}

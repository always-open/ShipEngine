<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\DataTransferObject;

class PackageType extends DataTransferObject
{
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $package_id;
    #[Regex('/^[a-z0-9]+(_[a-z0-9]+)*$/')]
    public string $package_code;
    public string $name;
    public string|null $description;
    public PackageTypeDimensions $dimensions;
}

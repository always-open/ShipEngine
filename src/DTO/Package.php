<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use AlwaysOpen\ShipEngine\DTO\Validators\MinLength;
use AlwaysOpen\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\DataTransferObject;

class Package extends DataTransferObject
{
    public string|null $package_id;
    public string|null $description;
    #[Regex('/^[a-z0-9]+(_[a-z0-9]+)*$/')]
    public string $package_code;
    public Weight $weight;
    public Dimensions $dimensions;
    public CurrencyAmount $insured_value;
    #[MinLength(1, allowNull: true)]
    public string|null $tracking_number;
    public LabelMessages $label_messages;
    #[MinLength(1, allowNull: true)]
    public string|null $external_package_id;
    public LabelDownload|null $label_download;
    #[GreaterThanOrEquals(0)]
    public int|null $sequence;
}

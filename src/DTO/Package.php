<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use BluefynInternational\ShipEngine\DTO\Validators\MinLength;
use BluefynInternational\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class Package extends DataTransferObject
{
    public int $package_id;
    public string|null $description;
    #[Regex('/^[a-z0-9]+(_[a-z0-9]+)*$/')]
    public string $package_code;
    public Weight $weight;
    public Dimensions $dimensions;
    /** @var CurrencyAmount[] */
    #[CastWith(ArrayCaster::class, itemType: CurrencyAmount::class)]
    public array $insured_value;
    #[MinLength(1)]
    public string $tracking_number;
    public LabelMessages $label_messages;
    #[MinLength(1)]
    public string $external_package_id;
    public LabelDownload $label_download;
    #[GreaterThanOrEquals(0)]
    public int $sequence;
}

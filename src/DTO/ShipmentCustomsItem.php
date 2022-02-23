<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use BluefynInternational\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\DataTransferObject;

class ShipmentCustomsItem extends DataTransferObject
{
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $customs_item_id;
    public string|null $description;
    #[GreaterThanOrEquals(0)]
    public int $quantity;
    public CurrencyAmount $value;
    public string|null $harmonized_tariff_code;
    public string|null $country_of_origin;
    public string|null $unit_of_measure;
    public string|null $sku;
    public string|null $sku_description;
}

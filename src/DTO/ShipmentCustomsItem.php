<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use AlwaysOpen\ShipEngine\DTO\Validators\Regex;
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

    public function __construct(...$args)
    {
        $temp = $args;
        if (is_array($temp[0] ?? null)) {
            $temp = $temp[0];
        }

        if (is_float($temp['value'])) {
            $args['value'] = [
                'currency' => 'usd',
                'amount' => $temp['value'],
            ];
        }

        parent::__construct($args);
    }
}

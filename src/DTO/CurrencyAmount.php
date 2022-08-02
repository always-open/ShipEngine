<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
use Spatie\DataTransferObject\DataTransferObject;

class CurrencyAmount extends DataTransferObject
{
    #[InArray(['usd', 'cad', 'aud', 'gbp', 'eur', 'nzd'])]
    public string $currency;
    #[GreaterThanOrEquals(0)]
    public float $amount;
}

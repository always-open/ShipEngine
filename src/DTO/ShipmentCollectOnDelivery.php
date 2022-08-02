<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
use Spatie\DataTransferObject\DataTransferObject;

class ShipmentCollectOnDelivery extends DataTransferObject
{
    #[InArray(['any', 'cash', 'cash_equivalent', 'none'])]
    public string $payment_type;
    public CurrencyAmount $payment_amount;
}

<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
use AlwaysOpen\ShipEngine\Util\Constants\OrderSource;
use Spatie\DataTransferObject\DataTransferObject;

class ShipmentItem extends DataTransferObject
{
    public string $name;
    public string|null $sales_order_id;
    public string|null $sales_order_item_id;
    #[GreaterThanOrEquals(0)]
    public int $quantity;
    public string|null $sku;
    public string|null $external_order_id;
    public string|null $external_order_item_id;
    public string|null $asin;
    #[InArray(OrderSource::ALL_SOURCES)]
    public string $order_source_code;
}

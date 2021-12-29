<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use BluefynInternational\ShipEngine\Util\Constants\OrderSource;
use Spatie\DataTransferObject\DataTransferObject;
use BluefynInternational\ShipEngine\DTO\Validators\GreaterThanOrEquals;

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

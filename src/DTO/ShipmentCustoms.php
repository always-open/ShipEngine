<?php

namespace BluefynInternational\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ShipmentCustoms extends DataTransferObject
{
    public string $contents;
    public string $non_delivery;
    public array $customs_items;
}

<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\DataTransferObject;

class Warehouse extends DataTransferObject
{
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $warehouse_id;
    public string $name;
    #[Regex('/^\d{4}-\d{2}-\d{2}(T\d{2}:\d{2}:\d{2}(\.\d+)?(Z|[-+]\d{2}:\d{2}))?$/')]
    public string $created_at;
    public Address $origin_address;
    public Address $return_address;
}

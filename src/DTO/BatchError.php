<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\DataTransferObject;

class BatchError extends DataTransferObject
{
    public string $error;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $shipment_id;
    public string $external_shipment_id;
}

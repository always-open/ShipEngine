<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
use AlwaysOpen\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class BulkRateResponse extends DataTransferObject
{
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $rate_request_id;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $shipment_id;
    #[Regex('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d+)?(Z|[-+]\d{2}:\d{2})$/')]
    public string $created_at;
    #[InArray(['working', 'completed', 'partial', 'error'])]
    public string $status;
    #[CastWith(ArrayCaster::class, itemType: Error::class)]
    public array $errors;
}

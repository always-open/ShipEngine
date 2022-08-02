<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
use AlwaysOpen\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class RateResponse extends DataTransferObject
{
    #[CastWith(ArrayCaster::class, itemType: ShipmentRate::class)]
    public array $rates;
    #[CastWith(ArrayCaster::class, itemType: ShipmentRate::class)]
    public array $invalid_rates;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $rate_request_id;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $shipment_id;
    public string $created_at;
    #[InArray(['working', 'completed', 'partial', 'error'])]
    public string $status;
    #[CastWith(ArrayCaster::class, itemType: Error::class)]
    public array $errors;
}

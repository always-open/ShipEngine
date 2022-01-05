<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Casters\NullableArrayCaster;
use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use BluefynInternational\ShipEngine\DTO\Validators\MinLength;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class TrackingInformation extends DataTransferObject
{
    #[MinLength(1)]
    public string $tracking_number;
    public string|null $tracking_url;
    #[InArray(['u_n', 'a_c', 'i_t', 'd_e', 'e_x', 'a_t', 'n_y'])]
    public string $status_code;
    public string|null $carrier_code;
    public string|null $carrier_id;
    #[MinLength(0, allowNull: true)]
    public string|null $status_description;
    #[MinLength(1)]
    public string $carrier_status_code;
    public string|null $carrier_detail_code;
    public string|null $carrier_status_description;
    public string|null $ship_date;
    public string $estimated_delivery_date;
    public string|null $actual_delivery_date;
    public string|null $exception_description;

    #[CastWith(NullableArrayCaster::class, itemType: TrackingEvent::class)]
    public array|null $events;
}

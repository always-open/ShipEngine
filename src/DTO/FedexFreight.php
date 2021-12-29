<?php

namespace BluefynInternational\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class FedexFreight extends DataTransferObject
{
    public string $shipper_load_and_count;
    public string $booking_confirmation;
}

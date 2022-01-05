<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use Spatie\DataTransferObject\DataTransferObject;

class TrackingEvent extends DataTransferObject
{
    public string $occurred_at;
    public string|null $carrier_occurred_at;
    public string|null $description;
    public string $city_locality;
    public string $state_province;
    public string $postal_code;
    public string $country_code;
    public string|null $company_name;
    public string|null $signer;
    public string|null $event_code;
    public string $carrier_detail_code;
    #[InArray(['u_n', 'a_c', 'i_t', 'd_e', 'e_x', 'a_t', 'n_y'])]
    public string $status_code;
    public string $status_description;
    public string $carrier_status_code;
    public string $carrier_status_description;
    public float $latitude;
    public float $longitude;
}

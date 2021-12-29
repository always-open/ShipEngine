<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use BluefynInternational\ShipEngine\DTO\Validators\MaxLength;
use BluefynInternational\ShipEngine\DTO\Validators\MinLength;
use Spatie\DataTransferObject\DataTransferObject;

class ShipmentAddress extends DataTransferObject
{
    #[MinLength(1)]
    public string $name;
    #[MinLength(1, allowNull: true)]
    public string|null $phone;
    public string|null $company_name;
    #[MinLength(1)]
    public string $address_line1;
    public string|null $address_line2;
    public string|null $address_line3;
    #[MinLength(1)]
    public string $city_locality;
    #[MinLength(1)]
    public string $state_province;
    #[MinLength(1)]
    public string $postal_code;
    #[MinLength(2), MaxLength(2)]
    public string $country_code;
    #[InArray(['unknown', 'yes', 'no'])]
    public string $address_residential_indicator;
}

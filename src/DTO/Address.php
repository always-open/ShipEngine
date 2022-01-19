<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use BluefynInternational\ShipEngine\DTO\Validators\MaxLength;
use BluefynInternational\ShipEngine\DTO\Validators\MinLength;
use Spatie\DataTransferObject\DataTransferObject;

class Address extends DataTransferObject
{
    public string|null $name;
    public string|null $phone;
    public string|null $company_name;
    public string $address_line1;
    public string|null $address_line2;
    public string|null $address_line3;
    public string $city_locality;
    public string $state_province;
    public string $postal_code;
    #[MaxLength(2)]
    #[MinLength(2, allowNull: true)]
    public string|null $country_code;
    #[InArray(['unknown', 'yes', 'no'])]
    public string $address_residential_indicator;
}

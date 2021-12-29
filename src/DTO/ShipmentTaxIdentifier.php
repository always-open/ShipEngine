<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use Spatie\DataTransferObject\DataTransferObject;

class ShipmentTaxIdentifier extends DataTransferObject
{
    #[InArray(['shipper', 'recipient'])]
    public string $taxable_entity_type;
    #[InArray(['vat', 'eori', 'ssn', 'ein', 'tin', 'ioss', 'pan', 'voec'])]
    public string $identifier_type;
    public string $issuing_authority;
    public string $value;
}

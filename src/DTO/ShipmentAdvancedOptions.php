<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use BluefynInternational\ShipEngine\DTO\Validators\MaxLength;
use BluefynInternational\ShipEngine\DTO\Validators\MinLength;
use Spatie\DataTransferObject\DataTransferObject;

class ShipmentAdvancedOptions extends DataTransferObject
{
    public string|null $bill_to_account;
    #[MinLength(2, allowNull: true), MaxLength(2)]
    public string|null $bill_to_country_code;
    #[InArray(['recipient', 'third_party'])]
    public string|null $bill_to_party;
    public string|null $bill_to_postal_code;
    public bool $contains_alcohol;
    public bool $delivered_duty_paid;
    public bool $dry_ice;
    public Weight|null $dry_ice_weight;
    public bool $non_machinable;
    public bool $saturday_delivery;
    public FedexFreight|null $fedex_freight;
    public bool|null $use_ups_ground_freight_pricing;
    public string|null $freight_class;
    #[MaxLength(100)]
    public string|null $custom_field1;
    #[MaxLength(100)]
    public string|null $custom_field2;
    #[MaxLength(100)]
    public string|null $custom_field3;
    #[InArray(['pickup', 'drop_off'])]
    public string|null $origin_type;
    public bool|null $shipper_release;
    public ShipmentCollectOnDelivery|null $collect_on_delivery;
}

<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
use AlwaysOpen\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\DataTransferObject;

class ShipmentRate extends DataTransferObject
{
    #[Regex('/^se(-[a-z0-9]+)+$/', allowNull: true)]
    public string|null $rate_id;
    #[InArray(['check', 'shipment'])]
    public string $rate_type;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $carrier_id;
    public CurrencyAmount $shipping_amount;
    public CurrencyAmount $insurance_amount;
    public CurrencyAmount $confirmation_amount;
    public CurrencyAmount $other_amount;
    public CurrencyAmount $tax_amount;
    public int|null $zone;
    public string|null $package_type;
    public int $delivery_days;
    public bool $guaranteed_service;
    public string $estimated_delivery_date;
    public string $carrier_delivery_days;
    public string $ship_date;
    public bool $negotiated_rate;
    public string $service_type;
    public string $service_code;
    public bool $trackable;
    public string $carrier_code;
    public string $carrier_nickname;
    public string $carrier_friendly_name;
    #[InArray(['valid', 'invalid', 'has_warnings', 'unknown'])]
    public string $validation_status;
    public array $warning_messages;
    public array $error_messages;
}

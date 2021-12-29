<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use BluefynInternational\ShipEngine\DTO\Validators\MaxLength;
use BluefynInternational\ShipEngine\Util\Constants\OrderSource;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;
use BluefynInternational\ShipEngine\DTO\Validators\Regex;

class Shipment extends DataTransferObject
{
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $shipment_id;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $carrier_id;
    public string $service_code;
    public string|null $external_order_id;
    /** @var ShipmentItem[] */
    #[CastWith(ArrayCaster::class, itemType: ShipmentItem::class)]
    public array $items;
    /** @var ShipmentTaxIdentifier[] */
    #[CastWith(ArrayCaster::class, itemType: ShipmentTaxIdentifier::class)]
    public array|null $tax_identifiers;
    #[MaxLength(50)]
    public string $external_shipment_id;
    #[Regex('/^\d{4}-\d{2}-\d{2}(T\d{2}:\d{2}:\d{2}(\.\d+)?(Z|[-+]\d{2}:\d{2}))?$/')]
    public string $ship_date;
    #[Regex('/^\d{4}-\d{2}-\d{2}(T\d{2}:\d{2}:\d{2}(\.\d+)?(Z|[-+]\d{2}:\d{2}))?$/')]
    public string $created_at;
    #[Regex('/^\d{4}-\d{2}-\d{2}(T\d{2}:\d{2}:\d{2}(\.\d+)?(Z|[-+]\d{2}:\d{2}))?$/')]
    public string $modified_at;
    #[InArray(['pending', 'processing', 'label_purchased', 'cancelled'])]
    public string $shipment_status;
    public ShipmentAddress $ship_to;
    public ShipmentAddress $ship_from;
    #[MaxLength(25)]
    public string|null $warehouse_id;
    public ShipmentAddress $return_to;
    #[InArray(['none', 'delivery', 'signature', 'adult_signature', 'direct_signature', 'delivery_mailed', 'verbal_confirmation'])]
    public string $confirmation;
    public ShipmentCustoms $customs;
    public ShipmentAdvancedOptions $advanced_options;
    #[InArray(['pickup', 'drop_off'])]
    public string|null $origin_type;
    #[InArray(['none', 'shipsurance', 'carrier', 'third_party'])]
    public string $insurance_provider;
    /** @var Tag[] */
    #[CastWith(ArrayCaster::class, itemType: Tag::class)]
    public array $tags;
    #[InArray(OrderSource::ALL_SOURCES)]
    public string $order_source_code;
    public array $packages;
    public Weight $total_weight;
}

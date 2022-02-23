<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use BluefynInternational\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class ShippingRateRequestResponse extends DataTransferObject
{
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $shipment_id;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $carrier_id;
    #[Regex('/^[a-z0-9]+(_[a-z0-9-]+)* ?$/')]
    public string $service_code;
    public string|null $external_order_id;
    #[CastWith(ArrayCaster::class, itemType: ShipmentItem::class)]
    public array $item;
    #[CastWith(ArrayCaster::class, itemType: ShipmentTaxIdentifier::class)]
    public array $tax_identifiers;
    public string|null $external_shipment_id;
    #[Regex('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d+)?(Z|[-+]\d{2}:\d{2})$/')]
    public string $ship_date;
    #[Regex('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d+)?(Z|[-+]\d{2}:\d{2})$/')]
    public string $created_at;
    #[Regex('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d+)?(Z|[-+]\d{2}:\d{2})$/')]
    public string $modified_at;
    #[InArray(['pending', 'processing', 'label_purchased', 'cancelled'])]
    public string $shipment_status;
    public Address $ship_to;
    public Address $ship_from;
    #[Regex('/^se(-[a-z0-9]+)+$/', allowNull: true)]
    public string|null $warehouse_id;
    public Address $return_to;
    #[InArray(['none', 'delivery', 'signature', 'adult_signature', 'direct_signature', 'delivery_mailed', 'verbal_confirmation'])]
    public string $confirmation;
    public ShipmentCustoms|null $customs;
    public ShipmentAdvancedOptions|null $advanced_options;
    public string|null $origin_type;
    #[InArray(['none', 'shipsurance', 'carrier', 'third_party'])]
    public string|null $insurance_provider;
    #[CastWith(ArrayCaster::class, itemType: Tag::class)]
    public array $tags;
    #[InArray(['amazon_ca', 'amazon_us', 'brightpearl', 'channel_advisor', 'cratejoy', 'ebay', 'etsy', 'jane', 'groupon_goods', 'magento', 'paypal', 'seller_active', 'shopify', 'stitch_labs', 'squarespace', 'three_dcart', 'tophatter', 'walmart', 'woo_commerce', 'volusion'])]
    public string|null $order_source_code;
    #[CastWith(ArrayCaster::class, itemType: Package::class)]
    public array $packages;
    public Weight $total_weight;
    public RateResponse $rate_response;
}

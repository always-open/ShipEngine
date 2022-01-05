<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use BluefynInternational\ShipEngine\DTO\Validators\MinLength;
use BluefynInternational\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class Label extends DataTransferObject
{
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $label_id;
    #[InArray(['processing', 'completed', 'error', 'voided'])]
    public string $status;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $shipment_id;
    public string $ship_date;
    public string $created_at;
    public CurrencyAmount $shipment_cost;
    public CurrencyAmount $insurance_cost;
    #[MinLength(1)]
    public string $tracking_number;
    public bool $is_return_label;
    public string|null $rma_number;
    public bool $is_international;
    public string $batch_id;
    public string $carrier_id;
    #[InArray(['carrier_default', 'on_creation', 'on_carrier_acceptance'])]
    public string $charge_event;
    public string $service_code;
    public string $package_code;
    public bool $voided;
    public string|null $voided_at;
    #[InArray(\BluefynInternational\ShipEngine\Util\Constants\Label::ALL_FORMATS)]
    public string $label_format;
    #[InArray(['label', 'qr_code'])]
    public string $display_scheme;
    #[InArray(['4x6', 'letter'])]
    public string $label_layout;
    public bool $trackable;
    public string|null $label_image_id;
    public string $carrier_code;
    #[InArray(['unknown', 'in_transit', 'error', 'delivered'])]
    public string $tracking_status;
    public LabelDownload $label_download;
    public FormDownload|null $form_download;
    public FormDownload|null $insurance_claim;
    #[CastWith(ArrayCaster::class, itemType: Package::class)]
    public array $packages;
}

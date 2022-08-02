<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\DataTransferObject;

class Manifest extends DataTransferObject
{
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $manifest_id;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $form_id;
    public string $created_at;
    public string $ship_date;
    public int $shipments;
    public array $label_ids;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $warehouse_id;
    public string $submission_id;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $carrier_id;
    public ManifestDownload $manifest_download;
}

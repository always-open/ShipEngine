<?php

namespace AlwaysOpen\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ManifestDownload extends DataTransferObject
{
    public string|null $href;
}

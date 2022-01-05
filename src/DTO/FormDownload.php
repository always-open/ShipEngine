<?php

namespace BluefynInternational\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class FormDownload extends DataTransferObject
{
    public string $href;
    public string $type;
}

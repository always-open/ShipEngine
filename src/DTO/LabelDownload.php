<?php

namespace BluefynInternational\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class LabelDownload extends DataTransferObject
{
    public string $href;
    public string $pdf;
    public string $png;
    public string $zpl;
}

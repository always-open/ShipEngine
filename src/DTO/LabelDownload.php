<?php

namespace AlwaysOpen\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class LabelDownload extends DataTransferObject
{
    public string|null $href;
    public string|null $pdf;
    public string|null $png;
    public string|null $zpl;
}

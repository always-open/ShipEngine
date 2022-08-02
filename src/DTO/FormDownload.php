<?php

namespace AlwaysOpen\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class FormDownload extends DataTransferObject
{
    public string|null $href;
    public string|null $type;
}

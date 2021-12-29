<?php

namespace BluefynInternational\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class LabelMessages extends DataTransferObject
{
    public string|null $reference1;
    public string|null $reference2;
    public string|null $reference3;
}

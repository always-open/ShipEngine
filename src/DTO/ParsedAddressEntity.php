<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\GreaterThanOrEquals;
use Spatie\DataTransferObject\DataTransferObject;

class ParsedAddressEntity extends DataTransferObject
{
    public string $type;
    #[GreaterThanOrEquals(0)]
    public float $score;
    public string $text;
    #[GreaterThanOrEquals(0)]
    public int $start_index;
    #[GreaterThanOrEquals(0)]
    public int $end_index;
    public array $result;
}

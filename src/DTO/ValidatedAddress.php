<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Casters\NullableArrayCaster;
use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class ValidatedAddress extends DataTransferObject
{
    #[InArray(['unverified', 'verified', 'warning', 'error'])]
    public string $status;
    public array $original_address;
    public Address|null $matched_address;
    #[CastWith(NullableArrayCaster::class, itemType: ValidatedAddressMessage::class)]
    public array $messages;
}

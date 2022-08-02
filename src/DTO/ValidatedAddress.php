<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Casters\NullableArrayCaster;
use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class ValidatedAddress extends DataTransferObject
{
    #[InArray(['unverified', 'verified', 'warning', 'error'])]
    public string|null $status;
    public array|null $original_address;
    public Address|null $matched_address;
    #[CastWith(NullableArrayCaster::class, itemType: ValidatedAddressMessage::class)]
    public array|null $messages;
}

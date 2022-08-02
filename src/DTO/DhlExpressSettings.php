<?php

namespace AlwaysOpen\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class DhlExpressSettings extends DataTransferObject
{
    public string $nickname;
    public bool $should_hide_account_number_on_archive_doc;
    public bool $is_primary_account;
}

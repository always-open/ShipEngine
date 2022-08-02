<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\DataTransferObject;

class UpsSettingsInvoice extends DataTransferObject
{
    public string $invoice_date;
    public string $invoice_number;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $control_id;
    public float $invoice_amount;
    public string $invoice_currency_code;
}

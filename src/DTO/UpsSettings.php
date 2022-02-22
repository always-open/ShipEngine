<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\InArray;
use BluefynInternational\ShipEngine\DTO\Validators\MinLength;
use Spatie\DataTransferObject\DataTransferObject;

class UpsSettings extends DataTransferObject
{
    public string $nickname;
    public bool $is_primary_account;
    #[InArray(['daily_pickup', 'occasional_pickup', 'customer_counter'])]
    public string $pickup_type;
    public bool $use_carbon_neutral_shipping_program;
    public bool $use_ground_freight_pricing;
    public bool $use_consolidation_services;
    public bool $use_order_number_on_mail_innovations_labels;
    #[InArray(['none', 'return_service_requested', 'forwarding_service_requested', 'address_service_requested', 'change_service_requested', 'leave_if_no_response'])]
    public bool $mail_innovations_endorsement;
    public bool $mail_innovations_cost_center;
    public bool $use_negotiated_rates;
    #[MinLength(5)]
    public string $account_postal_code;
    public UpsSettingsInvoice $invoice;
}

<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
use Spatie\DataTransferObject\DataTransferObject;

class Error extends DataTransferObject
{
    #[InArray(['carrier', 'order_source', 'shipengine'])]
    public string $error_source;
    #[InArray(['account_status', 'business_rules', 'validation', 'security', 'system', 'integrations'])]
    public string $error_type;
    #[InArray(['auto_fund_not_supported', 'batch_cannot_be_modified', 'carrier_conflict', 'carrier_disconnected', 'carrier_not_connected', 'carrier_not_supported', 'confirmation_not_supported', 'default_warehouse_cannot_be_deleted', 'field_conflict', 'field_value_required', 'forbidden', 'identifier_conflict', 'identifiers_must_match', 'insufficient_funds', 'invalid_address', 'invalid_billing_plan', 'invalid_field_value', 'invalid_identifier', 'invalid_status', 'invalid_string_length', 'label_images_not_supported', 'meter_failure', 'order_source_not_active', 'rate_limit_exceeded', 'refresh_not_supported', 'request_body_required', 'return_label_not_supported', 'settings_not_supported', 'subscription_inactive', 'terms_not_accepted', 'tracking_not_supported', 'trial_expired', 'unauthorized', 'unknown', 'unspecified', 'verification_failure', 'warehouse_conflict', 'webhook_event_type_conflict'])]
    public string $error_code;
    public string $message;
}

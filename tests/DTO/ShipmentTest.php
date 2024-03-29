<?php

namespace AlwaysOpen\ShipEngine\Tests\DTO;

use AlwaysOpen\ShipEngine\DTO\Shipment;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AlwaysOpen\ShipEngine\DTO\Shipment
 */
class ShipmentTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @test
     */
    public function shipmentDTOInstantiatesCorrectly(): void
    {
        $json = json_decode('{
  "shipment_id": "se-28529731",
  "carrier_id": "se-28529731",
  "service_code": "usps_first_class_mail",
  "external_order_id": "string",
  "items": [],
  "tax_identifiers": [
    {
      "taxable_entity_type": "shipper",
      "identifier_type": "vat",
      "issuing_authority": "string",
      "value": "string"
    }
  ],
  "external_shipment_id": "string",
  "ship_date": "2018-09-23T00:00:00.000Z",
  "created_at": "2018-09-23T15:00:00.000Z",
  "modified_at": "2018-09-23T15:00:00.000Z",
  "shipment_status": "pending",
  "ship_to": {
    "name": "John Doe",
    "phone": "+1 204-253-9411 ext. 123",
    "company_name": "The Home Depot",
    "address_line1": "1999 Bishop Grandin Blvd.",
    "address_line2": "Unit 408",
    "address_line3": "Building #7",
    "city_locality": "Winnipeg",
    "state_province": "Manitoba",
    "postal_code": "78756-3717",
    "country_code": "CA",
    "address_residential_indicator": "no"
  },
  "ship_from": {
    "name": "John Doe",
    "phone": "+1 204-253-9411 ext. 123",
    "company_name": "The Home Depot",
    "address_line1": "1999 Bishop Grandin Blvd.",
    "address_line2": "Unit 408",
    "address_line3": "Building #7",
    "city_locality": "Winnipeg",
    "state_province": "Manitoba",
    "postal_code": "78756-3717",
    "country_code": "CA",
    "address_residential_indicator": "no"
  },
  "warehouse_id": "se-28529731",
  "return_to": {
    "name": "John Doe",
    "phone": "+1 204-253-9411 ext. 123",
    "company_name": "The Home Depot",
    "address_line1": "1999 Bishop Grandin Blvd.",
    "address_line2": "Unit 408",
    "address_line3": "Building #7",
    "city_locality": "Winnipeg",
    "state_province": "Manitoba",
    "postal_code": "78756-3717",
    "country_code": "CA",
    "address_residential_indicator": "no"
  },
  "confirmation": "none",
  "customs": {
    "contents": "merchandise",
    "non_delivery": "return_to_sender",
    "customs_items": []
  },
  "advanced_options": {
    "bill_to_account": null,
    "bill_to_country_code": "CA",
    "bill_to_party": "recipient",
    "bill_to_postal_code": null,
    "contains_alcohol": false,
    "delivered_duty_paid": false,
    "dry_ice": false,
    "dry_ice_weight": {
      "value": 0,
      "unit": "pound"
    },
    "non_machinable": false,
    "saturday_delivery": false,
    "fedex_freight": {
      "shipper_load_and_count": "string",
      "booking_confirmation": "string"
    },
    "use_ups_ground_freight_pricing": null,
    "freight_class": 77.5,
    "custom_field1": null,
    "custom_field2": null,
    "custom_field3": null,
    "origin_type": "pickup",
    "shipper_release": null,
    "collect_on_delivery": {
      "payment_type": "any",
      "payment_amount": {
        "currency": "usd",
        "amount": 0
      }
    }
  },
  "origin_type": "pickup",
  "insurance_provider": "none",
  "tags": [],
  "order_source_code": "amazon_ca",
  "packages": [
    {
      "package_id": 0,
      "description": null,
      "package_code": "small_flat_rate_box",
      "weight": {
        "value": 0,
        "unit": "pound"
      },
      "dimensions": {
        "unit": "inch",
        "length": 0,
        "width": 0,
        "height": 0
      },
      "insured_value": {
        "0": {
          "currency": "usd",
          "amount": 0
        },
        "currency": "usd",
        "amount": 0
      },
      "tracking_number": "1Z932R800392060079",
      "label_messages": {
        "reference1": null,
        "reference2": null,
        "reference3": null
      },
      "external_package_id": "string",
      "label_download": {
        "href": "http://api.shipengine.com/v1/labels/se-28529731",
        "pdf": "http://api.shipengine.com/v1/labels/se-28529731",
        "png": "http://api.shipengine.com/v1/labels/se-28529731",
        "zpl": "http://api.shipengine.com/v1/labels/se-28529731"
      },
      "form_download": {
        "href": "http://api.shipengine.com/v1/labels/se-28529731",
        "type": "string"
      },
      "sequence": 0
    }
  ],
  "total_weight": {
    "value": 0,
    "unit": "pound"
  }
}', true);

        $shipment_dto = new Shipment($json);

        $this->assertNotNull($shipment_dto);
    }
}

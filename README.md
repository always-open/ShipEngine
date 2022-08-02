# ShipEngine

[![Latest Version on Packagist](https://img.shields.io/packagist/v/always-open/shipengine.svg?style=flat-square)](https://packagist.org/packages/always-open/shipengine)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/always-open/shipengine/run-tests?label=tests)](https://github.com/always-open/shipengine/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/always-open/shipengine/Check%20&%20fix%20styling?label=code%20style)](https://github.com/always-open/shipengine/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/always-open/shipengine.svg?style=flat-square)](https://packagist.org/packages/always-open/shipengine)
<a href="https://codeclimate.com/github/always-open/ShipEngine/maintainability"><img src="https://api.codeclimate.com/v1/badges/6817ad06980c52a8343d/maintainability" /></a>

Wrapper around ShipEngine API

## Installation

You can install the package via composer:

```bash
composer require always-open/shipengine
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="shipengine-config"
```

This is the contents of the published config file:

```php
return [
    /*
    |--------------------------------------------------------------------------
    | ShipEngine configurations
    |--------------------------------------------------------------------------
    |
    | API Key used to authenticate with ShipEngine APIs.
    | https://www.shipengine.com/docs/auth/
    |
    */
    'credentials' => [
        'key' => env('SHIP_ENGINE_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | ShipEngine configurations
    |--------------------------------------------------------------------------
    |
    | Values used to set configuration of ShipEngine API integration.
    |
    */
    'endpoint' => [
        'version'  => env('SHIP_ENGINE_API_VERSION', 'v1'),
        'base'     => env('SHIP_ENGINE_ENDPOINT', 'https://api.shipengine.com/'),
    ],
    'retries'  => env('SHIP_ENGINE_RETRIES', 1),
    'response' => [
        'as_object' => env('SHIP_ENGINE_RESPONSE_AS_OBJECT', false),
        'page_size' => env('SHIP_ENGINE_RESPONSE_PAGE_SIZE', 50),
    ],
    'timeout' => 'PT10S',
];
```

## Usage

### Config
To use the ShipEngine wrapper you must first instantiate a new instance.

By default, the config information is read out of the config file but can be overridden on the fly. This can be done 
when instantiating a new instance, which will impact all subsequent calls, or when making the call.
```php
// Use default config settings from `config/shipengine.php`
$shipengine = new AlwaysOpen\ShipEngine\ShipEngine();
// Override config which will impact all calls made with this instance
$config = new \AlwaysOpen\ShipEngine\ShipEngineConfig(['asObject' => true]);
$custom_shipengine = new AlwaysOpen\ShipEngine\ShipEngine($config);
// Override config on a single specific call
$shipengine->listShipments(config: ['asObject' => true]);
```

### Making calls
To make calls to the ShipEngine API you must have credentials setup within ShipEngine itself. Those API credentials will 
then be used by this library to handle the calls and responses.

**_NOTE:_** This library is still in the 0.x.x stages and not all endpoints are fully mapped. We are working towards 100% 
coverage of existing API endpoints.

Method names should match documentation names of API endpoints from official [ShipEngine API Docs](https://shipengine.github.io/shipengine-openapi/).

#### Example calls
Here is a sample of how to get a listing of shipments as well as the difference between `asObject => false` and `asObject => true`.
```php
$shipengine = new AlwaysOpen\ShipEngine\ShipEngine();
$shipengine->listShipments();
//[
//    "shipments" => [
//        [
//            "shipment_id" => "se-123456789",
//            "carrier_id" => "se-123456",
//            ...
//        ],
//        [...],
//    ],
//    "total" => 12,
//    "page" => 1,
//    "pages" => 1,
//    "links" => [
//        "first" => [
//             "href" => "https://api.shipengine.com/v1/shipments?page=1&page_size=25",
//        ],
//        "last" => [
//             "href" => "https://api.shipengine.com/v1/shipments?page=1&page_size=25",
//        ],
//        "prev" => [],
//        "next" => [],
//     ],
//];
$shipengine->listShipments(config: ['asObject' => true]);
// [
//     "shipments" => [
//       AlwaysOpen\ShipEngine\DTO\Shipment {#4070
//           +shipment_id: "se-123456789",
//           +carrier_id: "se-123456",
//            ...
//        ],
//        [...],
//    ],
//    "total" => 12,
//    "page" => 1,
//    "pages" => 1,
//    "links" => [
//        "first" => [
//             "href" => "https://api.shipengine.com/v1/shipments?page=1&page_size=25",
//        ],
//        "last" => [
//             "href" => "https://api.shipengine.com/v1/shipments?page=1&page_size=25",
//        ],
//        "prev" => [],
//        "next" => [],
//     ],
//];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [AlwaysOpen](https://github.com/AlwaysOpen)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

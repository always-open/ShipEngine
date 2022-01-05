# ShipEngine

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bluefyn-international/shipengine.svg?style=flat-square)](https://packagist.org/packages/bluefyn-international/shipengine)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/bluefyn-international/shipengine/run-tests?label=tests)](https://github.com/bluefyn-international/shipengine/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/bluefyn-international/shipengine/Check%20&%20fix%20styling?label=code%20style)](https://github.com/bluefyn-international/shipengine/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bluefyn-international/shipengine.svg?style=flat-square)](https://packagist.org/packages/bluefyn-international/shipengine)

Wrapper around ShipEngine API

## Installation

You can install the package via composer:

```bash
composer require bluefyn-international/shipengine
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
];
```

## Usage

```php
$shipengine = new BluefynInternational\ShipEngine();
$shipengine->
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

- [BluefynInternational](https://github.com/BluefynInternational)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

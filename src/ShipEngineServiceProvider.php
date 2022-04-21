<?php

namespace BluefynInternational\ShipEngine;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ShipEngineServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('shipengine')
            ->hasConfigFile();

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }
}

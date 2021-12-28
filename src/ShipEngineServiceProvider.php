<?php

namespace Bluefyn International\ShipEngine;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Bluefyn International\ShipEngine\Commands\ShipEngineCommand;

class ShipEngineServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('shipengine')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_shipengine_table')
            ->hasCommand(ShipEngineCommand::class);
    }
}

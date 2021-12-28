<?php

namespace Bluefyn International\ShipEngine\Commands;

use Illuminate\Console\Command;

class ShipEngineCommand extends Command
{
    public $signature = 'shipengine';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

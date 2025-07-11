<?php

namespace Alexstericris\AlecrisAiApis\Commands;

use Illuminate\Console\Command;

class ExamplePackageCommand extends Command
{
    public $signature = 'example-package';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

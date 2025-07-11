<?php

namespace Alexstericris\AlecrisAiApis\Tests;

use Alexstericris\AlecrisAiApis\AlecrisAiApis;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

    }

    protected function getPackageProviders($app)
    {
        return [
            AlecrisAiApis::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_example-package_table.php.stub';
        $migration->up();
        */
    }
}

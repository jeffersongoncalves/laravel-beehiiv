<?php

namespace JeffersonGoncalves\Beehiiv\Tests;

use JeffersonGoncalves\Beehiiv\BeehiivServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            BeehiivServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('beehiiv.api_key', 'test-api-key');
        $app['config']->set('beehiiv.publication_id', 'pub_00000000-0000-0000-0000-000000000000');
    }
}

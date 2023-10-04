<?php

namespace GuzzleHttp\Profiling\Clockwork\Tests;

use Clockwork\Support\Laravel\ClockworkServiceProvider;
use GuzzleHttp\Profiling\Clockwork\GuzzleClockworkServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            GuzzleClockworkServiceProvider::class,
            ClockworkServiceProvider::class,
        ];
    }
}

<?php

namespace GuzzleHttp\Profiling\Clockwork;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class GuzzleClockworkServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [ClientInterface::class,];
    }

    public function register(): void
    {
        // Configuring all guzzle clients.
        $this->app->bind(ClientInterface::class, function(): ClientInterface {
            return new Client([
                'handler' => GuzzleClockworkHandlerStackFactory::byClockwork($this->app->make('clockwork'))
            ]);
        });
    }
}

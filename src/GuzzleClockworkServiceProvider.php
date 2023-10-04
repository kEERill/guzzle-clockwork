<?php

namespace GuzzleHttp\Profiling\Clockwork;

use Clockwork\Clockwork;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Profiling\Middleware;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider as ServiceProviderBase;

class GuzzleClockworkServiceProvider extends ServiceProviderBase
{
    private function makeClockwork(): Clockwork
    {
        return $this->app->make('clockwork');
    }

    public function register(): void
    {
        // Configuring all guzzle clients.
        $this->app->bind(ClientInterface::class, function (): ClientInterface {
            return new Client([
                'handler' => GuzzleClockworkHandlerStackFactory::byClockwork($this->makeClockwork()),
            ]);
        });
    }

    public function boot(): void
    {
        Http::globalMiddleware(new Middleware(new Profiler($this->makeClockwork()->timeline())));
    }
}

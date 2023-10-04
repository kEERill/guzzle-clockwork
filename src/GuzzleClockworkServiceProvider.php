<?php

namespace GuzzleHttp\Profiling\Clockwork;

use Clockwork\Clockwork;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Profiling\Middleware;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class GuzzleClockworkServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [ClientInterface::class];
    }

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

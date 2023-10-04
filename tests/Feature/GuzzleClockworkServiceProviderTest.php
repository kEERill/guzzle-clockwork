<?php

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Profiling\Middleware;
use Illuminate\Support\Facades\Http;

it('get client from container', function () {
    /** @var Client $client */
    $client = app()->make(ClientInterface::class);

    $this->assertInstanceOf(Client::class, $client);

    /** @var HandlerStack $handlerStack */
    $handlerStack = (fn () => $this->config['handler'])
        ->call($client);

    $middlewareIndex = (fn () => $this->findByName('guzzle-clockwork'))
        ->call($handlerStack);

    $this->assertEquals(0, $middlewareIndex);
});

it('has middleware in laravel http client', function () {
    $factory = Http::getFacadeRoot();
    $middlewares = (fn () => $this->globalMiddleware)->call($factory);

    $this->assertCount(1, $middlewares);
    $this->assertInstanceOf(Middleware::class, $middlewares[0]);
});

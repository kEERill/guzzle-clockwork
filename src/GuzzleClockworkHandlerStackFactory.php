<?php

namespace GuzzleHttp\Profiling\Clockwork;

use Clockwork\Clockwork;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Profiling\Middleware;

class GuzzleClockworkHandlerStackFactory
{
    private function __construct(
        protected Clockwork $clockwork
    ) {
    }

    private function make(): HandlerStack
    {
        return tap(HandlerStack::create(), function (HandlerStack $handlerStack) {
            $handlerStack->unshift(new Middleware(new Profiler($this->clockwork->timeline())));
        });
    }

    public static function byClockwork(Clockwork $clockwork): HandlerStack
    {
        return (new GuzzleClockworkHandlerStackFactory($clockwork))
            ->make();
    }
}

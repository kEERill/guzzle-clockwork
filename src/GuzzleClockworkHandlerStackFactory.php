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
        $stack = HandlerStack::create();

        $stack->unshift(new Middleware(
            new Profiler($this->clockwork->timeline())
        ));

        return $stack;
    }

    public static function byClockwork(Clockwork $clockwork): HandlerStack
    {
        return (new GuzzleClockworkHandlerStackFactory($clockwork))
            ->make();
    }
}
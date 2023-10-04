<?php

namespace GuzzleHttp\Profiling\Clockwork;

use Clockwork\Request\Timeline\Timeline;
use GuzzleHttp\Profiling\DescriptionMaker;
use GuzzleHttp\Profiling\Profiler as ProfilerContract;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Profiler implements ProfilerContract
{
    use DescriptionMaker;

    public function __construct(protected Timeline $timeline)
    {
    }

    public function add(float $start, float $end, RequestInterface $request, ResponseInterface $response = null): void
    {
        $description = $this->describe($request, $response);

        $this->timeline->event($description, compact('start', 'end'));
    }
}

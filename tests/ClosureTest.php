<?php

namespace tests;

use rkistaps\benchmark\Benchmark;

/**
 * Test closure measuring
 */
class ClosureTest extends TestBase
{
    /**
     * Test measure
     * @throws \rkistaps\benchmark\BenchmarkException
     */
    public function testClosure()
    {
        $sleepFor = 3;

        $result = Benchmark::measure(function () use ($sleepFor) {
            $this->sleep($sleepFor);
        });

        $this->assertEquals($sleepFor, round($result->executionTime));
    }
}
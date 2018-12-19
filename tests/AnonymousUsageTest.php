<?php

namespace tests;

use rkistaps\benchmark\Benchmark;
use rkistaps\benchmark\BenchmarkException;

/**
 * Class AnonymousUsageTest
 * @package tests
 */
class AnonymousUsageTest extends TestBase
{
    /**
     * Tests anonymous usage
     *
     * @throws BenchmarkException
     */
    public function testAnonUsage()
    {
        $secToSleep = 0.5;

        $bench = new Benchmark();
        $bench->start();

        $this->sleep($secToSleep);
        $result = $bench->end();

        $this->assertEquals($secToSleep, round($result->executionTime,2));
    }

    /**
     * Tests anonymous nested usage
     *
     * @throws BenchmarkException
     */
    public function testAnonNestedUsage()
    {
        $secToSleepA = 0.5;
        $secToSleepB = 0.25;

        $bench = new Benchmark();

        // Start outer benchmark
        $bench->start();
       $this->sleep($secToSleepA);

        // Start inner benchmark
        $bench->start();

        $this->sleep($secToSleepB);

        // End inner benchmark
        $resultB = $bench->end();

        // End outer benchmark
        $resultA = $bench->end();

        $this->assertEquals($secToSleepB, round($resultB->executionTime, 2));
        $this->assertEquals($secToSleepA + $secToSleepB, round($resultA->executionTime,2));
    }
}

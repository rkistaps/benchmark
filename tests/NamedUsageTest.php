<?php

namespace tests;

use rkistaps\benchmark\Benchmark;
use rkistaps\benchmark\BenchmarkException;

/**
 * Class NamedUsageTest
 * @package tests
 */
class NamedUsageTest extends TestBase
{
    /**
     * Tests named usage
     *
     * @throws BenchmarkException
     */
    public function testNamedUsage()
    {
        $secToSleep = 1;

        $name = 'BenchmarkName';

        $bench = new Benchmark();

        $bench->start($name);
        $this->sleep($secToSleep);
        $result = $bench->end($name);

        $this->assertEquals($secToSleep, round($result->executionTime, 2));
    }

    /**
     * Tests named nested usage
     *
     * @throws BenchmarkException
     */
    public function testNamedNestedUsage()
    {
        $nameA = 'BenchmarkNameA';
        $nameB = 'BenchmarkNameB';

        $secToSleepA = 0.75;
        $secToSleepB = 0.5;

        $bench = new Benchmark();

        // Start outer benchmark
        $bench->start($nameA);
        $this->sleep($secToSleepA);
        // Start inner benchmark
        $bench->start($nameB);

        $this->sleep($secToSleepB);

        // End inner benchmark
        $resultB = $bench->end($nameB);

        // End outer benchmark
        $resultA = $bench->end($nameA);

        $this->assertEquals($secToSleepB, round($resultB->executionTime, 2));
        $this->assertEquals($secToSleepA + $secToSleepB, round($resultA->executionTime, 2));
    }
}
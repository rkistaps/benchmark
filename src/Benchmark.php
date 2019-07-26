<?php

namespace rkistaps\benchmark;

use Closure;

/**
 * Class Benchmark
 * @package rkistaps\benchmark
 */
class Benchmark
{
    /** @var array */
    private $stack = [];

    /** @var array */
    private $anonStack = [];

    /**
     * @param string|null $name
     * @throws BenchmarkException
     */
    public function start(string $name = null)
    {
        if (!is_null($name) && in_array($name, $this->stack)) {
            throw new BenchmarkException('Benchmark with name ' . $name . ' already running');
        }

        $startTime = microtime(true);

        if (is_null($name)) {
            array_push($this->anonStack, $startTime);
        } else {
            $this->stack[$name] = $startTime;
        }
    }

    /**
     * Ends benchmark
     *
     * @param string $name
     * @return BenchmarkResult
     * @throws BenchmarkException
     */
    public function end(string $name = null): BenchmarkResult
    {
        if (is_null($name) && empty($this->anonStack)) {
            throw new BenchmarkException("No anonymous benchmark running");
        }

        if (!is_null($name) && !isset($this->stack[$name])) {
            throw new BenchmarkException('Benchmark with name ' . $name . ' not running');
        }

        $start = is_null($name) ? array_pop($this->anonStack) : $this->stack[$name];
        $end = microtime(true);

        $result = new BenchmarkResult();

        $result->startTime = $start;
        $result->endTime = $end;
        $result->executionTime = $end - $start;
        $result->memoryPeak = memory_get_usage(true);

        return $result;
    }

    /**
     * Measure closure execution time
     * @param Closure $callable $callable
     * @return BenchmarkResult
     * @throws BenchmarkException
     */
    public static function measure(Closure $callable): BenchmarkResult
    {
        $bench = new Benchmark();

        $key = uniqid();
        $bench->start($key);

        $callable();

        return $bench->end($key);
    }
}

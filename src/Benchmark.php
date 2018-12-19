<?php

namespace rkistaps\benchmark;

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

        if (!is_null($name) && !in_array($name, $this->stack)) {
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
     * @param callable $callable
     * @return BenchmarkResult
     * @throws BenchmarkException
     */
    public function run(callable $callable): BenchmarkResult
    {
        $arguments = func_get_args();
        array_shift($arguments);

        $key = uniqid();
        $this->start($key);
        call_user_func_array($callable, $arguments);

        return $this->end($key);
    }
}
